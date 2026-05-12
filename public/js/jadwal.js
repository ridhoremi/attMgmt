$(document).ready(function () {
  loadBulan();
  loadTahun();
  loadJadwal();
  loadKaryawan();
  loadshift();
});

function loadJadwal() {
  let bulan = $("#bulan").val();
  let tahun = $("#tahun").val();

  $.ajax({
    url: BASE_URL + "/getJadwal",
    type: "GET",

    data: {
      bulan: bulan,
      tahun: tahun,
    },

    dataType: "json",

    beforeSend: function () {
      $("#theadJadwal").html("");

      $("#tbodyJadwal").html(`
                <tr>
                    <td colspan="100" class="text-center p-4">
                        <div class="spinner-border spinner-border-sm text-primary"></div>
                        Loading...
                    </td>
                </tr>
            `);
    },

    success: function (res) {
      // =========================
      // HEADER
      // =========================

      let thead = "<tr>";

      thead += `
                <th class="text-start sticky-col bg-dark text-white">
                    Nama Karyawan
                </th>
            `;

     const namaHari = [
  "Minggu",
  "Senin",
  "Selasa",
  "Rabu",
  "Kamis",
  "Jumat",
  "Sabtu"
];

for (let i = 1; i <= res.jumlahHari; i++) {
 const tanggal = new Date(`${tahun}-${String(bulan).padStart(2,'0')}-${String(i).padStart(2,'0')}T00:00:00`);

  const hari = namaHari[tanggal.getDay()];
  const tgl = String(i).padStart(2, '0');

  thead += `
    <th class="text-center">
      ${tgl}<br>
      <small>${hari}</small>
    </th>
  `;
}

      thead += "</tr>";

      $("#theadJadwal").html(thead);

     
      // BODY
      let html = "";

      $.each(res.karyawan, function (index, k) {
        html += "<tr>";

        html += `
                    <td class="text-start sticky-col bg-white">
                        ${k.nama}
                    </td>
                `;

        for (let i = 1; i <= res.jumlahHari; i++) {
          let tanggal = `${tahun}-${String(bulan).padStart(2, "0")}-${String(i).padStart(2, "0")}`;

          let shift = "-";

          if (res.map[k.user_id] && res.map[k.user_id][tanggal]) {
            shift = res.map[k.user_id][tanggal];
          }

          html += `
                        <td class="text-center">
                            ${shift}
                        </td>
                    `;
        }

        html += "</tr>";
      });

      $("#tbodyJadwal").html(html);
    },

    error: function (xhr) {
      $("#tbodyJadwal").html(`
                <tr>
                    <td colspan="100" class="text-danger text-center">
                        Gagal load data
                    </td>
                </tr>
            `);

      console.log(xhr.responseText);
    },
  });
}

function tampil_formHapusJadwal() {
  $("#modalHapusJadwal").modal("show");
  $("#formHapusJadwal")[0].reset();
}

function tampil_formTambahJadwal() {
  $("#modalTambahJadwal").modal("show");
  $("#formTambahJadwal")[0].reset();
}

// function simpanJadwal() {
//   $("#formTambahJadwal")
//     .off("submit")
//     .on("submit", function (e) {
//       e.preventDefault();

//       $.ajax({
//         url: BASE_URL + "/jadwal-simpan",
//         type: "POST",
//         data: $(this).serialize(),
//         dataType: "json",

//         success: function (res) {
//           if (res.status) {
//             $("#modalTambahJadwal").modal("hide");
//             $("#formTambahJadwal")[0].reset();

//             Swal.fire({
//               icon: "success",
//               title: "Berhasil",
//               text: res.message,
//             });
//             loadJadwal();
//           } else {
//             Swal.fire({
//               icon: "warning",
//               title: "Warning",
//               text: res.message,
//             });
//           }
//         },

//         error: function (xhr) {
//           console.log(xhr.responseText);

//           Swal.fire({
//             icon: "error",
//             title: "Error",
//             text: "Terjadi kesalahan",
//           });
//         },
//       });
//     });
// }

