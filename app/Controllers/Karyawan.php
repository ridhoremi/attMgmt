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
            'content' => 'karyawan'

        ];
        return view('layout/template', $data);
    }


    public function list()
    {
        $draw = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->model->getTotal();
        $output = [
            'length' => $length,
            // 'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total
        ];

        if ($search !== "") {
            $list = $this->model->getTotalSearch($search, $start, $length);
        } else {
            $list = $this->model->getData($start, $length);
        }

        if ($search !== "") {
            $total_search = $this->model->getTotalSearch($search);
            $output = [
                'recordsTotal' => $total_search,
                'recordsFiltered' => $total_search
            ];
        }

        $data = [];
        $no = $start + 1;
        foreach ($list as $temp) {
            $aksi = '<a href="javascript:void(0)" class="btn btn-warning" onclick="#"> Edit </a>';
            $row = [];
            $row[] = $no;
            $row[] = $temp['nama'];
            $row[] = $temp['alamat'];
            $row[] = $aksi;
            $data[] = $row;
            $no++;
        }
        $output['data'] = $data;
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

    private function _validate($method = null, $id = null)
    {
        $rules = $this->model->rulesValidasi($method, $id);

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
}
