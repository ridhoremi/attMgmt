<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{

    protected $table      = 'karyawan';
    protected $useTimestamps = false;
    protected $allowedFields = ['id', 'nama', 'alamat'];


    public function getData($start, $length)
    {
        $result = $this->orderBy('id', 'asc')
            ->findAll($length, $start);

        return $result;
    }
    public function getDataSearch($search, $start, $length)
    {
        $result = $this->like('nama', $search)->orLike('id', $search)->findAll($start, $length);

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
        $result = $this->like('nama', $search)->orLike('id', $search)->countAllResults();

        return $result;
    }

    public function rulesValidasi($method = null)
    {
        // tentukan rule untuk id
        if ($method == 'update') {
            $idRule = "required";
        } else {
            $idRule = "required|is_unique[karyawan.id]";
        }
        $rulesValidation = [
            'id' => [
                'rules' => $idRule,
                'errors' => [
                    'required' => '{field} Harus di isi.',
                    'is_unique' => '{field} Sudah digunakan.'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi.'
                ]
            ],

        ];

        return $rulesValidation;
    }
}
