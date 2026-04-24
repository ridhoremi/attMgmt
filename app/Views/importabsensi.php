<div class="container mt-5">
    <div class="row">
        <div class="col">
            <hr>
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Import Data Absensi (USB)</h5>
                </div>


                <div class="card-body">
                    <form action="" id="formImport" method="post" enctype="multipart/form-data">


                        <div class="form-group">
                            <label>Machine ID</label>
                            <select name="machine_id" id="machine_id" class="form-control" required>
                                <option value="">-- Pilih Mesin --</option>
                                <option value="2">Mesin Depan</option>
                                <option value="1">Mesin Belakang</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Upload File Absensi</label>
                            <input type="file" name="file" class="form-control-file" required>
                            <small class="text-muted">Format: .dat </small>
                        </div>


                        <button type="button" class="btn btn-success" onclick="import_proses()">
                            Import Data
                        </button>
                    </form>
                </div>
            </div>


            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Preview Data</span>
                    <button id="btnSimpan" onclick="simpanData()" class=" btn btn-success btn-sm ">
                        Simpan ke Database
                    </button>
                </div>

                <div class=" card-body">
                    <div class="table-responsive">
                        <table id="dtPreview" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User ID</th>
                                    <th>Nama</th>
                                    <th>Checktime</th>
                                    <th>Machine</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>