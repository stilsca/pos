<?php

namespace App\Controllers;

class Home extends BaseController
{
    private $session;

    public function __construct()
    {
        $this->session = session();
    }
    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return view('login');
        }
        echo view('header');
        echo view('inicio');
        echo view('footer');
    }
}
