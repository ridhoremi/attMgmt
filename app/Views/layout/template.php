<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap4.css">
    <title>Hello, world!</title>
</head>

<body>
    <!-- Navigation-->
    <?= view('layout/navbar'); ?>

    <!-- Header-->
    <!-- <header class="bg-dark py-3">
        <div class="container px-4 px-lg-5 my-3">
            <div class="text-center text-white">
                <h1 class="h3 fw-bolder">Attendance Management</h1>

            </div>
        </div>
    </header> -->

    <?= view($content); ?>





    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap4.js"></script>

    <script>
        $(document).ready(function() {
            // new DataTable('#tabel1');
            $('#tabel1').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,

                "deferRender": true,
                "ajax": {
                    "url": '<?= Base_url('/listkaryawan'); ?>',
                    "type": "GET"
                }

            });
        });

        function tampil_form() {
            $('#modal-form').modal('show');
            $('#modal-title').text('Tambah Data');
            $('.form-control').removeClass('is-invalid');
            $('.help-block').text('');
        }

        function simpan() {

            $.ajax({
                url: '<?= Base_url('/simpankaryawan'); ?>',
                type: 'POST',
                data: new FormData($('#form')[0]),
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status) {
                        $('#form')[0].reset();
                        $('#modal-form').modal('hide');
                        $('#tabel1').DataTable().ajax.reload();
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                            $('[name="' + data.inputerror[i] + '"]').next('.help-block').text(data.error_string[i]);
                        }

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText); // penting buat debug
                    alert('error');
                }
            });
        }
    </script>

</body>

</html>