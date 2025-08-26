<?php

namespace App\Controllers;

use App\Helpers\Util;

class HomeController
{
    public function index()
    {
        Util::view('home/index', [
            'title' => 'Bem-vindo ao Mini ERP'
        ]);
    }
}