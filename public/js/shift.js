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
      type: "POST"
    },
    columns: [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      { data: "nama_shift" },
      { data: "nama_mesin" },
      { data: "jam_masuk" },
      { data: "jam_keluar" },
      {
        data: null,
        render: function () {
          return `<button class="btn btn-sm btn-warning">Edit</button>`;
        }
      }
    ]
  });
}