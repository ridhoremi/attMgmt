<?php

namespace App\Controllers;

use App\Models\KaryawanModel;


class Karyawan extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new KaryawanModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Data Karyawan',
            'content' => 'karyawan'

        ];
        return view('layout/template', $data);
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

        //validasi 
        $this->_validate('insert');

        $data = [
            'id' => $this->request->getVar('id'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
        ];
        $result = $this->model->insert($data);

        if ($result === false) {
            return $this->response->setJSON([
                'status' => false,
                'error' => $this->model->errors(),
                'db' => $this->model->db->error()
            ]);
        }
        return $this->response->setJSON([
            'status' => true,
            'insert_id' => $result
        ]);
    }


    public function _validate($method = null)
    {


        $rules = $this->model->rulesValidasi($method);

        if (!$this->validate($rules)) {

            $errors = $this->validator->getErrors();

            $data = [
                'status' => false,
                'inputerror' => array_keys($errors),
                'error_string' => array_values($errors)
            ];

            echo json_encode($data);
            exit();
        }
    }

    public function edit($id)
    {
        $data = $this->model->find($id);
        return $this->response->setJSON($data);
    }

    public function update()
    {
        // validasi (mode update)
        $this->_validate('update');

        $id = $this->request->getVar('id');

        $data = [
            'nama'   => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
        ];

        $result = $this->model->update($id, $data);

        if ($result === false) {
            return $this->response->setJSON([
                'status' => false,
                'error'  => $this->model->errors(),
                'db'     => $this->model->db->error()
            ]);
        }

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function hapus($id)
    {

        $result = $this->model->delete($id);
        if ($result === false) {
            return $this->response->setJSON([
                'status' => false,
                'error'  => $this->model->errors(),
                'db'     => $this->model->db->error()
            ]);
        }

        return $this->response->setJSON([
            'status' => true
        ]);
    }
}
