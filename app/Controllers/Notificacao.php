<?php

namespace App\Controllers;

use App\Controllers\Transacoes;
use App\Controllers\Email;
use CodeIgniter\Controller;

/**
 * Responsável por receber a requisição do PagSeguro trata-la enviar a requisição para alterar
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Notificacao extends Controller
{

    public function __construct()
    {
        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
    }

    public function index()
    {
        $data = array(
            'email' => env('api.email'),
            'token' => env('api.token')
        );

        $data = http_build_query($data);

        if (env('api.mode') == 'development') {
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/' . $this->request->getVar('notificationCode') . '?' . $data;
        } else {
            $url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/' . $this->request->getVar('notificationCode') . '?' . $data;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');

        //Verificar o SSL para TRUE
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);

        curl_close($ch);

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

            $this->response->setStatusCode(200);

            //Função para cadastrar transação
            $transacao = new Transacoes();
            $transacao->edit($std);
            //Notificar por e-mail status de aguardando pagamento
            //Verificar se a variavel de ambiente está setada como true para usar o envio de e-mail
            if (env('mail.using') == true) {
                $email = new Email();
                $email->notificar_pg($std, 2);
            }
        } else throw new \CodeIgniter\Exceptions\ModelException("Não foi possível realizar essa requisição", 404);
        //header('Content-Type: application/json');
        return json_encode($retorno);
    }
}
