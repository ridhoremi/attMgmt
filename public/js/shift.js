var dtShift;
function initDataShift() {
  if ($.fn.DataTable.isDataTable("#dtShift")) {
    $("#dtShift").DataTable().destroy();
  }

  dtShift = $("#dtShift").DataTable({
    processing: true,
    serverSide: true,
    pageLength: 10,
    deferRender: true,
    ajax: {
      url: BASE_URL + "/listshift",
      type: "GET"
    },
  });
}

function form_shift() {
  method = "insert";
  $("#modalShift").modal("show");
  $("#modal-shift").text("Tambah Data");
  $("#modal_titel-shift").text("Tambah Data");
  $("#formShift")[0].reset();
  $(".form-control").removeClass("is-invalid");
  $(".help-block").text("");
}

function simpanShift() {
  let url;
       
  $(".form-control").removeClass("is-invalid");
  $(".help-block").text("");
  if (method == "insert") {
    url = BASE_URL + "/simpanShift";
    
  } else {
    url = BASE_URL + "/updateshift";
  }
  $.ajax({
    url: url,
    type: "POST",
    data: new FormData($("#formShift")[0]),
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (data) {
      if (data.status) {
        $("#formShift")[0].reset();
        $("#modalShift").modal("hide");
        
        dtShift.ajax.reload(null, false);
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

function editDataShift(id) {
  method = "update";

  $.ajax({
    url: BASE_URL + "/editshift/" + id,
    type: "GET",
    dataType: "JSON",
    success: function (data) {
    $('[name="id_shift"]').val(data.data.id);
    $('[name="machine_id_shift"]').val(data.data.machine_id)
    $('[name="nama_shift"]').val(data.data.nama_shift);
    $('[name="jam_masuk"]').val(data.data.jam_masuk);
    $('[name="jam_keluar"]').val(data.data.jam_keluar);

      // $("#id").prop("readonly", true);
      $("#modalShift").modal("show");
      $("#modal_titel-shift").text("Edit Data");
      $(".form-control").removeClass("is-invalid");
      $(".help-block").text("");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
      alert("error");
    },
  });
}

function hapusDataShift(id) {
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
        url: BASE_URL + "/hapusshift/" + id,
        type: "DELETE",
        dataType: "json",
        success: function (res) {
          if (res.status) {
            
            Swal.fire({
            title: "Berhasil!",
            text: res.message, 
            icon: "success"
            });
            dtShift.ajax.reload();
          } else {
           Swal.fire({
             title: "Gagal!",
            text: res.message, // 🔥 juga dari backend
            icon: "error"
            });
          }
        },
      });
    }
  });
}