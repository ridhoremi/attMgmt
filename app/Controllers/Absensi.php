<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class Absensi extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new AbsensiModel();
    }

    public function index()
    {
        // $data = [
        //     'title' => 'Data Absensi',
        //     'content' => 'absensi'


        // ];
        // return view('layout/template', $data);

        if ($this->request->isAJAX()) {
            return view('absensi');
        }
    }

    // public function list()
    // {
    //     $startDate = $_REQUEST['startDate'] ?? null;
    //     $endDate   = $_REQUEST['endDate'] ?? null;
    //     $draw   = $_REQUEST['draw'];
    //     $length = $_REQUEST['length'];
    //     $start  = $_REQUEST['start'];
    //     $search = $_REQUEST['search']['value'];

    //     $total = $this->model->getTotal();
    //     if ($search != "" || $startDate || $endDate) {
    //         $list = $this->model->getDataFilter($search, $startDate, $endDate, $start, $length);
    //         $totalFiltered = $this->model->getTotalFilter($search, $startDate, $endDate);
    //     } else {
    //         $list = $this->model->getData($start, $length);
    //         $totalFiltered = $total;
    //     }

    //     $data = [];
    //     $no = $start + 1;
    //     foreach ($list as $temp) {
    //         $aksi = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="hapusData(' . $temp['id'] . ')">Delete</a>';
    //         $row = [];
    //         $row[] = $no;
    //         $row[] = $temp['nama'];
    //         $row[] = $temp['checktime'];
    //         $row[] = $aksi;
    //         $row[] = $temp['machine_id'];
    //         $data[] = $row;
    //         $no++;
    //     }

    //     $output = [
    //         "draw" => intval($draw),
    //         "recordsTotal" => $total,
    //         "recordsFiltered" => $totalFiltered,
    //         "data" => $data
    //     ];

    //     echo json_encode($output);
    //     exit();
    // }

    public function list()
    {
        $request = service('request');

        $startDate = $request->getPost('start_date');
        $endDate   = $request->getPost('end_date');

        $draw   = $request->getPost('draw');
        $length = $request->getPost('length');
        $start  = $request->getPost('start');

        $search = $request->getPost('search')['value'] ?? '';

        $total = $this->model->getTotal();

        if ($search != "" || (!empty($startDate) && !empty($endDate))) {
            $list = $this->model->getDataFilter($search, $startDate, $endDate, $start, $length);
            $totalFiltered = $this->model->getTotalFilter($search, $startDate, $endDate);
        } else {
            $list = $this->model->getData($start, $length);
            $totalFiltered = $total;
        }

        $data = [];
        $no = $start + 1;

        foreach ($list as $temp) {
            $aksi = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="hapusData(' . $temp['id'] . ')">Delete</a>';

            $data[] = [
                $no++,
                $temp['nama'],
                $temp['checktime'],
                $aksi,
                $temp['machine_id']

            ];
        }

        return $this->response->setJSON([
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }
}
