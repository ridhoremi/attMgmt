<?php

namespace App\Controllers;

use App\Models\JadwalModel;

class RekapAbsensi extends BaseController
{



    public function index()
    {
        $data = [
            'title' => 'Rekap Absensi',
            'content' => 'rekap_absensi'
        ];
        return view('layout/template', $data);
    }

    public function kehadiran()
    {

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $model = new \App\Models\JadwalModel();
        $data = [
            'data' => $model->getKehadiran($bulan, $tahun),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'title' => 'Rekap Absensi',
            'content' => 'rekap_absensi'
        ];

        return view('layout/template', $data);
    }

    public function getKehadiran()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        $userid = $this->request->getGet('user_id');
        $machine = $this->request->getGet('machine_id');
        $modelJadwal = new \App\Models\JadwalModel();

        $data = $modelJadwal
            ->getKehadiran($bulan, $tahun, $userid, $machine);

        return $this->response->setJSON([
            'data' => $data
        ]);
    }
}
