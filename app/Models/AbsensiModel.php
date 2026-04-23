<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'checkinout';
    protected $primaryKey = 'id';
    protected $allowedFields = ['machine_id', 'user_id', 'checktime'];



    public function getData($start, $length)
    {
        return $this->db->table('checkinout c')
            ->select('c.id, c.checktime, c.machine_id, k.nama')
            ->join('karyawan k', 'k.user_id = c.user_id AND k.machine_id = c.machine_id', 'left')
            ->limit($length, $start)
            ->orderBy('c.checktime', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getTotal()
    {
        return $this->db->table('checkinout c')
            ->join('karyawan k', 'k.user_id = c.user_id AND k.machine_id = c.machine_id', 'left')
            ->countAllResults();
    }

    public function getDataFilter($search, $startDate, $endDate, $start, $length)
    {
        $builder = $this->db->table('checkinout c')
            ->select('c.id, c.checktime, c.machine_id, k.nama')
            ->join('karyawan k', 'k.user_id = c.user_id AND k.machine_id = c.machine_id', 'left');

        // 🔥 filter range tanggal
        if ($startDate && $endDate) {
            $builder->where('DATE(c.checktime) >=', $startDate);
            $builder->where('DATE(c.checktime) <=', $endDate);
        }

        // 🔍 search
        if ($search) {
            $builder->groupStart()
                ->like('k.nama', $search)
                ->orLike('c.checktime', $search)
                ->groupEnd();
        }

        return $builder
            ->limit($length, $start)
            ->orderBy('c.checktime', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getTotalFilter($search, $startDate, $endDate)
    {
        $builder = $this->db->table('checkinout c')
            ->join('karyawan k', 'k.user_id = c.user_id AND k.machine_id = c.machine_id', 'left');

        if ($startDate && $endDate) {
            $builder->where('DATE(c.checktime) >=', $startDate);
            $builder->where('DATE(c.checktime) <=', $endDate);
        }

        if ($search) {
            $builder->groupStart()
                ->like('k.nama', $search)
                ->orLike('c.checktime', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
