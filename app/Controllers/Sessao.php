<?php

namespace App\Controllers;

use CodeIgniter\Controller;

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
     * @return String
     */
    public function gerarSessao(): String
    {
        //Bloqueia para ser acessível apenas por Ajax
        if (!($this->request->isAJAX())) throw new \CodeIgniter\Exceptions\PageNotFoundException('1001 - Não é possível acessar', 401);

        /**
         * Configurações do PagSeguro para verificar a URL
         */
        $pagSeguroConfig = new \Config\PagSeguro();
        $url = $pagSeguroConfig->urlSession;

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
                'message'   => 'Sessao gerada com sucesso',
                'id_sessao' => $std->id
            ];
        } else {

            $json = [
                'error'     =>  5000,
                'message'   => 'Erro ao gerar sessao de pagamento'
            ];
        }

        header('Content-Type: application/json');

        return json_encode($json);
    }
}
