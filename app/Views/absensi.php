<div class="container mt-5 pt-3">
    <div class="row">
        <div class="col">
            <h1 class="text-center">DAFTAR ABSENSI</h1>
            <!-- Filter -->
            <div class="card card-custom p-3 mb-3">
                <div class="form-row align-items-center">


                    <div class="col-auto">
                        <input type="date" id="startDate" value="<?= date('Y-m-01') ?>">
                    </div>

                    <div class="col-auto">
                        <span>-</span>
                    </div>

                    <!-- Tanggal Sampai -->
                    <div class="col-auto">
                        <input type="date" id="endDate" value="<?= date('Y-m-t') ?>">
                    </div>

                    <!-- Input Search
                    <div class="col-auto">
                        <input type="text" class="form-control" placeholder="Cari...">
                    </div> -->

                    <!-- Tombol -->
                    <div class="col-auto">
                        <button onclick="reloadTable()" class="btn btn-primary">Cari</button>
                    </div>

                </div>
            </div>

            <!-- Table -->


            <table id="dtTabel" class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal Absen</th>
                        <th class="text-center" width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>



        </div>
    </div>
</div>