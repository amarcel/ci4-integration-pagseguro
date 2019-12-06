<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Controllers\Email;
use App\Controllers\Transacoes;

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
        //Bloqueia para ser acessível apenas por Ajax
        if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException("1002 - Não é possível acessar", 401);

        /**
         * Parâmetros necessários para requisição a API
         * Dados abaixo estão apenas por via de demonstração
         */
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

            'notificationURL'   => base_url('notificacao'),

            'reference'         => $this->request->getVar('ref'),
            'senderName'        => $this->request->getVar('nome'),
            'senderCPF'         => $this->request->getVar('cpf'),
            'senderAreaCode'    => '21',
            'senderPhone'       => '998551629',
            'senderEmail'       => $this->request->getVar('email'),
            'senderHash'        => $this->request->getVar('hash_pagamento'),

            'shippingAddressRequired' => 'false'

            /*
            
            Caso queira utilizar o envio, colocar a variável acima para true e descomentar o abaixo

            'shippingAddressStreet'     => 'Av. Brig. Faria Lima',
            'shippingAddressNumber'     => '1384',
            'shippingAddressComplement' => '5o andar',
            'shippingAddressDistrict'   => 'Jardim Paulistano',
            'shippingAddressPostalCode' => '01452002',
            'shippingAddressCity'       => 'Sao Paulo',
            'shippingAddressState'      => 'SP',
            'shippingAddressCountry'    => 'BRA',
            'shippingType'              => '1',
            'shippingCost'              => '1.00',
            
            */

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

            //Notificar por e-mail status de aguardando pagamento
            //Verificar se a variavel de ambiente está setada como true para usar o envio de e-mail

            $email = new Email();
            $email->notificar_pg($std, 1);
        }

        return json_encode($retorno);
    }

    public function pg_cartao(): String
    {

        //Bloqueia para ser acessível apenas por Ajax
        if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException("1002 - Não é possível acessar", 401);

        $preco = $this->request->getVar('valor_parcela');

        /**
         * Parâmetros necessários para requisição a API
         * Dados abaixo estão apenas por via de demonstração
         */

        $pagarBoleto = array(
            'email'         => env('api.email'),
            'token'         => env('api.token'),

            'paymentMode'   => 'default',
            'paymentMethod' => 'creditCard',
            'currency'      => 'BRL',
            'receiverEmail' => env('api.email'),

            'extraAmount'   => '0.00',

            'itemId1'           => '1',
            'itemDescription1'  => 'Teste',
            'itemAmount1'       => number_format($this->request->getVar('valor'), 2, '.', ''),
            'itemQuantity1'     => '1',

            'notificationURL'   => base_url('notificacao'),

            'reference'         => $this->request->getVar('ref'),
            'senderName'        => $this->request->getVar('nome'),
            'senderCPF'         => $this->request->getVar('cpf'),
            'senderAreaCode'    => '21',
            'senderPhone'       => '998551629',
            'senderEmail'       => $this->request->getVar('email'),
            'senderHash'        => $this->request->getVar('hash_pagamento'),

            //Dados para implemento de frete
            'shippingAddressRequired' => 'false',

            /**
             * Caso queira utilizar o envio, colocar a variável acima para true e descomentar o abaixo
             */
            /*   
            'shippingAddressStreet'     => 'Av. Brig. Faria Lima',
            'shippingAddressNumber'     => '1384',
            'shippingAddressComplement' => '5o andar',
            'shippingAddressDistrict'   => 'Jardim Paulistano',
            'shippingAddressPostalCode' => '01452002',
            'shippingAddressCity'       => 'Sao Paulo',
            'shippingAddressState'      => 'SP',
            'shippingAddressCountry'    => 'BRA',
            'shippingType'              => '1',
            'shippingCost'              => '1.00',
             */


            //DADOS DO DONO DO CARTÂO
            'creditCardToken' => $this->request->getVar('credit_token'),
            'installmentQuantity' => $this->request->getVar('parcelas'),
            'installmentValue' => number_format($preco, 2, '.', ''),

            'creditCardHolderName' => 'Jose Comprador',
            'creditCardHolderCPF' => '02690170035',
            'creditCardHolderBirthDate' => '27/10/1987',
            'creditCardHolderAreaCode' => '11',
            'creditCardHolderPhone' => '56273440',

            'billingAddressStreet' => "Av. Brig. Faria Lima",
            'billingAddressNumber' => '1384',
            'billingAddressComplement' => '5o andar',
            'billingAddressDistrict' => 'Jardim Paulistano',
            'billingAddressPostalCode' => '01452002',
            'billingAddressCity' => 'Sao Paulo',
            'billingAddressState' => 'SP',
            'billingAddressCountry' => 'BRA'
        );

        /**
         * Verificar se existe parcelas, se existir colocar o juros se não, não faça nada
         * 12 é o número de parcelas que não terão juros
         */
        $this->request->getVar('parcelas') > 1 ?  $pagarBoleto['noInterestInstallmentQuantity'] = 12 : null;


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

        /**
         * Caso exista algum erro no retorno da função do pagseguro
         */
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
            //Notificar por e-mail status de aguardando pagamento
            //Verificar se a variavel de ambiente está setada como true para usar o envio de e-mail

            $email = new Email();
            $email->notificar_pg($std, 1);
        }

        //header('Content-Type: application/json');
        return json_encode($retorno);
    }
}
