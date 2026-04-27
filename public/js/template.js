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

$(document).on('click', '#menuAbsensi', function (e) {
    e.preventDefault();

    $('#content').load(BASE_URL + '/absensi', function () {
        document.title = 'Data Absensi';
        initDataAbsensi();
    });
});

$(document).on('click', '#menuJamkerja', function (e) {
    e.preventDefault();

    $('#content').load(BASE_URL + '/settingJamkerja', function () {
        document.title = 'Setting Jam Kerja (Shift)';
       initDataShift();
    });
});

$(document).on('click', '#menuJadwalKerja', function (e) {
    e.preventDefault();

    $('#content').load(BASE_URL + '/settingJamkerja', function () {
        document.title = 'Setting Jam Kerja (Shift)';
       initDataShift();
    });
});

