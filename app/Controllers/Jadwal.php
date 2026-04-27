<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class Jadwal extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new AbsensiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Absensi',
            'content' => 'jadwal'


        ];
        return view('layout/template', $data);

        // if ($this->request->isAJAX()) {
        //     return view('absensi');
        // }
    }
}
