<div class="container mt-5">
    <div class="row">
        <div class="col">
            <hr>
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pengaturan Jam Kerja</h5>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalShift">
                            <i class="fa fa-plus"></i> Tambah Shift
                        </button>

                        <div style="width:200px;">
                            <select id="" class="form-control form-control-sm">
                                <option value="">Semua Mesin</option>
                            </select>
                        </div>

                    </div>


                    <div class="table-responsive mt-5">
                        <table id="dtShift" class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Shift</th>
                                    <th>Mesin</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>


            </div>

            <div class="modal fade" id="modalShift" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- HEADER -->
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Tambah Shift</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- BODY -->
                        <div class="modal-body">
                            <form id="formShift">

                                <div class="form-group">
                                    <label>Nama Shift</label>
                                    <input type="text" name="nama_shift" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Mesin</label>
                                    <select id="filter_machine" class="form-control form-control-sm">
                                        <option value="">-- Pilih Mesin --</option>
                                        <option value="2">Mesin Depan</option>
                                        <option value="1">Mesin Belakang</option>
                                    </select>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Jam Masuk</label>
                                        <input type="time" name="jam_masuk" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Jam Keluar</label>
                                        <input type="time" name="jam_keluar" class="form-control" required>
                                    </div>
                                </div>

                            </form>
                        </div>

                        <!-- FOOTER -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="simpanShift()">Simpan</button>
                        </div>

                    </div>
                </div>
            </div>



        </div>
    </div>
</div>