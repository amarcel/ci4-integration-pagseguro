<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TransacoesModel;


class Pagar extends Controller
{
    public function index(){
       
            return view('home');
       
    }

    public function pg_session_id()
    {
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
        echo json_encode($json);
    }

    public function pg_boleto()
    {
        $pagarBoleto['email'] = env('api.email');
        $pagarBoleto['token'] = env('api.token');
        $pagarBoleto['paymentMode'] = 'default';
        $pagarBoleto['paymentMethod'] = 'boleto';
        $pagarBoleto['receiverEmail'] = env('api.email');
        $pagarBoleto['currency'] = 'BRL';
        $pagarBoleto['extraAmount'] = '';

        $pagarBoleto['itemId1'] = '1';
        $pagarBoleto['itemDescription1'] = 'Teste';
        $pagarBoleto['itemAmount1'] = '10.00';
        $pagarBoleto['itemQuantity1'] = '1';

        $pagarBoleto['notificationURL'] = '';

        $pagarBoleto['reference'] = $this->request->getVar('ref');
        $pagarBoleto['senderName'] = $this->request->getVar('nome');
        $pagarBoleto['senderCPF'] = $this->request->getVar('cpf');
        $pagarBoleto['senderAreaCode'] = '21';
        $pagarBoleto['senderPhone'] = '998551629';
        $pagarBoleto['senderEmail'] = $this->request->getVar('email');
        $pagarBoleto['senderHash'] = $this->request->getVar('hash_pagamento');

        $pagarBoleto['shippingAddressStreet'] = 'Av. Brig. Faria Lima';
        $pagarBoleto['shippingAddressNumber'] = '1384';
        $pagarBoleto['shippingAddressComplement'] = '5o andar';
        $pagarBoleto['shippingAddressDistrict'] = 'Jardim Paulistano';
        $pagarBoleto['shippingAddressPostalCode'] = '01452002';
        $pagarBoleto['shippingAddressCity'] = 'Sao Paulo';
        $pagarBoleto['shippingAddressState'] = 'SP';
        $pagarBoleto['shippingAddressCountry'] = 'BRA';
        $pagarBoleto['shippingType'] = '1';
        $pagarBoleto['shippingCost'] = '1.00';

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
                'code'   => $std
            ];

            //Função para cadastrar transação
            $this->store($std);
        }

        //header('Content-Type: application/json');
        echo json_encode($retorno);
    }

    private function store($std): void
    {
        //Load model TransaçõesModel - ADD USE HEADER THE CODE
        $model = new TransacoesModel();

        $model->save([
            'id_pedido'         => rand(100, 500),
            'id_cliente'        => rand(100, 500),
            'codigo_transacao'  => $std->code,
            'tipo_transacao'    => $std->type,
            'status_transacao'  => $std->status,
            'valor_transacao'   => $std->grossAmount,
            'url_boleto'        => $std->paymentLink
        ]);
    }
}
