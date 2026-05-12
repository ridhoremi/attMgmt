<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\KaryawanModel;
use App\Models\ShiftModel;

class Jadwal extends BaseController
{
    protected JadwalModel $modelJadwal;
    protected KaryawanModel $modelKaryawan;
    protected ShiftModel $modelShift;

    public function __construct()
    {
        $this->modelJadwal = new JadwalModel();
        $this->modelKaryawan = new KaryawanModel();
        $this->modelShift = new ShiftModel();
    }

    public function index()
    {


        $data = [
            'title'    => 'Jadwal Shift/Kerja Karyawan',
            'content'  => 'jadwal_karyawan'
        ];

        return view('layout/template', $data);
    }



    public function getJadwal()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');


        $jumlahHari = date('t', strtotime("$tahun-$bulan-01"));
        // Karyawan
        $karyawan = $this->modelKaryawan->getAllKaryawan();

        // Jadwal
        $map = $this->modelJadwal->getMapJadwal($bulan, $tahun);

        return $this->response->setJSON([

            'jumlahHari' => $jumlahHari,
            'karyawan'   => $karyawan,
            'map'        => $map

        ]);
    }

    public function cmbKaryawan()
    {
        $karyawan = $this->modelKaryawan->getAllKaryawan();
        return $this->response->setJSON([
            'karyawan'   => $karyawan
        ]);
    }

    public function cmbShift()
    {
        $shift = $this->modelShift->getAllShift();
        return $this->response->setJSON([
            'shift' => $shift
        ]);
    }


    public function simpan()
    {
        $jadwalModel = new \App\Models\JadwalModel();

        $user_id    = $this->request->getPost('user_id');
        $machine_id = $this->request->getPost('machine_id');

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
            $cek = $jadwalModel
                ->where('user_id', $user_id)
                ->where('machine_id', $machine_id)
                ->where('tanggal', $tanggal)
                ->first();

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


    public function hapus()
    {
        $user_id    = $this->request->getPost('user_id');
        $machine_id = $this->request->getPost('machine_id');
        $tanggal_mulai = $this->request->getPost('tanggal_mulai');
        $tanggal_selesai = $this->request->getPost('tanggal_selesai');

        if (
            empty($user_id) ||
            empty($machine_id) ||
            empty($tanggal_mulai) ||
            empty($tanggal_selesai)
        ) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data belum lengkap'
            ]);
        }

        if ($tanggal_mulai > $tanggal_selesai) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai'
            ]);
        }

        $hapus = $this->modelJadwal->hapusJadwal($user_id, $machine_id, $tanggal_mulai, $tanggal_selesai);

        if ($hapus) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Jadwal berhasil dihapus'
            ]);
        }
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Gagal menghapus jadwal'
        ]);
    }
}
