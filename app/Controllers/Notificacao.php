<?php

namespace App\Controllers;

use App\Models\TransacoesModel;
use CodeIgniter\Controller;

class Notificacao extends Controller
{

    public function __construct()
    {
        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
    }

    public function index()
    {
        $data['email'] = env('api.email');
        $data['token'] = env('api.token');

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
            $this->edit($std);
        }

        //header('Content-Type: application/json');
        echo json_encode($retorno);
    }

    public function edit($std = false)
    {
        helper('form');
        helper('pagamento');
        $model = new TransacoesModel();

        $transaction = $model->getTransacaoPorCode($std->code);

        $model->save([
            'id'    => $transaction['id'],
            'status_transacao'  => $std->status

        ]);
    }
}
