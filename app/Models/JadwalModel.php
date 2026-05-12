<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal_karyawan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'machine_id',
        'shift_id',
        'tanggal'
    ];


    public function getMapJadwal($bulan = null, $tahun = null)
    {


        $jadwal = $this->db->table('jadwal_karyawan jk')
            ->select('jk.user_id, jk.machine_id, jk.tanggal, s.nama_shift')
            ->join('shift s', 's.id = jk.shift_id')
            ->where('MONTH(jk.tanggal)', $bulan)
            ->where('YEAR(jk.tanggal)', $tahun)
            ->get()
            ->getResultArray();

        $map = [];

        foreach ($jadwal as $j) {

            $tgl = date('Y-m-d', strtotime($j['tanggal']));

            $map[$j['user_id']][$tgl] = $j['nama_shift'];
        }

        return $map;
    }

    public function hapusJadwal($user_id = null, $machine_id = null, $tanggal_mulai = null, $tanggal_selesai = null)
    {
        $result = $this->where('user_id', $user_id)
            ->where('machine_id', $machine_id)
            ->where('tanggal >=', $tanggal_mulai)
            ->where('tanggal <=', $tanggal_selesai)
            ->delete();

        return $result;
    }


    public function generateJadwal($user_id = null, $machine_id = null, $shift_id = null, $mulai = null, $selesai = null, $keterangan = null)
    {
        $start = strtotime($mulai);
        $end   = strtotime($selesai);

        // 1. Generate semua tanggal dulu
        $allDates = [];

        for ($i = $start; $i <= $end; $i += 86400) {
            $allDates[] = date('Y-m-d', $i);
        }

        // 2. Ambil data yang sudah ada SEKALI QUERY
        $existing = $this->where([
            'user_id'    => $user_id,
            'machine_id' => $machine_id
        ])->whereIn('tanggal', $allDates)
            ->findAll();

        // ubah jadi array lookup cepat
        $existingDates = array_column($existing, 'tanggal');

        $dataInsert = [];
        $duplikat   = [];

        // 3. Filter di PHP (tanpa query lagi)
        foreach ($allDates as $tanggal) {

            if (in_array($tanggal, $existingDates)) {
                $duplikat[] = $tanggal;
                continue;
            }

            $dataInsert[] = [
                'user_id'    => $user_id,
                'machine_id' => $machine_id,
                'tanggal'    => $tanggal,
                'shift_id'   => $shift_id,
                'keterangan' => $keterangan
            ];
        }

        // 4. INSERT SEKALI (BATCH)
        if (!empty($dataInsert)) {
            $this->insertBatch($dataInsert);
        }

        $berhasil = count($dataInsert);

        // 5. RESPONSE
        if ($berhasil == 0) {
            return [
                'status'  => false,
                'message' => 'Semua jadwal sudah ada'
            ];
        }

        if (count($duplikat) > 0) {
            return [
                'status'  => true,
                'message' => $berhasil . ' jadwal berhasil disimpan, sebagian sudah ada'
            ];
        }

        return [
            'status'  => true,
            'message' => 'Jadwal berhasil disimpan'
        ];
    }
}
