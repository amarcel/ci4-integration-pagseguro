<?php

namespace App\Libraries;

use Exception;

class PagSeguro
{
    /**
     * Configurações do PagSeguro
     *
     * @var \Config\PagSeguro
     */
    protected $pagSeguroConfig;

    /**
     * Email necessário para autenticação
     * 
     * @var \Config\PagSeguro::email
     * 
     */
    protected $email;

    /**
     * Token necessário para autenticação
     * 
     * @var \Config\PagSeguro::token
     * 
     */
    protected $token;


    public function __construct()
    {
        $this->pagSeguroConfig  = config('PagSeguro');
        $this->email            = $this->pagSeguroConfig->email;
        $this->token            = $this->pagSeguroConfig->token;
    }

    /**
     * Pegar o ID da sessão do PagSeguro
     * @return object json
     */
    public function getSession()
    {
        /**
         * Configurações do PagSeguro para verificar a URL
         */
        $url = $this->pagSeguroConfig->urlSession;


        $params['email'] = $this->email;
        $params['token'] = $this->token;

        try {

            $std  = $this->_getChamada($url, $params);

            if (isset($std->id)) {

                $json = [
                    'error'     =>  0,
                    'message'   => 'Sessao gerada com sucesso',
                    'id_sessao' => $std->id
                ];
            } else {

                $json = [
                    'error'     =>  1000,
                    'message'   => 'Erro ao gerar sessao de pagamento'
                ];
            }
        } catch (\Exception $e) {
            $json = [
                'error'     =>  1001,
                'message'   => 'Não foi possivel fazer a busca. Verifique se está configurado corretamente o parâmetro $email e $senha da API.',
            ];
        }

        header('Content-Type: application/json');
        return json_encode($json);
    }

