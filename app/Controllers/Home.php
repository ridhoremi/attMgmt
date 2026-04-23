<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home',
            'content' => 'home'


        ];
        return view('layout/template', $data);
    }
}
