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
    public function gerarPagamento(): String
    {
        $pagSeguro = new PagSeguro();
        $typePayment = $this->request->getVar('typePayment');
        /**
         * Verifica se e do tipo 2 = boleto ou tipo 1 = cartão
         */
        if ($typePayment == 2) {
            return $pagSeguro->paymentBillet($this->request->getVar());
        } else if ($typePayment == 1) {
            return $pagSeguro->paymentCard($this->request->getVar());
        }
    }
}
