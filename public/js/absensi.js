var dtAbsensi;
var dtPreview;

var method;
// $(document).ready(function () {
//   dtAbsensi= $("#dtTabel").DataTable({
//     //processing: true,
//     serverSide: true,
//     pageLength: 10,
//     deferRender: true,
//     ajax: {
//       url: BASE_URL + "/listabsensi",
//         type: "POST",
//         data: function (d) {
//             d.startDate = $('#startDate').val();
//             d.endDate   = $('#endDate').val();
//         }
//     }
//   });

// });

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
      }
    }
  });
}

function initPreviewTable() {

    if ($.fn.DataTable.isDataTable('#dtPreview')) {
        $('#dtPreview').DataTable().destroy();
    }

    dtPreview = $('#dtPreview').DataTable({
        data: [],
        columns: [
            { data: 'no' },
            { data: 'user_id' },
            { data: 'nama' },
            { data: 'checktime' },
            { data: 'machine' },
            { data: 'status' }
        ]
    });

    $('#btnSimpan').prop('disabled', true);
}

function reloadTable() {
    dtAbsensi.ajax.reload();
}

function import_proses(){
   $.ajax({
    url: BASE_URL + "/import-absensi",
    type: "POST",
    data: new FormData($("#formImport")[0]),
    dataType: "JSON",
    processData: false,
    contentType: false,

    success: function (data) {
    dtPreview.clear(); 
    let no = 1;
     
    data.forEach(function (row) {
        dtPreview.row.add({
            no: no++,
            user_id: row.user_id,
            nama: row.nama,
            checktime: row.checktime,
            machine: row.machine,
            status: row.status
        });
       
    });

    dtPreview.draw();
    window.dataImport = data;
     if (data.length > 0) {
        $('#btnSimpan').prop('disabled', false);
    }
    },

    error: function (jqXHR) {
        console.log("STATUS:", jqXHR.status);
        console.log("RESPONSE:", jqXHR.responseText);
    }
  });
}

function simpanData(){
 
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
        success: function(res){
             Swal.fire("Berhasil!", "Data Impor Berhasil Disimpan.", "success");

            dtAbsensi.ajax.reload();
            dtPreview.clear().draw();

            window.dataImport = [];

             $('#btnSimpan').prop('disabled', true);
        },
        error: function (jqXHR) {
            console.log(jqXHR.responseText);
        }
    });

}