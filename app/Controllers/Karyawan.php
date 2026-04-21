<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use PhpParser\Node\Stmt\Echo_;
use SebastianBergmann\Type\FalseType;

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
            $row = [];
            $row[] = $no;
            $row[] = $temp['nama'];
            $row[] = $temp['alamat'];
            $data[] = $row;
            $no++;
        }
        $output['data'] = $data;
        echo json_encode($output);
        exit();
    }

    public function simpan()
    {

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

    public function _validate($method)
    {
        if (!$this->validate($this->model->rulesValidasi($method))) {
            $validation = \config\Services::validation();
            $data = [];
            $data['error_string'] = [];
            $data['inputerror'] = [];
            $data['status'] = TRUE;

            if ($validation->hasError('id')) {
                $data['inputerror'][] = 'id';
                $data['error_string'][] = $validation->getError('id');
                $data['status'] = FALSE;
            }

            if ($validation->hasError('nama')) {
                $data['inputerror'][] = 'nama';
                $data['error_string'][] = $validation->getError('nama');
                $data['status'] = FALSE;
            }

            if ($data['status'] === FALSE) {
                echo json_encode($data);
                exit();
            }
        }
    }
}
