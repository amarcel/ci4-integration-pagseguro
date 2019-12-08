<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\PagSeguro;

/**
 * Responsável por receber a requisição do PagSeguro trata-la enviar a requisição para alterar
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Notificacao extends Controller
{

    public function __construct()
    {
        header('access-control-allow-origin: https://sandbox.pagseguro.uol.com.br');
    }

    public function index()
    {
        $pagSeguro = new PagSeguro();

        return $pagSeguro->notificacao($this->request->getVar());
    }
}
