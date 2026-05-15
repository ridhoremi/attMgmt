var dtAbsensi;
var dtPreview;

var method;

$(document).ready(function () {
  if ($("#dtTabel").length) {
    initDataAbsensi();
  }

  if ($("#dtPreview").length) {
    initPreviewTable();
  }
});

function initDataAbsensi() {
  if ($.fn.DataTable.isDataTable("#dtTabel")) {
    $("#dtTabel").DataTable().destroy();
  }

  dtAbsensi = $("#dtTabel").DataTable({
    serverSide: true,
    pageLength: 10,
    deferRender: true,
    ajax: {
      url: BASE_URL + "/listabsensi",
      type: "POST",
      data: function (d) {
        d.start_date = $("#startDate").val();
        d.end_date = $("#endDate").val();
      },
    },
  });
}

function initPreviewTable() {
  if ($.fn.DataTable.isDataTable("#dtPreview")) {
    $("#dtPreview").DataTable().destroy();
  }

  dtPreview = $("#dtPreview").DataTable({
    data: [],
    columns: [
      { data: "no" },
      { data: "user_id" },
      { data: "nama" },
      { data: "checktime" },
      { data: "machine" },
      { data: "status" },
    ],
  });

  $("#btnSimpan").prop("disabled", true);
}

function reloadTable() {
  dtAbsensi.ajax.reload();
}

function import_proses() {
  $.ajax({
    url: BASE_URL + "/import-absensi",
    type: "POST",
    data: new FormData($("#formImport")[0]),
    dataType: "JSON",
    processData: false,
    contentType: false,

    success: function (data) {
      if (data.status === false) {
        Swal.fire({
          icon: "error",
          title: "Import Gagal",
          text: data.message || "Terjadi kesalahan saat import",
        });
        return;
      }

      // console.log("IS ARRAY?", Array.isArray(data));
      // console.log("DATA:", data);
      dtPreview.clear();
      let no = 1;

      data.forEach(function (row) {
        dtPreview.row.add({
          no: no++,
          user_id: row.user_id,
          nama: row.nama,
          checktime: row.checktime,
          machine: row.machine,
          status: row.status,
        });
      });

      dtPreview.draw();
      window.dataImport = data;
      if (data.length > 0) {
        $("#btnSimpan").prop("disabled", false);
      }
    },

    error: function (jqXHR) {
      console.log("STATUS:", jqXHR.status);
      console.log("RESPONSE:", jqXHR.responseText);
    },
  });
}

function simpanData() {
  if (!window.dataImport || window.dataImport.length === 0) {
    alert("Tidak ada data!");
    return;
  }

  $.ajax({
    url: BASE_URL + "/simpan-absensi",
    type: "POST",
    data: {
      data: JSON.stringify(window.dataImport),
    },
    success: function (res) {
      Swal.fire("Berhasil!", "Data Impor Berhasil Disimpan.", "success");

      // dtAbsensi.ajax.reload();
      dtPreview.clear().draw();

      window.dataImport = [];

      $("#btnSimpan").prop("disabled", true);
    },
    error: function (jqXHR) {
      console.log(jqXHR.responseText);
    },
  });
}

function loadKehadiran() {
  let bulan = $("#bulan_rekap").val();
  let tahun = $("#tahun_rekap").val();
  let user_id = $("#karyawan_rekap_absensi").val();
  let machine_id = $("#karyawan_rekap_absensi option:selected").data("machine");

  $.ajax({
    url: BASE_URL + "/get-kehadiran",
    type: "GET",
    data: {
      bulan: bulan,
      tahun: tahun,
      user_id: user_id,
      machine_id: machine_id,
    },
    dataType: "json",

    beforeSend: function () {
      $("#tbodyKehadiran").html(`
                <tr>
                    <td colspan="5" class="text-center">
                        Loading...
                    </td>
                </tr>
            `);
    },

    success: function (res) {
      console.log(res);
      window.dataRekap = res.data;
      let html = "";

      $.each(res.data, function (index, d) {
        let jamMasuk = "-";
        let jamPulang = "-";

        if (d.jam_masuk) {
          jamMasuk = d.jam_masuk.substring(11, 19);
        }

        if (d.jam_pulang) {
          jamPulang = d.jam_pulang.substring(11, 19);
        }

        html += `
                    <tr>

                        <td>${d.nama}</td>

                        <td>${d.tanggal}</td>

                        <td>${d.nama_shift}</td>

                        <td>${jamMasuk}</td>

                        <td>${jamPulang}</td>

                    </tr>
                `;
      });

      if (html == "") {
        html = `
                    <tr>
                        <td colspan="5"
                            class="text-center">

                            Tidak ada data

                        </td>
                    </tr>
                `;
      }

      $("#tbodyKehadiran").html(html);
    },

    error: function (xhr) {
      console.log(xhr.responseText);

      $("#tbodyKehadiran").html(`
                <tr>
                    <td colspan="5"
                        class="text-danger text-center">

                        Gagal load data

                    </td>
                </tr>
            `);
    },
  });
}

function exportExcel() {
  console.log(window.dataRekap);

    if (
        !window.dataRekap ||
        window.dataRekap.length == 0
    ) {

        alert("Data kosong");

        return;
    }

    // FORMAT DATA
    const dataExport =
        window.dataRekap.map((d, index) => ([
            index + 1,

            d.nama,

            d.tanggal,

            d.nama_shift,

            d.jam_masuk
                ? d.jam_masuk.substring(11, 19)
                : "-",

            d.jam_pulang
                ? d.jam_pulang.substring(11, 19)
                : "-"
        ]));

    // HEADER + DATA
    const worksheet =
        XLSX.utils.aoa_to_sheet([

            [
                "No",
                "Nama",
                "Tanggal",
                "Shift",
                "Jam Masuk",
                "Jam Pulang"
            ],

            ...dataExport

        ]);

    // LEBAR KOLOM
    worksheet["!cols"] = [

        { wch: 8 },   // No
        { wch: 35 },  // Nama
        { wch: 18 },  // Tanggal
        { wch: 25 },  // Shift
        { wch: 18 },  // Jam Masuk
        { wch: 18 }   // Jam Pulang

    ];

    // BUAT WORKBOOK
    const workbook =
        XLSX.utils.book_new();

    XLSX.utils.book_append_sheet(
        workbook,
        worksheet,
        "Kehadiran"
    );

    let bulan= $("#bulan_rekap option:selected")
    .text()
    .trim()
    .replace(/\s+/g, "-");
    let tahun = $("#tahun_rekap").val();
    let nama = $("#karyawan_rekap_absensi option:selected")
    .text()
    .trim()
    .replace(/\s+/g, "-");
    // DOWNLOAD
    XLSX.writeFile(
        workbook,
        `Rekap-kehadiran-${nama}-${bulan}-${tahun}.xlsx`
    );
}
