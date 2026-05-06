<?php

namespace App\Controllers;

use App\Models\KaryawanModel;


class Karyawan extends BaseController
{
    protected KaryawanModel $model;
    public function __construct()
    {
        $this->model = new KaryawanModel();
    }

    public function index()
    {

        // $data = [
        //     'title' => 'Data Karyawan',
        //     'content' => 'karyawan'

        // ];
        // return view('layout/template', $data);

        if ($this->request->isAJAX()) {
            return view('karyawan');
        }
    }


    public function list()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];
        $total = $this->model->getTotal();

        if ($search != "") {
            $list = $this->model->getDataSearch($search, $start, $length);
            $totalFiltered = $this->model->getTotalSearch($search);
        } else {
            $list = $this->model->getData($start, $length);
            $totalFiltered = $total;
        }

        $data = [];
        $no = $start + 1;

        foreach ($list as $temp) {
            $aksi = '<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="editData(' . $temp['id'] . ')">Edit</a>
                 <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="hapusData(' . $temp['id'] . ')">Delete</a>';

            $row = [];
            $row[] = $no;
            $row[] = $temp['nama'];
            $row[] = $temp['alamat'];
            $row[] = $aksi;

            $data[] = $row;
            $no++;
        }

        $output = [
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ];

        echo json_encode($output);
        exit();
    }


    public function simpan()
    {
        $validasi = $this->_validate('insert');
        if ($validasi !== true) {
            return $validasi;
        }

        $data = [
            'machine_id' => $this->request->getPost('machine_id'),
            'user_id'    => $this->request->getPost('user_id'),
            'nama'       => $this->request->getPost('nama'),
            'alamat'     => $this->request->getPost('alamat'),
        ];

        $result = $this->model->simpan($data);

        return $this->response->setJSON($result);
    }

    public function update()
    {

        $validasi = $this->_validate('update');
        if ($validasi !== true) {
            return $validasi;
        }

        $id = $this->request->getPost('id');
        $data = [
            'machine_id' => $this->request->getPost('machine_id'),
            'user_id'    => $this->request->getPost('user_id'),
            'nama'   => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $result = $this->model->ubah($id, $data);
        return $this->response->setJSON($result);
    }

    public function _validate($method = null)
    {
        $rules = $this->model->rulesValidasi($method);

        if (!$this->validate($rules)) {

            $errors = $this->validator->getErrors();

            return $this->response->setJSON([
                'status' => false,
                'inputerror' => array_keys($errors),
                'error_string' => array_values($errors)
            ]);
        }

        return true;
    }

    public function edit($id = null)
    {
        $data = $this->model->find($id);
        return $this->response->setJSON($data);
    }

    public function hapus($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ID tidak ditemukan'
            ]);
        }
        $result = $this->model->hapus($id);
        return $this->response->setJSON($result);
    }
}
