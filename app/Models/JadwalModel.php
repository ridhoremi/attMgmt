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

    public function getGrid($machine_id = null, $bulan = null, $tahun = null)
    {
        return $this->select('jadwal_karyawan.*, shift.nama_shift')
            ->join('shift', 'shift.id = jadwal_karyawan.shift_id')
            ->where('jadwal_karyawan.machine_id', $machine_id)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->findAll();
    }
}
