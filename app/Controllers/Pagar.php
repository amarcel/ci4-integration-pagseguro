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
    
    public function index()
    {
        return view('home');
    }
    public function credito(){
        return view('home2');
    }

    /**
     * Pegar o ID da sessão do PagSeguro
     *
     * @return String
     */
    public function pg_session_id(): String
    {
        helper('cookie');
        //Bloqueia para ser acessível apenas por Ajax
        if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException("1001 - Não é possível acessar", 401);


        /**
         * Analisa qual o modo de desenvolvimento para setar a URL
         */
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

    public function pg_session_id_credito(): String
    {
        helper('cookie');
        //Bloqueia para ser acessível apenas por Ajax
        if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException("1001 - Não é possível acessar", 401);


        /**
         * Analisa qual o modo de desenvolvimento para setar a URL
         */
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
            //Notificar por e-mail status de aguardando pagamento
            $email = new Email();
            $email->notificar_pg($std, 1);
        }

        //header('Content-Type: application/json');
        return json_encode($retorno);
    }

    public function pg_cartao(): String
    {
        //Bloqueia para ser acessível apenas por Ajax
       // if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException("1002 - Não é possível acessar", 401);

        /*$preco = $this->request->getVar('valor_parcela');
        $preco = (float)$preco;
        
        var_dump($this->request->getVar('valor_parcela'));
        echo $this->request->getVar('valor_parcela');

        $vv = $this->request->getVar('valor_parcela');
        $k = explode(" ",$vv);
        for($x = 0; $x < count($k); $x++){
            $y += $k[0];
        }
        echo $y;*/
        //echo $this->request->getVar('vparcela');
        /**
         * Parâmetros necessários para requisição a API
         * Dados abaixo estão apenas por via de demonstração
         */
        $pagarBoleto = array(
            //'email'         => env('api.email'),
            'email'         => env('api.email'),
            'token'         => env('api.token'),

            'paymentMode'   => 'default',
            'paymentMethod' => 'creditCard',
            'currency'      => 'BRL',  
            'receiverEmail' => env('api.email'),
            
            'extraAmount'   => '1.00',

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
            'shippingAddressRequired'=>'true',
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

            //DADOS DO DONO DO CARTÂO
            'creditCardToken' => $this->request->getVar('credit_token'),
            'installmentQuantity' => 2,//$this->request->getVar('parcelas'),
            'installmentValue' => number_format(51.50,2,'.',''),//number_format($preco, 2, '.', ''),
            'noInterestInstallmentQuantity' => number_format(50.00,2,'.',''),//$this->request->getVar('parcelas'),
            'creditCardHolderName' => 'Jose Comprador',
            'creditCardHolderCPF' => '02690170035',
            'creditCardHolderBirthDate' => '27/10/1987',
            'creditCardHolderAreaCode'=> '11',
            'creditCardHolderPhone'=> '56273440',

            'billingAddressStreet'=>"Av. Brig. Faria Lima",
            'billingAddressNumber'=>'1384',
            'billingAddressComplement'=>'5o andar',
            'billingAddressDistrict'=>'Jardim Paulistano',
            'billingAddressPostalCode'=>'01452002',
            'billingAddressCity'=>'Sao Paulo',
            'billingAddressState'=>'SP',
            'billingAddressCountry'=>'BRA'
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
            $email = new Email();
            $email->notificar_pg($std, 1);
        }

        //header('Content-Type: application/json');
        return json_encode($retorno);
    }
}
