<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pagar extends Controller
{
    public function index()
    {
        return view('home');
    }

    /**
     * Pegar o ID da sessão do PagSeguro
     *
     * @return String
     */
    public function pg_session_id(): String
    {
        //Bloqueia para ser acessível apenas por Ajax
        if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException("1001 - Não é possível acessar", 401);

        if (env('api.mode') == 'development') {
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions';
        } else {
            $url = 'https://ws.pagseguro.uol.com.br/v2/sessions';
        }

        $params['email'] = env('api.email');
        $params['token'] = env('api.token');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');

        //Verificar o SSL para TRUE
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);

        curl_close($ch);

        $xml    = simplexml_load_string($result);
        $json   = json_encode($xml);
        $std  = json_decode($json);

        if (isset($std->id)) {

            $json = [
                'error'     =>  0,
                'message'   => "Sessao gerada com sucesso",
                'id_sessao' => $std->id
            ];
        } else {

            $json = [
                'error'     =>  5000,
                'message'   => "Erro ao gerar sessao de pagamento"
            ];
        }

        header('Content-Type: application/json');
        return json_encode($json);
    }

    /**
     * Realizar solicitação de pagamento para o PagSeguro (Boleto)
     *
     * @return String json
     */
    public function pg_boleto(): String
    {
        //Bloqueia para ser acessível apenas por Ajax
        if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException("1002 - Não é possível acessar", 401);

        $pagarBoleto = array(
            'email'         => env('api.email'),
            'email'         => env('api.email'),
            'token'         => env('api.token'),
            'paymentMode'   => 'default',
            'paymentMethod' => 'boleto',
            'receiverEmail' => env('api.email'),
            'currency'      => 'BRL',
            'extraAmount'   => '',

            'itemId1'           => '1',
            'itemDescription1'  => 'Teste',
            'itemAmount1'       => $this->request->getVar('valor'),
            'itemQuantity1'     => '1',

            'notificationURL'   => '',

            'reference'         => $this->request->getVar('ref'),
            'senderName'        => $this->request->getVar('nome'),
            'senderCPF'         => $this->request->getVar('cpf'),
            'senderAreaCode'    => '21',
            'senderPhone'       => '998551629',
            'senderEmail'       => $this->request->getVar('email'),
            'senderHash'        => $this->request->getVar('hash_pagamento'),

            'shippingAddressStreet'     => 'Av. Brig. Faria Lima',
            'shippingAddressNumber'     => '1384',
            'shippingAddressComplement' => '5o andar',
            'shippingAddressDistrict'   => 'Jardim Paulistano',
            'shippingAddressPostalCode' => '01452002',
            'shippingAddressCity'       => 'Sao Paulo',
            'shippingAddressState'      => 'SP',
            'shippingAddressCountry'    => 'BRA',
            'shippingType'              => '1',
            'shippingCost'              => '1.00'
        );

        if (env('api.mode') == 'development') {
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/';
        } else {
            $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($pagarBoleto));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pagarBoleto));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');

        //Verificar o SSL para TRUE
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);

        curl_close($ch);

        $xml    = simplexml_load_string($result);
        $json   = json_encode($xml);
        $std  = json_decode($json);

        if (isset($std->error->code)) {

            $retorno = [
                'error'     =>  $std->error->code,
                'message'   => $std->error->message
            ];
        }

        if (isset($std->code)) {

            $retorno = [
                'error'     =>  0,
                'code'      => $std
            ];

            //Função para cadastrar transação
            $transacao = new Transacoes();
            $transacao->store($std);
            //$this->store($std);
        }

        //header('Content-Type: application/json');
        return json_encode($retorno);
    }
}
