$(document).on('click', '#menuAttMgmt', function (e) {
    e.preventDefault();

    $('#content').load(BASE_URL + '/importabsensi', function () {
        document.title = 'Import Absensi';
         initPreviewTable();
    });
});

$(document).on('click', '#menuKaryawan', function (e) {
    e.preventDefault();

    $('#content').load(BASE_URL + '/karyawan', function () {
        document.title = 'Data Karyawan';
        initKaryawan();
    });
});