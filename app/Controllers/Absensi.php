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

    public function index(): string
    {
        $data = [
            'title' => 'Data Absensi',
            'content' => 'absensi'


        ];
        return view('layout/template', $data);
    }

    public function list()
    {
        $startDate = $_REQUEST['startDate'] ?? null;
        $endDate   = $_REQUEST['endDate'] ?? null;
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']['value'];

        $total = $this->model->getTotal();


        if ($search != "" || $startDate || $endDate) {
            $list = $this->model->getDataFilter($search, $startDate, $endDate, $start, $length);
            $totalFiltered = $this->model->getTotalFilter($search, $startDate, $endDate);
        } else {
            $list = $this->model->getData($start, $length);
            $totalFiltered = $total;
        }

        $data = [];
        $no = $start + 1;
        foreach ($list as $temp) {
            $row = [];
            $row[] = $no;
            $row[] = $temp['nama'];
            $row[] = $temp['checktime'];
            $row[] = $temp['machine_id'];
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
}
