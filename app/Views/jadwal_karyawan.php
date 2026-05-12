<!-- VIEW -->
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

                    </select>

                    <select class="form-select filter-control" id="tahun" style="width: 120px;">

                    </select>

                    <button class="btn btn-primary filter-control px-3" onclick="loadJadwal()" id="btnLoad">

                        <i class="bi bi-search"></i>
                        Load

                    </button>

                    <button class="btn btn-success filter-control px-3" onclick="tampil_formTambahJadwal()">

                        <i class="bi bi-calendar-plus me-2"></i>
                        Tambah Jadwal

                    </button>

                    <button class="btn btn-danger filter-control px-3" onclick="tampil_formHapusJadwal()">

                        <i class="bi bi-calendar-plus me-2"></i>
                        Hapus Jadwal

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
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">
            <!-- Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-plus me-2"></i>
                    Tambah Jadwal Karyawan
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>

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
                            <select class="form-select" id="karyawan" required>
                                <option value="">
                                    -- Pilih Karyawan --
                                </option>
                            </select>
                        </div>

                        <!-- Shift -->
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Shift
                            </label>

                            <select class="form-select" id="shift_id" required>
                                <option value="">
                                    -- Pilih Shift --
                                </option>

                            </select>
                        </div>
                        <!-- Tanggal -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Tanggal Mulai
                            </label>
                            <input type="date" class="form-control" id="tanggal_mulai" required>
                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tanggal Selesai
                            </label>

                            <input type="date" class="form-control" id="tanggal_selesai" required>

                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Keterangan
                            </label>

                            <textarea class="form-control" id="keterangan" rows="3"
                                placeholder="Optional"></textarea>
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-light border" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="button" class="btn btn-success" onclick="simpanJadwal()">
                        <i class="bi bi-save me-1"></i>
                        Simpan Jadwal
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- Modal Hapus Jadwal -->
<div class="modal fade" id="modalHapusJadwal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    Hapus Jadwal
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formHapusJadwal">
                <div class="modal-body">
                    <!-- Karyawan -->
                    <div class="form-group">
                        <label>Karyawan</label>
                        <select class="form-control" id="hapus_karyawan">
                            <option value="">
                                -- Pilih Karyawan --
                            </option>
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" id="hapus_tanggal_mulai">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" id="hapus_tanggal_selesai">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="btnHapusJadwal" onclick="hapusJadwal()">
                        <i class="bi bi-trash"></i>
                        Hapus
                    </button>
                </div>
            </form>

        </div>

    </div>

</div>