<?php

namespace App\Controllers;

use function App\Helpers\view;

class HomeController
{
    public function index()
    {
        view('home/index', [
            'title' => 'Bem-vindo ao Mini ERP'
        ]);
    }
}
