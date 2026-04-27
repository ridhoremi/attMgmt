<div class="container mt-5">
    <div class="row">
        <div class="col">
            <hr>
            <div class="card shadow">
                <!-- HEADER -->
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Jadwal Shift Karyawan</h5>
                </div>

                <div class="card-body">

                    <!-- BUTTON TAMBAH -->
                    <div class="mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJadwal">
                            + Tambah Jadwal
                        </button>
                    </div>

                    <!-- FILTER BOX -->
                    <div class="card mb-3 border">
                        <div class="card-body">

                            <div class="row align-items-end g-2">

                                <!-- Dari -->
                                <div class="col-md-2">
                                    <label class="form-label">Dari</label>
                                    <input type="date" id="start_date" class="form-control"
                                        value="<?= date('Y-m-01') ?>">
                                </div>

                                <!-- Sampai -->
                                <div class="col-md-2">
                                    <label class="form-label">Sampai</label>
                                    <input type="date" id="end_date" class="form-control"
                                        value="<?= date('Y-m-t') ?>">
                                </div>

                                <!-- Karyawan -->
                                <div class="col-md-3">
                                    <label class="form-label">Karyawan</label>
                                    <select id="karyawan_filter" class="form-control">
                                        <option value="">-- Semua Karyawan --</option>
                                    </select>
                                </div>

                                <!-- Tombol -->
                                <div class="col-md-3">
                                    <label class="form-label d-block">&nbsp;</label>
                                    <div class="row g-1">
                                        <div class="col-6">
                                            <button class="btn btn-success w-100" onclick="filterJadwal()">Cari</button>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-secondary w-100" onclick="resetFilter()">Reset</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dtJadwal">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Shift</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="modalJadwal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Jadwal Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>Karyawan</label>
                                    <select id="karyawan_id" class="form-control"></select>
                                </div>

                                <div class="col-md-6">
                                    <label>Shift</label>
                                    <select id="shift_id" class="form-control"></select>
                                </div>

                                <div class="col-md-6">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" id="start_date_modal" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" id="end_date_modal" class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" onclick="simpanRange()">Simpan</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>