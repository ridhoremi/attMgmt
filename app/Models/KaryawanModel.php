<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{

    protected $table      = 'karyawan';
    protected $useTimestamps = false;
    protected $allowedFields = ['id', 'machine_id', 'user_id', 'nama', 'alamat'];


    public function getData($start, $length)
    {
        $result = $this->orderBy('nama', 'asc')
            ->findAll($length, $start);

        return $result;
    }
    public function getDataSearch($search, $start, $length)
    {
        $result = $this->like('nama', $search)->orLike('user_id', $search)->findAll($start, $length);

        return $result;
    }

    public function getTotal()
    {
        $result = $this->countAll();

        if (isset($result)) {
            return $result;
        }
        return 0;
    }

    public function getTotalSearch($search)
    {
        $result = $this->like('nama', $search)->orLike('user_id', $search)->countAllResults();

        return $result;
    }

    public function rulesValidasi($method = null)
    {
        $rulesValidation = [
            'machine_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Mesin harus diisi.'
                ]
            ],
            'user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'User ID harus diisi.'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.'
                ]
            ],
        ];

        return $rulesValidation;
    }
}
