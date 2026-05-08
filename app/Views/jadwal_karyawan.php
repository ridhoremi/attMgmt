<!-- VIEW -->
<?php
$namaBulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

?>
<div class="container-fluid py-4 px-4" style="margin-top:50px;">
    <div class="row">
        <div class="col">
            <h2 class="text-center mb-0">
                JADWAL SHIFT / KERJA KARYAWAN
            </h2>
            <div class="card card-custom p-3 mb-1 mt-4">

                <label class="form-label fw-bold mb-2">
                    Periode
                </label>

                <div class="d-flex flex-wrap align-items-center filter-wrapper">

                    <select class="form-select filter-control" id="bulan" style="width: 170px;">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= $i == date('m') ? 'selected' : '' ?>>
                                <?= $namaBulan[$i] ?>
                            </option>
                        <?php endfor; ?>

                    </select>

                    <select class="form-select filter-control"
                        id="tahun"
                        style="width: 120px;">

                        <?php for ($i = date('Y') - 2; $i <= date('Y') + 2; $i++): ?>

                            <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>>

                                <?= $i ?>

                            </option>

                        <?php endfor; ?>

                    </select>

                    <button class="btn btn-primary filter-control px-3" id="btnLoad">

                        <i class="bi bi-search"></i>
                        Load

                    </button>

                    <button class="btn btn-success filter-control px-3"
                        data-toggle="modal"
                        data-target="#modalTambah">

                        <i class="bi bi-calendar-plus me-2"></i>
                        Tambah Jadwal

                    </button>

                </div>

            </div>
            <div class="card card-custom p-3 mb-3 mt-2">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tblJadwal">
                        <!-- <table class="table table-bordered table-sm align-middle" id="tblJadwal"> -->

                        <thead class="table-dark" id="theadJadwal">
                        </thead>

                        <tbody id="tbodyJadwal">
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">
            <!-- Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-plus me-2"></i>
                    Tambah Jadwal Karyawan
                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>

            </div>

            <!-- Body -->
            <form id="formTambahJadwal">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Karyawan -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Karyawan
                            </label>
                            <select class="form-select" name="karyawan" required>

                                <option value="">
                                    -- Pilih Karyawan --
                                </option>

                                <?php foreach ($karyawan as $k): ?>

                                    <option value="<?= $k['user_id'] . '|' . $k['machine_id'] ?>">

                                        <?= $k['nama'] ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- Shift -->
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Shift
                            </label>

                            <select class="form-select" name="shift_id" required>

                                <option value="">
                                    -- Pilih Shift --
                                </option>
                                <?php foreach ($shift as $s): ?>
                                    <option value="<?= $s['id'] ?>">
                                        <?= $s['nama_shift'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <!-- Tanggal -->
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tanggal Mulai
                            </label>

                            <input type="date" class="form-control" name="tanggal_mulai" required>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tanggal Selesai
                            </label>

                            <input type="date" class="form-control" name="tanggal_selesai" required>

                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Keterangan
                            </label>

                            <textarea class="form-control"
                                name="keterangan"
                                rows="3"
                                placeholder="Optional"></textarea>

                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-light border" data-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" class="btn btn-success">

                        <i class="bi bi-save me-1"></i>
                        Simpan Jadwal

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
    $(document).ready(function() {

        loadJadwal();

        $('#btnLoad').click(function() {
            loadJadwal();
        });
    });


    function loadJadwal() {

        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();

        $.ajax({

            url: "<?= base_url('getJadwal') ?>",
            type: "GET",

            data: {
                bulan: bulan,
                tahun: tahun
            },

            dataType: "json",

            beforeSend: function() {

                $('#theadJadwal').html('');

                $('#tbodyJadwal').html(`
                <tr>
                    <td colspan="100" class="text-center p-4">
                        <div class="spinner-border spinner-border-sm text-primary"></div>
                        Loading...
                    </td>
                </tr>
            `);

            },

            success: function(res) {

                // =========================
                // HEADER
                // =========================

                let thead = '<tr>';

                thead += `
                <th class="text-start sticky-col bg-dark text-white">
                    Nama Karyawan
                </th>
            `;

                for (let i = 1; i <= res.jumlahHari; i++) {

                    thead += `
                    <th class="text-center">
                        ${i}
                    </th>
                `;

                }

                thead += '</tr>';

                $('#theadJadwal').html(thead);


                // =========================
                // BODY
                // =========================

                let html = '';

                $.each(res.karyawan, function(index, k) {

                    html += '<tr>';

                    html += `
                    <td class="text-start sticky-col bg-white">
                        ${k.nama}
                    </td>
                `;

                    for (let i = 1; i <= res.jumlahHari; i++) {

                        let tanggal =
                            `${tahun}-${String(bulan).padStart(2,'0')}-${String(i).padStart(2,'0')}`;

                        let shift = '-';

                        if (
                            res.map[k.user_id] &&
                            res.map[k.user_id][tanggal]
                        ) {
                            shift = res.map[k.user_id][tanggal];
                        }

                        html += `
                        <td class="text-center">
                            ${shift}
                        </td>
                    `;
                    }

                    html += '</tr>';

                });

                $('#tbodyJadwal').html(html);

            },

            error: function(xhr) {

                $('#tbodyJadwal').html(`
                <tr>
                    <td colspan="100" class="text-danger text-center">
                        Gagal load data
                    </td>
                </tr>
            `);

                console.log(xhr.responseText);

            }

        });

    }

    $('#formTambahJadwal').submit(function(e) {

        e.preventDefault();

        $.ajax({

            url: "<?= base_url('jadwal-simpan') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",

            success: function(res) {

                if (res.status) {

                    $('#modalTambah').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message
                    });

                    $('#formTambahJadwal')[0].reset();

                    loadJadwal();

                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: res.message
                    });

                }

            },

            error: function(xhr) {

                console.log(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan'
                });

            }

        });

    });
</script>