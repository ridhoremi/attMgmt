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
    <title><?= $title ?? 'Default Title'; ?></title>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const BASE_URL = "<?= base_url(); ?>";
    </script>
    <script src="<?= base_url('js/karyawan.js'); ?>"></script>
    <script src="<?= base_url('js/absensi.js'); ?>"></script>



</body>

</html>