var table;
var method;
// $(document).ready(function () {
//   table = $("#tabel1").DataTable({
//    // processing: true,
//     serverSide: true,
//     pageLength: 10,
//     deferRender: true,
//     ajax: {
//       url: BASE_URL + "/listkaryawan",
//       type: "GET",
//     },
//   });
// });

function initKaryawan() {
  if ($.fn.DataTable.isDataTable("#tabel1")) {
    $("#tabel1").DataTable().destroy();
  }

  table = $("#tabel1").DataTable({
    serverSide: true,
    pageLength: 10,
    deferRender: true,
    searching: true,
    ajax: {
      url: BASE_URL + "/listkaryawan",
      type: "GET",
    },
  });
}

function tampil_form() {
  method = "insert";
  $("#modal-form").modal("show");
  $("#modal-title").text("Tambah Data");
  $("#form")[0].reset();
  $("#id").prop("readonly", false);
  $(".form-control").removeClass("is-invalid");
  $(".help-block").text("");
}
function simpan() {
  let url;

  if (method == "insert") {
    url = BASE_URL + "/simpankaryawan";
  } else {
    url = BASE_URL + "/updatekaryawan";
  }
  $.ajax({
    url: url,
    type: "POST",
    data: new FormData($("#form")[0]),
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (data) {
      if (data.status) {
        $("#form")[0].reset();
        $("#modal-form").modal("hide");
        
        table.ajax.reload(null, false);
      } else {
        for (var i = 0; i < data.inputerror.length; i++) {
          $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
          $('[name="' + data.inputerror[i] + '"]')
            .next(".help-block")
            .text(data.error_string[i]);
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
      alert("error");
    },
  });
}

function editData(id) {
  method = "update";

  $.ajax({
    url: BASE_URL + "/editkaryawan/" + id,
    type: "GET",
    dataType: "JSON",
    success: function (data) {
      $('[name="id"]').val(data.id);
      $('[name=machine_id').val(data.machine_id)
      $('[name="user_id"]').val(data.user_id);
      $('[name="nama"]').val(data.nama);
      $('[name="alamat"]').val(data.alamat);

      $("#id").prop("readonly", true);
      $("#modal-form").modal("show");
      $("#modal-title").text("Edit Data");
      $(".form-control").removeClass("is-invalid");
      $(".help-block").text("");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
      alert("error");
    },
  });
}

function hapusData(id) {
  Swal.fire({
    title: "Yakin?",
    text: "Data akan dihapus!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya, hapus!",
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: BASE_URL + "/hapuskaryawan/" + id,
        type: "DELETE",
        dataType: "json",
        success: function (res) {
          if (res.status) {
            table.ajax.reload();
            Swal.fire("Berhasil!", "Data berhasil dihapus.", "success");
          } else {
            Swal.fire("Gagal!", "Data gagal dihapus.", "error");
          }
        },
      });
    }
  });
}
