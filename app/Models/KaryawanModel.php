<?php

namespace App\Models;

use CodeIgniter\Model;
use Override;

class KaryawanModel extends Model
{

    protected $table      = 'karyawan';
    protected $useTimestamps = false;
    protected $allowedFields = ['id', 'machine_id', 'user_id', 'nama', 'alamat'];


    public function getData($start = null, $length = null)
    {
        $result = $this->orderBy('nama', 'asc')
            ->findAll($length, $start);

        return $result;
    }
    public function getDataSearch($search = null, $start = null, $length = null)
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

    public function getTotalSearch($search = null)
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

    public function simpan($data = null)
    {
        $cek = $this->where('machine_id', $data['machine_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        if ($cek) {
            return [
                'status' => false,
                'inputerror' => ['machine_id', 'user_id'],
                'error_string' => [
                    'Kombinasi Machine ID dan User ID sudah ada',
                    'Kombinasi Machine ID dan User ID sudah ada'
                ]
            ];
        }
        $insert = $this->insert($data);

        if (!$insert) {
            return [
                'status' => false,
                'message' => 'Gagal insert data',
                'error' => $this->errors()
            ];
        }
        return [
            'status' => true,
            'insert_id' => $insert
        ];
    }

    public function ubah($id = null, $data = null)
    {
        $cek = $this->where('machine_id', $data['machine_id'])
            ->where('user_id', $data['user_id'])
            ->where('id !=', $id)
            ->first();

        if ($cek) {
            return [
                'status' => false,
                'inputerror' => ['machine_id', 'user_id'],
                'error_string' => [
                    'Kombinasi Machine ID dan User ID sudah ada',
                    'Kombinasi Machine ID dan User ID sudah ada'
                ]
            ];
        }
        $result = $this->update($id, $data);
        if (!$result) {
            return [
                'status' => false,
                'message' => 'Gagal Update data',
                'error' => $this->errors()
            ];
        }
        return [
            'status' => true
        ];
    }

    public function hapus($id = null)
    {

        $result = $this->delete($id);
        if (!$result) {
            return [
                'status' => false,
                'message' => 'Gagal menghapus data'
            ];
        }

        return [
            'status' => true
        ];
    }
}
