<?php

namespace App\Controllers;

use CodeIgniter\Controller;


/**
 * Pagina inicial os status de variáveis
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Home extends Controller
{
    public function index()
    {
        return view('home');
    }
}
