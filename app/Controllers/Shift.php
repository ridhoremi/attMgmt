<?php

namespace App\Controllers;

use App\Models\ShiftModel;

class Shift extends BaseController
{

    protected $model;
    public function __construct()
    {
        $this->model = new ShiftModel();
    }

    public function index()
    {
        // $data = [
        //     'title' => 'Home',
        //     'content' => 'shift'


        // ];
        // return view('layout/template', $data);
        if ($this->request->isAJAX()) {
            return view('shift');
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
            $aksi = '<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="editDataShift(' . $temp['id'] . ')">
                     <i class="bi bi-pencil"></i></a>
                  <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="hapusDataShift(' . $temp['id'] . ')">
            <i class="bi bi-trash"></i></a>';

            $row = [];
            $row[] = $no;
            $row[] = $temp['nama_shift'];
            $row[] = $temp['nama_mesin'];
            $row[] = $temp['jam_masuk'];
            $row[] = $temp['jam_keluar'];
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

        $this->_validate('insert');

        $data = [
            'nama_shift' => $this->request->getVar('nama_shift'),
            'jam_masuk' => $this->request->getVar('jam_masuk'),
            'jam_keluar' => $this->request->getVar('jam_keluar'),
            'machine_id' => $this->request->getVar('machine_id_shift'),
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

        $this->_validate('update');

        $id = $this->request->getVar('id_shift');

        $data = [
            'nama_shift' => $this->request->getVar('nama_shift'),
            'jam_masuk' => $this->request->getVar('jam_masuk'),
            'jam_keluar' => $this->request->getVar('jam_keluar'),
            'machine_id' => $this->request->getVar('machine_id_shift'),
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
