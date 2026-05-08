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

    // public function getGrid($machine_id = null, $bulan = null, $tahun = null)
    // {
    //     return $this->select('jadwal_karyawan.*, shift.nama_shift')
    //         ->join('shift', 'shift.id = jadwal_karyawan.shift_id')
    //         ->where('jadwal_karyawan.machine_id', $machine_id)
    //         ->where('MONTH(tanggal)', $bulan)
    //         ->where('YEAR(tanggal)', $tahun)
    //         ->findAll();
    // }


    public function getMapJadwal($bulan = null, $tahun = null)
    {
        $db = \Config\Database::connect();

        $jadwal = $db->table('jadwal_karyawan jk')
            ->select('jk.user_id, jk.tanggal, s.nama_shift')
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
}
