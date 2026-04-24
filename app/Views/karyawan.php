<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h1 class="text-center">DAFTAR KARYAWAN</h1>
            <a href="javascript:void(0)" class="btn btn-primary mt-3 mb-3" onclick="tampil_form()"> Tambah Data </a>
            <table id="tabel1" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-formLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" id="id" name="id">

                    <div class="form-group row">
                        <label for="no_mesin" class="col-sm-3 col-form-label">No Mesin</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="machine_id" name="machine_id">
                                <option value="">-- Pilih Mesin --</option>
                                <option value="1">Mesin Belakang</option>
                                <option value="2">Mesin Depan</option>
                            </select>
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="userid" class="col-sm-3 col-form-label">User ID</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="user_id" name="user_id">
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama">
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="alamat" name="alamat"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>