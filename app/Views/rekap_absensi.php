<div class="container-fluid py-4 px-4" style="margin-top:50px;">
    <div class="row">
        <div class="col">
            <h2 class="text-center mb-0">
                REKAP ABSENSI PERKARYAWAN
            </h2>
            <div class="card card-custom p-3 mb-1 mt-4">

                <label class="form-label fw-bold mb-2">
                    Periode
                </label>

                <div class="d-flex flex-wrap align-items-center filter-wrapper">

                    <select class="form-select filter-control" id="bulan_rekap" style="width: 170px;">

                    </select>

                    <select class="form-select filter-control" id="tahun_rekap" style="width: 120px;">

                    </select>

                    <select class="form-select filter-control" id="karyawan_rekap_absensi" style="width: 170px;">
                        <option value="">
                            -- Pilih Karyawan --
                        </option>
                    </select>

                    <button class=" btn btn-primary filter-control px-3" onclick="loadKehadiran();" id="btnLoad_rekap">
                        <i class="bi bi-search"></i>
                        Load
                    </button>

                    <button class=" btn btn-success filter-control px-3" onclick=" exportExcel();">
                        <i class="bi bi-filetype-xls"></i>
                        Export
                    </button>

                    <!-- <button class="btn btn-success filter-control px-3" onclick="tampil_formTambahJadwal()">

                        <i class="bi bi-calendar-plus me-2"></i>
                        Tambah Jadwal

                    </button>

                    <button class="btn btn-danger filter-control px-3" onclick="tampil_formHapusJadwal()">

                        <i class="bi bi-calendar-plus me-2"></i>
                        Hapus Jadwal

                    </button> -->

                </div>

            </div>


            <div class="card card-custom p-3 mb-3 mt-2">
                <div class="table-responsive">
                    <table id="tabelKehadiran" class="table table-bordered table-striped">

                        <thead>
                            <tr>

                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>

                        <tbody id="tbodyKehadiran">

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>