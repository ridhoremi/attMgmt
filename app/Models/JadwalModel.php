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

    public function getKehadiran($bulan = null, $tahun = null, $userid = null, $mesin = null)
    {
        return $this->db->table('jadwal_karyawan jk')
            ->select(" jk.user_id,k.nama, jk.machine_id, jk.tanggal,s.nama_shift,(SELECT MIN(co1.checktime) FROM checkinout co1 WHERE co1.user_id = jk.user_id
            AND DATE(co1.checktime) = jk.tanggal AND TIME(co1.checktime) >= s.mulaiCheckin AND TIME(co1.checktime) <= s.akhirCheckin) AS jam_masuk,(CASE WHEN s.jam_keluar < s.jam_masuk THEN
            (SELECT MAX(co2.checktime) FROM checkinout co2 WHERE co2.user_id = jk.user_id AND DATE(co2.checktime) = DATE_ADD(jk.tanggal, INTERVAL 1 DAY)
            AND TIME(co2.checktime) >= s.mulaiCheckout AND TIME(co2.checktime) <= s.akhirCheckout) ELSE(SELECT MAX(co3.checktime)FROM checkinout co3 WHERE co3.user_id = jk.user_id
            AND DATE(co3.checktime) = jk.tanggal AND TIME(co3.checktime) >= s.mulaiCheckout AND TIME(co3.checktime) <= s.akhirCheckout)END) AS jam_pulang", false)
            ->join('karyawan k', 'k.user_id = jk.user_id')
            ->join('shift s', 's.id = jk.shift_id')
            ->where('jk.user_id', $userid)
            ->where('jk.machine_id', $mesin)
            ->where('MONTH(jk.tanggal)', $bulan)
            ->where('YEAR(jk.tanggal)', $tahun)
            ->orderBy('jk.tanggal', 'ASC')
            ->get()
            ->getResultArray();
    }


    // public function getKehadiran_backup($bulan = null, $tahun = null)
    // {
    //     return $this->db->table('jadwal_karyawan jk')

    //         ->select("jk.user_id, k.nama, jk.machine_id, jk.tanggal,s.nama_shift, MIN(CASE WHEN TIME(co.checktime) BETWEEN s.mulaiCheckin AND s.akhirCheckin THEN co.checktime END) AS jam_masuk,
    //         MAX(CASE WHEN TIME(co.checktime)BETWEEN s.mulaiCheckout AND s.akhirCheckout THEN co.checktime END) AS jam_pulang", false)
    //         ->join('karyawan k', 'k.user_id = jk.user_id', 'left')
    //         ->join('shift s', 's.id = jk.shift_id', 'left')
    //         ->join('checkinout co', 'co.user_id = jk.user_id AND DATE(co.checktime) = jk.tanggal', 'left')

    //         ->where('MONTH(jk.tanggal)', $bulan)
    //         ->where('YEAR(jk.tanggal)', $tahun)

    //         ->groupBy(' jk.user_id, jk.tanggal,k.nama, jk.machine_id, s.nama_shift')
    //         ->orderBy('jk.tanggal', 'ASC')
    //         ->get()
    //         ->getResultArray();
    // }
}
