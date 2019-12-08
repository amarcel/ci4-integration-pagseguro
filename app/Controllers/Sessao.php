<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\PagSeguro;

/**
 *  Responsável por gerar a ID de pagamento e realizar o pagamento
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */

class Sessao extends Controller
{
    /**
     * Pegar o ID da sessão do PagSeguro
     *
     * @return object|bool
     */
    public function gerarSessao()
    {
        $pagSeguro = new PagSeguro();
        return $pagSeguro->gerarSessao();
    }
}