    /**
     * Receber notificação do pagseguro quando alguma transação atualizar seu status
     * @param array $request Transação completa
     * @return object
     */
    public function requestNotification(array $request)
    {
        /**
         * Em modo de produção altere as variáveis env() por $this->email e $this->token
         */
        $data['email'] = $this->email;
        $data['token'] = $this->token;

        $data = http_build_query($data);

        /**
         * Configurações do PagSeguro para verificar a URL
         */
        $url = $this->pagSeguroConfig->urlNotification . $request['notificationCode'] . '?' . $data;

        $chamada = curl_init();
        curl_setopt($chamada, CURLOPT_URL, $url);
        curl_setopt($chamada, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($chamada, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($chamada, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');

        //Verificar o SSL para TRUE
        curl_setopt($chamada, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($chamada);

        curl_close($chamada);

        $xml    = simplexml_load_string($result);
        $json   = json_encode($xml);
        $std    = json_decode($json);

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
            try {
                $this->_edit($std);
                //Notificar por e-mail status de aguardando pagamento
                //Verificar se a variavel de ambiente está setada como true para usar o envio de e-mail
                $this->_notifyStatus($std, 2);
                log_message('info', 'Transação atualizada {codigo_transacao}', ['codigo_transacao' => $std->code]);
            } catch (Exception $e) {
                log_message('error', 'Erro ao receber notificação do código {codigo_transacao}. Exception {e}', ['codigo_transacao' => $std->code, 'e' => $e]);
                $retorno = [
                    'error'     => 1002,
                    'message'   => 'Erro ao receber notificação do código'
                ];
            }
        } else {

            $retorno = [
                'error'     => 1003,
                'message'   => 'Não existe código de transação'
            ];
        };

        return json_encode($retorno);
    }
    /**
     * Realizar solicitação de pagamento para o PagSeguro (Boleto)
     * @param array $request
     * @return string|bool
     */
    public function paymentBillet(array $request)
    {
        /**
         * Parâmetros necessários para requisição a API
         * Dados abaixo estão apenas por via de demonstração
         */
        $pagarBoleto = array(
            'email'         => $this->email,
            'token'         => $this->token,
            'paymentMode'   => 'default',
            'paymentMethod' => 'boleto',
            'receiverEmail' => $this->email,
            'currency'      => 'BRL',
            'extraAmount'   => '',
            'itemId1'           => $request['itemId1'],
            'itemDescription1'  => $request['itemDescription1'],
            'itemAmount1'       => number_format($request['itemAmount1'], 2, '.', ''),
            'itemQuantity1'     => $request['itemQuantity1'],
            'notificationURL'   => base_url('notificacao'),
            'reference'         => $request['ref'],
            'senderName'        => $request['nome'],
            'senderCPF'         => $request['cpf'],
            'senderAreaCode'    => $request['ddd'],
            'senderPhone'       => $request['number'],
            'senderEmail'       => $request['email'],
            'senderHash'        => $request['hash_pagamento'],

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
        /**
         * Configurações do PagSeguro para verificar a URL
         */
        $url = $this->pagSeguroConfig->urlTransaction;

        $std  = $this->_getChamada($url, $pagarBoleto);

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
            try {
                $this->_store($std);
                //Verificar se a variavel de ambiente está setada como true para usar o envio de e-mail. Notificar por e-mail status de aguardando pagamento
                $this->_notifyStatus($std, 1);
                log_message('info', 'Transação cadastrada {codigo_transacao}', ['codigo_transacao' => $std->code]);
            } catch (Exception $e) {

                log_message('error', 'Erro ao cadastrar transação {codigo_transacao}. Exception {e}', ['codigo_transacao' => $std->code, 'e' => $e]);
                $retorno = [
                    'error'     => 1004,
                    'message'   => 'Erro ao cadastrar transação do tipo boleto'
                ];
            }
        } else {
            $retorno = [
                'error'     => 1005,
                'message'   => 'Erro ao gerar transação do tipo boleto'
            ];
        }
        return json_encode($retorno);
    }

    /**
     * Pagamento por cartão de crédito
     *
     * @param array $request
     * @return string
     */
    public function paymentCard(array $request)
    {
        $preco = $request['valor_parcela'];
        //Parâmetros necessários para requisição a API Dados abaixo estão apenas por via de demonstração
        $pagarCartao = array(
            'email'         => $this->email,
            'token'         => $this->token,
            'paymentMode'   => 'default',
            'paymentMethod' => 'creditCard',
            'currency'      => 'BRL',
            'receiverEmail' => $this->email,
            'extraAmount'   => '',
            'itemId1'           => $request['itemId1'],
            'itemDescription1'  => $request['itemDescription1'],
            'itemAmount1'       => number_format($request['itemAmount1'], 2, '.', ''),
            'itemQuantity1'     => $request['itemQuantity1'],
            'notificationURL'   => base_url('notificacao'),
            'reference'         => $request['ref'],
            'senderName'        => $request['nome'],
            'senderCPF'         => $request['cpf'],
            'senderAreaCode'    => $request['ddd'],
            'senderPhone'       => $request['number'],
            'senderEmail'       => $request['email'],
            'senderHash'        => $request['hash_pagamento'],
            //Dados para implemento de frete
            'shippingAddressRequired' => 'false',

            //DADOS DO DONO DO CARTÂO
            'creditCardToken'           => $request['credit_token'],
            'installmentQuantity'       => $request['parcelas'],
            'installmentValue'          => number_format($preco, 2, '.', ''),
            'creditCardHolderName'      => 'Jose Comprador',
            'creditCardHolderCPF'       => '02690170035',
            'creditCardHolderBirthDate' => '27/10/1987',
            'creditCardHolderAreaCode'  => '11',
            'creditCardHolderPhone'     => '56273440',
            'billingAddressStreet'      => "Av. Brig. Faria Lima",
            'billingAddressNumber'      => '1384',
            'billingAddressComplement'  => '5o andar',
            'billingAddressDistrict'    => 'Jardim Paulistano',
            'billingAddressPostalCode'  => '01452002',
            'billingAddressCity'        => 'Sao Paulo',
            'billingAddressState'       => 'SP',
            'billingAddressCountry'     => 'BRA'
        );
        // Verificar se existe parcelas, se existir colocar o juros se não, não faça nada 12 é o número de parcelas que não terão juros
        $request['parcelas'] > 1 ?  $pagarCartao['noInterestInstallmentQuantity'] = 12 : null;

        //Configurações do PagSeguro para verificar a URL
        $url = $this->pagSeguroConfig->urlTransaction;

        //Chamada ao CURL
        $std  = $this->_getChamada($url, $pagarCartao);

        //Caso exista algum erro no retorno da função do pagseguro
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
            try {
                $this->_store($std);
                //Verificar se a variavel de ambiente está setada como true para usar o envio de e-mail Notificar por e-mail status de aguardando pagamento
                $this->_notifyStatus($std, 1);
                log_message('info', 'Transação cadastrada {codigo_transacao}', ['codigo_transacao' => $std->code]);
            } catch (Exception $e) {
                log_message('error', 'Erro ao cadastrar transação {codigo_transacao}. Exception {e}', ['codigo_transacao' => $std->code, 'e' => $e]);
                $retorno = [
                    'error'     => 1006,
                    'message'   => 'Erro ao cadastrar transação do tipo cartão'
                ];
            }
        } else {
            $retorno = [
                'error'     => 1007,
                'message'   => 'Erro ao gerar transação do tipo cartao'
            ];
        }
        return json_encode($retorno);
    }

    /**
     * Cadastrar nova transação no banco de dados
     *
     * @param array $std
     * @return bool
     */
    protected function _store($std = null): bool
    {
        try {
            $model = new \App\Models\TransacoesModel();
            $model->save([
                'id_pedido'             => rand(100, 500),
                'id_cliente'            => rand(100, 500),
                'codigo_transacao'      => $std->code,
                'referencia_transacao'  => $std->reference,
                'tipo_transacao'        => $std->paymentMethod->type,
                'status_transacao'      => $std->status,
                'valor_transacao'       => $std->grossAmount,
                'url_boleto'            => $std->paymentMethod->type == 2 ? $std->paymentLink : null
            ]);
            /**
             * Log de transações adicionadas
             * Format: Transação adicionada {codigo_transacao} - Código {referencia_transacao} - Valor {valor_transacao}
             */
            log_message('info', 'Transação adicionada no banco de dados {codigo_transacao} - Código {referencia_transacao} - Valor {valor_transacao}', ['codigo_transacao' => $std->code, 'referencia_transacao' => $std->reference, 'valor_transacao' => $std->grossAmount]);
            return true;
        } catch (Exception $e) {
            log_message('error', 'Erro ao cadastrar transação {codigo_transacao}. Exception {e}', ['codigo_transacao' => $std->code, 'e' => $e]);
            return false;
        }
    }

    /**
     * Atualizar uma transação ao receber o callback do PagSeguro
     * 
     * @param array $std
     * @return bool
     */
    protected function _edit($std = null): bool
    {
        if ($std == null) return false;

        try {
            $model = new \App\Models\TransacoesModel();
            $transaction = $model->getTransacaoPorRef($std->reference);
            $model->save([
                'id'                => $transaction['id'],
                'status_transacao'  => $std->status
            ]);
            /**
             * Log de transações atualizadas
             * Format: Transação atualizada {codigo_transacao} - Código {referencia_transacao} - Valor {status_transacao}
             */
            log_message('info', 'Transação atualizada no banco de dados {codigo_transacao} - Código {referencia_transacao} - Valor {status_transacao}', ['codigo_transacao' => $std->code, 'referencia_transacao' => $std->reference, 'status_transacao' => $std->status]);
            return true;
        } catch (Exception $e) {
            log_message('error', 'Erro ao cadastrar transação {codigo_transacao}. Exception {e}', ['codigo_transacao' => $std->code, 'e' => $e]);
            return false;
        }
    }

    /**
     * Chamada para o servidor pelo cURL
     *
     * @param String $url do servidor que será chamada
     * @param array $params a serem passados
     * @return array resposta
     */
    protected function _getChamada(String $url, array $params)
    {
        try {
            $chamada = curl_init();

            curl_setopt($chamada, CURLOPT_URL, $url);
            curl_setopt($chamada, CURLOPT_POST, count($params));
            curl_setopt($chamada, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($chamada, CURLOPT_CONNECTTIMEOUT, 45);
            curl_setopt($chamada, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chamada, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');

            //Verificar o SSL para TRUE
            curl_setopt($chamada, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($chamada);

            curl_close($chamada);

            $xml    = simplexml_load_string($result);
            $json   = json_encode($xml);
        } catch (\Exception $e) {
            $json = [
                'error'     => 1008,
                'message'   => 'Não foi possível gerar a chamada'
            ];
        }
        return json_decode($json);
    }

    /**
     * Realiza o envio de e-mail de acordo com cada requisição a API
     *
     * @param array $std -> Mensagem passada por completo
     * @param int $who
     * $who = 1 -> Controller | Pagar
     * $who = 2 -> Controller | Notificação
     * Assim, é posível saber se o texto será "Pedido realizado" ou "Alteração de pagamento"
     * @return boolean
     */
    protected function _notifyStatus($std = null, $who = null): bool
    {

        if ($std == null or $who == null) return false;

        /**
         * Caso esteja false não faz o envio do e-mail, apenas uma simulação para não dar erro
         */
        $configMail = config('Email');
        if ($configMail->usingEmail == false) return true;

        helper('pagamento');
        $email = \Config\Services::email();

        //Alterar no config/Email.php quando em produção $email->SMTPHost;
        $config = array(
            'protocol'   => 'smtp',
            'SMTPHost'   => $configMail->SMTPHost,
            'SMTPPort'   => $configMail->SMTPPort,
            'SMTPUser'   => $configMail->SMTPUser,
            'SMTPPass'   => $configMail->SMTPPass,
            'SMTPCrypto' => 'tls',
            'mailType'   => 'html'
        );


        //Inicializa as configurações
        $email->initialize($config);

        $email->setFrom('your@example.com', 'Sistema');
        $email->setTo($std->sender->email);
        /*
        * Setar copia no e-mail
        * $email->setCC('another@another-example.com');
        * 
        * Setar cópia oculta no e-mail
        * $email->setBCC('them@their-example.com');
        */
        $email->setSubject($who == 1 ? 'Pedido recebido com sucesso' : 'Atualização na sua compra');

        $message  = '<div style="text-align: left;">';
        $message .= '<h2>Olá ' . $std->sender->name . '</h2>';
        $message .= '<h3>Seu pedido código do pedido:  ' . $std->code . '</h3>';
        $message .= '<h3>Está:' . getStatusCodePag($std->status) . '</h3>';
        $message .= 'Data: ' . $std->date . '<br>';
        $message .= 'Referência:' . $std->reference . '<br>';
        $message .= 'Valor:' . $std->grossAmount . '<br>';
        if (isset($std->paymentLink)) {
            $message .= 'Caso não tenha acessado, aqui você pode <a href="' . $std->paymentLink . '" target="_blank" </a>baixar o boleto.<br>';
        }
        $message .= '</div>';

        $email->setMessage($message);

        /**
         * Debug do envio de e-mail
         * 
         * $email->send(false);
         * $email->printDebugger(['headers', 'subject', 'body']);
         * exit();
         */
        if ($email->send()) {
            log_message('info', 'Notificação enviada com sucesso {codigo_transacao}', ['codigo_transacao' => $std->code]);
            return true;
        } else return false;
    }
}
