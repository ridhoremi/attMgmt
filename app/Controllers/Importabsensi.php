<?php

namespace App\Controllers;

use App\Models\CheckinoutModel;

class Importabsensi extends BaseController
{

    protected $checkinModel;

    public function __construct()
    {
        $this->checkinModel = new CheckinoutModel();
    }


    public function index()
    {

        if ($this->request->isAJAX()) {
            return view('importabsensi');
        }
    }

    public function import_file()
    {
        $file = $this->request->getFile('file');
        $machine_id = $this->request->getVar('machine_id');
        $karyawanModel = new \App\Models\KaryawanModel();

        if (!$file || !$file->isValid()) {
            return "File tidak valid";
        }

        $path = $file->getTempName();
        $content = file_get_contents($path);
        $lines = preg_split('/\r\n|\r|\n/', $content);

        $result = [];
        $no = 1;

        foreach ($lines as $line) {

            $line = trim($line);
            if ($line == '') continue;

            $data = preg_split('/\s+/', $line);
            $user_id = $data[0] ?? '';
            $date    = $data[1] ?? '';
            $time    = $data[2] ?? '';
            $machine = $machine_id;
            $status = $data[4] ?? ' ';
            $checktime = $date . ' ' . $time;

            $karyawan = $karyawanModel
                ->where('id', $user_id)
                ->first();

            $nama = $karyawan ? $karyawan['nama'] : 'TIDAK DITEMUKAN';


            $result[] = [
                'no'        => $no,
                'user_id'   => $user_id,
                'nama'      => $nama,
                'checktime' => $checktime,
                'machine'   => $machine,
                'status'    => $status
            ];

            $no++;
        }

        return $this->response->setJSON($result);
    }

    public function proses_import()
    {

        $file = $this->request->getFile('file');
        $machine_id = $this->request->getVar('machine_id');
        if (!$file || !$file->isValid()) {
            return "File tidak valid";
        }

        $path = $file->getTempName();
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $result = [];
        $no = 1;

        foreach ($lines as $line) {
            $data = preg_split('/\s+/', trim($line));
            if (count($data) < 4) continue;
            $user_id = $data[0];
            $date    = $data[1];
            $time    = $data[2];
            $machine = $machine_id;
            $checktime = $date . ' ' . $time;
            $cek = $this->checkinModel
                ->where('user_id', $user_id)
                ->where('checktime', $checktime)
                ->first();
            $status = 'SKIP';
            if (!$cek) {
                $this->checkinModel->insert([
                    'user_id'    => $user_id,
                    'checktime'  => $checktime,
                    'machine_id' => $machine
                ]);
                $status = 'INSERT';
            }

            $result[] = [
                'no'        => $no,
                'user_id'   => $user_id,
                'checktime' => $checktime,
                'machine'   => $machine,
                'status'    => $status
            ];

            $no++;
        }

        return view('layout/template', [
            'title'   => 'Import Absensi',
            'content' => 'importabsensi',
            'data'    => $result
        ]);
    }
    public function simpan_absensi()
    {
        $data = json_decode($this->request->getPost('data'), true);

        foreach ($data as $row) {


            $cek = $this->checkinModel
                ->where('user_id', $row['user_id'])
                ->where('checktime', $row['checktime'])
                ->first();

            if ($cek) continue;

            $this->checkinModel->insert([
                'user_id'   => $row['user_id'],
                'checktime' => $row['checktime'],
                'machine_id'   => $row['machine'],
                'status'    => $row['status']
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ok'
        ]);
    }
}