function simpanJadwal() {
  let btn = $("#btnTambahJadwal");
  let user_id = $("#karyawan").val();
  let machine_id = $("#karyawan option:selected").data("machine");
  console.log({
    user_id: user_id,
    machine_id: machine_id,
    shift_id: $("#shift_id").val(),
    tanggal_mulai: $("#tanggal_mulai").val(),
    tanggal_selesai: $("#tanggal_selesai").val(),
    keterangan: $("#keterangan").val(),
  });

  $.ajax({
    url: BASE_URL + "/jadwal-simpan",
    type: "POST",
    data: {
      user_id: user_id,
      machine_id: machine_id,
      shift_id: $("#shift_id").val(),
      tanggal_mulai: $("#tanggal_mulai").val(),
      tanggal_selesai: $("#tanggal_selesai").val(),
      keterangan: $("#keterangan").val(),
    },
    dataType: "json",
    beforeSend: function () {
      btn.prop("disabled", true);
      btn.html(`
                <span class="spinner-border spinner-border-sm"></span>
                Sedang Menyimpan...
            `);
    },
    success: function (res) {
      console.log(res);
      if (res.status) {
        $("#modalTambah").modal("hide");
        $("#formTambahJadwal")[0].reset();

        Swal.fire({
          icon: "success",
          title: "Berhasil",
          text: res.message,
        });

        loadJadwal();
      } else {
        Swal.fire({
          icon: "warning",
          title: "Warning",
          text: res.message,
        });
      }
    },

    error: function (xhr) {
      console.log(xhr.responseText);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Terjadi kesalahan",
      });
    },

    complete: function () {
      btn.prop("disabled", false);
      btn.html("Simpan Jadwal");
    },
  });
}

function loadKaryawan() {
  $.ajax({
    url: BASE_URL + "/get-karyawan",
    type: "GET",
    dataType: "json",
    success: function (res) {
      let html = `
                <option value="">
                    -- Pilih Karyawan --
                </option>
            `;
      $.each(res.karyawan, function (index, k) {
        html += `
                    <option 
                        value="${k.user_id}"
                        data-machine="${k.machine_id}">
                        
                        ${k.nama} 

                    </option>
                `;
      });
      $("#karyawan").html(html);
      $("#hapus_karyawan").html(html);
    },
  });
}

function loadshift() {
  $.ajax({
    url: BASE_URL + "/get-shift",
    type: "GET",
    dataType: "json",
    success: function (res) {
      let html = `
                <option value="">
                    -- Pilih Shift --
                </option>
            `;
      $.each(res.shift, function (index, k) {
        html += `
                    <option 
                        value="${k.id}">
                        
                        ${k.nama_shift} 

                    </option>
                `;
      });
      $("#shift_id").html(html);
    },
  });
}

function hapusJadwal() {
  let btn = $("#btnHapusJadwal");
  let user_id = $("#hapus_karyawan").val();
  let machine_id = $("#hapus_karyawan option:selected").attr("data-machine");
  let tanggal_mulai = $("#hapus_tanggal_mulai").val();
  let tanggal_selesai = $("#hapus_tanggal_selesai").val();

  console.log({
    user_id: user_id,
    machine_id: machine_id,
    tanggal_mulai: tanggal_mulai,
    tanggal_selesai: tanggal_selesai,
  });

  $.ajax({
    url: BASE_URL + "/jadwal-hapus",
    type: "POST",
    data: {
      user_id: user_id,
      machine_id: machine_id,
      tanggal_mulai: tanggal_mulai,
      tanggal_selesai: tanggal_selesai,
    },
    dataType: "json",
    beforeSend: function () {
      btn.prop("disabled", true);
      btn.html(`
                <span class="spinner-border spinner-border-sm"></span>
                Menghapus...
            `);
    },

    success: function (res) {
      console.log(res);
      if (res.status) {
        $("#modalHapusJadwal").modal("hide");
        Swal.fire({
          icon: "success",
          title: "Berhasil",
          text: res.message,
        });

        loadJadwal();
      } else {
        Swal.fire({
          icon: "warning",
          title: "Warning",
          text: res.message,
        });
      }
    },

    error: function (xhr) {
      console.log(xhr.responseText);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Terjadi kesalahan",
      });
    },
    complete: function () {
      btn.prop("disabled", false);
      btn.html("Hapus");
    },
  });
}

function loadBulan() {
  const namaBulan = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  let bulanSekarang = new Date().getMonth() + 1;

  let html = "";

  namaBulan.forEach((nama, index) => {
    let value = index + 1;
    let selected = value === bulanSekarang ? "selected" : "";

    html += `
            <option value="${value}" ${selected}>
                ${nama}
            </option>
        `;
  });

  $("#bulan").html(html);
}

function loadTahun() {
  let tahunSekarang = new Date().getFullYear();

  let html = "";

  for (let i = tahunSekarang - 5; i <= tahunSekarang + 1; i++) {
    let selected = i == tahunSekarang ? "selected" : "";

    html += `
            <option value="${i}" ${selected}>
                ${i}
            </option>
        `;
  }

  $("#tahun").html(html);
}
