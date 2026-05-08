<?php

namespace App\Controllers;

use App\Models\JadwalModel;

class Jadwal extends BaseController
{

    protected $model;

    public function __construct()
    {

        $this->model = new JadwalModel();
    }

    public function index()
    {
        if ($this->request->isAJAX()) {
            $karyawanModel = new \App\Models\KaryawanModel();
            $jadwalModel   = new \App\Models\JadwalModel();
            $shiftModel    = new \App\Models\ShiftModel();

            $tahun = date('Y');
            $bulan = date('m');
            $data = [
                'tahun'    => $tahun,
                'bulan'    => $bulan,
                'karyawan' => $karyawanModel->getAllKaryawan(),
                'shift'    => $shiftModel->getAllShift(),
                'map'      => $jadwalModel->getMapJadwal($bulan, $tahun)
            ];
            return view('jadwal_karyawan', $data);
        }
    }

    public function getTable()
    {
        if ($this->request->isAJAX()) {

            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            $karyawanModel = new \App\Models\KaryawanModel();
            $jadwalModel   = new \App\Models\JadwalModel();

            $data = [
                'bulan'    => $bulan,
                'tahun'    => $tahun,
                'karyawan' => $karyawanModel->getAllKaryawan(),
                'map'      => $jadwalModel->getMapJadwal($bulan, $tahun)
            ];

            return view('table_jadwal_karyawan', $data);
        }
    }

    public function getJadwal()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $karyawanModel = new \App\Models\KaryawanModel();
        $jadwalModel   = new \App\Models\JadwalModel();

        $jumlahHari = date('t', strtotime("$tahun-$bulan-01"));

        // Karyawan
        $karyawan = $karyawanModel->getAllKaryawan();

        // Jadwal
        $map = $jadwalModel->getMapJadwal($bulan, $tahun);

        return $this->response->setJSON([

            'jumlahHari' => $jumlahHari,
            'karyawan'   => $karyawan,
            'map'        => $map

        ]);
    }


    public function simpan()
    {
        $jadwalModel = new \App\Models\JadwalModel();

        $karyawan = $this->request->getPost('karyawan');

        list($user_id, $machine_id) = explode('|', $karyawan);

        $shift_id        = $this->request->getPost('shift_id');
        $tanggal_mulai   = $this->request->getPost('tanggal_mulai');
        $tanggal_selesai = $this->request->getPost('tanggal_selesai');
        $keterangan      = $this->request->getPost('keterangan');

        // =========================
        // VALIDASI
        // =========================

        if (
            empty($user_id) ||
            empty($machine_id) ||
            empty($shift_id) ||
            empty($tanggal_mulai) ||
            empty($tanggal_selesai)
        ) {

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data belum lengkap'
            ]);
        }

        if ($tanggal_mulai > $tanggal_selesai) {

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai'
            ]);
        }

        $start = strtotime($tanggal_mulai);
        $end   = strtotime($tanggal_selesai);

        $duplikat = [];
        $berhasil = 0;

        // =========================
        // LOOP TANGGAL
        // =========================

        for ($i = $start; $i <= $end; $i += 86400) {

            $tanggal = date('Y-m-d', $i);

            // Cek data existing
            $cek = $jadwalModel

                ->where('user_id', $user_id)
                ->where('machine_id', $machine_id)
                ->where('tanggal', $tanggal)

                ->first();

            // Kalau sudah ada
            if ($cek) {

                $duplikat[] = $tanggal;

                continue;
            }

            // Insert
            $jadwalModel->insert([

                'user_id'    => $user_id,
                'machine_id' => $machine_id,
                'tanggal'    => $tanggal,
                'shift_id'   => $shift_id,
                'keterangan' => $keterangan

            ]);

            $berhasil++;
        }

        // =========================
        // RESPONSE
        // =========================

        if ($berhasil == 0) {

            return $this->response->setJSON([

                'status'  => false,

                'message' => 'Semua jadwal sudah ada'

            ]);
        }

        if (count($duplikat) > 0) {

            return $this->response->setJSON([

                'status'  => true,

                'message' => $berhasil . ' jadwal berhasil disimpan, sebagian dilewati karena sudah ada'

            ]);
        }

        return $this->response->setJSON([

            'status'  => true,

            'message' => 'Jadwal berhasil disimpan'

        ]);
    }
}
