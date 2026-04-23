var dtAbsensi;
var method;
$(document).ready(function () {
  dtAbsensi= $("#dtTabel").DataTable({
    //processing: true,
    serverSide: true,
    pageLength: 10,
    deferRender: true,
    ajax: {
      url: BASE_URL + "/listabsensi",
        type: "POST",
        data: function (d) {
            d.startDate = $('#startDate').val();
            d.endDate   = $('#endDate').val();
        }
    }
  });
});

function reloadTable() {
    dtAbsensi.ajax.reload();
}