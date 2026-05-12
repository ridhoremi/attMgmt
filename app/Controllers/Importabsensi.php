<?php

namespace App\Controllers;

use App\Models\CheckinoutModel;

class Importabsensi extends BaseController
{
    protected CheckinoutModel $checkinModel;

    public function __construct()
    {
        $this->checkinModel = new CheckinoutModel();
    }


    public function index()
    {
        $data = [
            'title' => 'Import Absensi',
            'content' => 'importabsensi'
        ];
        return view('layout/template', $data);
    }

    public function import_file()
    {
        $file = $this->request->getFile('file');
        $machine_id = $this->request->getPost('machine_id');
        $karyawanModel = new \App\Models\KaryawanModel();

        if (!$machine_id) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Machine ID wajib dipilih'
            ]);
        }

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'File Tidak Valid'
            ]);
        }

        $path = $file->getTempName();
        $content = file_get_contents($path);
        // $lines = preg_split('/\r\n|\r|\n/', $content);
        $lines = array_filter(array_map('trim', explode("\n", $content)));
        $result = [];
        $no = 1;
        $karyawanMap = [];
        $karyawanRows = $karyawanModel->getMesinKaryawan($machine_id);

        foreach ($karyawanRows as $row) {
            $karyawanMap[$row['user_id']] = $row['nama'];
        }


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

            $nama = $karyawanMap[$user_id] ?? 'TIDAK DITEMUKAN';
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

    public function simpan_absensi()
    {
        $data = json_decode($this->request->getPost('data'), true);

        $this->checkinModel->insertBatchAbsensi($data);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    // public function simpan_absensi()
    // {
    //     $data = json_decode($this->request->getPost('data'), true);
    //     foreach ($data as $row) {
    //         $cek = $this->checkinModel
    //             ->where('user_id', $row['user_id'])
    //             ->where('checktime', $row['checktime'])
    //             ->first();

    //         if ($cek) continue;

    //         $this->checkinModel->insert([
    //             'user_id'   => $row['user_id'],
    //             'checktime' => $row['checktime'],
    //             'machine_id'   => $row['machine'],
    //             'status'    => $row['status']
    //         ]);
    //     }

    //     return $this->response->setJSON([
    //         'status' => true
    //     ]);
    // }
}
