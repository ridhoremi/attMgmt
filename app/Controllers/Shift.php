<?php

namespace App\Controllers;

class Shift extends BaseController
{
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
        $data = [
            [
                "id" => 1,
                "nama_shift" => "Pagi",
                "nama_mesin" => "Mesin A",
                "jam_masuk" => "08:00",
                "jam_keluar" => "17:00"
            ],
            [
                "id" => 2,
                "nama_shift" => "Malam",
                "nama_mesin" => "Mesin B",
                "jam_masuk" => "20:00",
                "jam_keluar" => "05:00"
            ]
        ];

        return $this->response->setJSON([
            "draw" => intval($this->request->getPost("draw")),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        ]);
    }
}
