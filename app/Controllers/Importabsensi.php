<?php

namespace App\Controllers;

class Importabsensi extends BaseController
{
    public function index(): string
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
        $machine_id = $this->request->getVar('machine_id');

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
            // $machine = $data[3] ?? '';
            $status = $data[4] ?? ' ';
            $checktime = $date . ' ' . $time;


            $result[] = [
                'no'        => $no,
                'user_id'   => $user_id,
                'checktime' => $checktime,
                'machine'   => $machine_id,
                'status'    => $status
            ];

            $no++;
        }

        return view('layout/template', [
            'title'   => 'Preview Import Absensi',
            'content' => 'importabsensi',
            'data'    => $result
        ]);
    }

    public function proses()
    {
        $file = $this->request->getFile('file');

        if (!$file->isValid()) {
            return "File tidak valid";
        }

        $path = $file->getTempName();
        $content = file_get_contents($path);
        $lines = preg_split('/\r\n|\r|\n/', $content);

        $db = \Config\Database::connect();

        $no = 1;

        foreach ($lines as $line) {

            $line = trim($line);
            if ($line == '') continue;

            $data = preg_split('/\s+/', $line);

            $user_id = $data[0] ?? '';
            $date    = $data[1] ?? '';
            $time    = $data[2] ?? '';
            $machine = $data[3] ?? '';

            $checktime = $date . ' ' . $time;


            $cek = $db->query("
            SELECT id FROM checkinout 
            WHERE user_id = '$user_id' 
            AND checktime = '$checktime'
        ");

            if ($cek->getNumRows() == 0) {

                $db->query("
                INSERT INTO checkinout (user_id, checktime, machine_id)
                VALUES ('$user_id', '$checktime', '$machine')
            ");
            }

            $no++;
        }

        return redirect()->to('/importabsensi')->with('success', 'Import berhasil!');
    }
}
