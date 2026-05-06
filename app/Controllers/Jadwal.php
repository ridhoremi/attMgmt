<?php

namespace App\Controllers;

use App\Models\JadwalModel;

class Jadwal extends BaseController
{

    // protected $model;

    // public function __construct()
    // {
    //     $this->model = new AbsensiModel();
    // }

    public function index()
    {
        if ($this->request->isAJAX()) {
            return view('jadwal_karyawan');
        }
    }

    public function grid($machine_id = 1)
    {
        $bulan = date('m');
        $tahun = date('Y');

        $jadwalModel = new JadwalModel();
        $db = \Config\Database::connect();

        // Ambil karyawan di mesin
        $karyawan = $db->table('karyawan_machine km')
            ->join('karyawan k', 'k.id = km.user_id')
            ->where('km.machine_id', $machine_id)
            ->get()->getResultArray();

        // Ambil jadwal
        $jadwal = $jadwalModel->getGrid($machine_id, $bulan, $tahun);

        // Mapping [user_id][tanggal]
        $map = [];
        foreach ($jadwal as $j) {
            $tgl = date('d', strtotime($j['tanggal']));
            $map[$j['user_id']][$tgl] = $j['nama_shift'];
        }

        return view('jadwal/grid', [
            'karyawan' => $karyawan,
            'map' => $map,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }
}
