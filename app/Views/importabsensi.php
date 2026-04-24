<div class="container mt-5">
    <div class="row">
        <div class="col">
            <hr>
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Import Data Absensi (USB)</h5>
                </div>

                <div class="card-body">
                    <form action="/import-absensi" method="post" enctype="multipart/form-data">


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


                        <button type="submit" class="btn btn-success">
                            Import Data
                        </button>
                    </form>
                </div>
            </div>


            <div class="card mt-4 shadow">
                <div class="card-header">
                    Preview Data
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User ID</th>
                                <th>Checktime</th>
                                <th>Machine</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data ?? [] as $row): ?>
                                <tr>
                                    <td><?= $row['no'] ?></td>
                                    <td><?= $row['user_id'] ?></td>
                                    <td><?= $row['checktime'] ?></td>
                                    <td><?= $row['machine'] ?></td>
                                    <td><?= $row['status'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- <h3>Import File Absensi</h3>

    <form action="/importproses" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit">Import</button>
    </form>

    <hr>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>User ID</th>
                <th>Check Time</th>
                <th>Machine</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $file = $_FILES['file']['tmp_name'];

                $lines = file($file);

                $no = 1;

                foreach ($lines as $line) {

                    $line = trim($line);
                    if ($line == '') continue;

                    $data = preg_split('/\s+/', $line);

                    $user_id = $data[0];
                    $date    = $data[1];
                    $time    = $data[2];
                    $machine = $data[3];
                    $status  = $data[4];

                    $checktime = $date . ' ' . $time;

                    echo "<tr>
                <td>$no</td>
                <td>$user_id</td>
                <td>$checktime</td>
                <td>$machine</td>
                <td>$status</td>
              </tr>";

                    $no++;
                }
            }
            ?>

        </tbody>
    </table> -->
            </div>
        </div>
    </div>