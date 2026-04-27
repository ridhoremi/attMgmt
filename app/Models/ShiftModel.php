<?php

namespace App\Models;

use CodeIgniter\Model;

class ShiftModel extends Model
{

    protected $table = 'shift';
    protected $useTimestamps = false;
    protected $allowedFields = ['id', 'nama_shift', 'jam_masuk', 'jam_keluar', 'machine_id'];


    public function getData($start, $length)
    {

        $result = $this->db->table('shift s')
            ->select('s.id,s.nama_shift, m.nama_mesin, s.jam_masuk, s.jam_keluar')
            ->join('mesin m', 'm.machine_id = s.machine_id', 'inner')
            ->limit($length, $start)
            ->orderBy('s.id', 'DESC')
            ->get()
            ->getResultArray();

        return $result;
    }
    public function getDataSearch($search, $start, $length)
    {


        // $result = $this->like('nama_shift', $search)->findAll($start, $length);

        $result = $this->db->table('shift s')
            ->select('s.id,s.nama_shift, nama_mesin m, s.jam_masuk, s.jam_keluar')
            ->join('mesin m', 'm.machine_id = c.machine_id', 'inner');



        if ($search) {
            $result->groupStart()
                ->like('s.nama_shift', $search)
                ->orLike('m.nama_mesin', $search)
                ->groupEnd();
        }

        return $result
            ->orderBy('s.id', 'DESC')
            ->limit($length, $start)
            ->get()
            ->getResultArray();
    }

    public function getTotal()
    {
        return $this->db->table('shift s')
            ->join('mesin m', 's.machine_id = m.machine_id', 'inner')
            ->countAllResults();
    }

    public function getTotalSearch($search)
    {
        // $result = $this->like('nama_shift', $search)->countAllResults();
        // return $result;

        $result = $this->db->table('shift s')
            ->join('mesin m', 'm.machine_id = c.machine_id', 'inner');



        if ($search) {
            $result->groupStart()
                ->like('s.nama_shift', $search)
                ->orLike('m.nama_mesin', $search)
                ->groupEnd();
        }

        return $result->countAllResults();
    }

    public function rulesValidasi($method = null)
    {
        $rulesValidation = [
            'nama_shift' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Shift harus diisi.'
                ]
            ],
            'jam_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam masuk harus diisi.'
                ]
            ],
            'jam_keluar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam Keluar diisi.'
                ]
            ],
            'machine_id_shift' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Mesin harus diisi.'
                ]
            ],
        ];

        return $rulesValidation;
    }
}
