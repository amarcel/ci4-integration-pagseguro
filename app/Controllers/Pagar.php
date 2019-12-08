<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\PagSeguro;

/**
 *  Responsável por gerar a ID de pagamento e realizar o pagamento
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */

class Pagar extends Controller
{

    public function boleto()
    {
        return view('boleto');
    }
    public function credito()
    {
        return view('credito');
    }
    /**
     * Realizar solicitação de pagamento para o PagSeguro (Boleto)
     *
     * @return String json
     */
    public function pg_boleto(): String
    {
        $pagSeguro = new PagSeguro();
        return $pagSeguro->paymentBillet($this->request->getVar());
    }

    public function pg_cartao(): String
    {
        $pagSeguro = new PagSeguro();
        return $pagSeguro->paymentCard($this->request->getVar());
    }
}
