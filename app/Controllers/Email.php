<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Realiza o envio de notificações por e-mail dos status das transações
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Email extends Controller
{
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
    public function notificar_pg($std, $who): bool
    {
        /**
         * Caso esteja false não faz o envio do e-mail, apenas uma simulação para não dar erro
         */
        if (env('mail.using') == false) return true;

        helper('pagamento');
        $email = \Config\Services::email();

        //Alterar no config/Email.php
        $config = array(
            'protocol'   => 'smtp',
            'SMTPHost'   => env('mail.host'),
            'SMTPPort'   => env('mail.port'),
            'SMTPUser'   => env('mail.user'),
            'SMTPPass'   => env('mail.pass'),
            'SMTPCrypto' => 'tls',
            'mailType'   => 'html'
        );

        //Inicializa as configurações
        $email->initialize($config);

        $email->setFrom('your@example.com', 'Sistema');
        $email->setTo($std->sender->email);
        /*
        $email->setCC('another@another-example.com');
        $email->setBCC('them@their-example.com');
        */
        $email->setSubject($who == 1 ? "Pedido recebido com sucesso" : "Atualização na sua compra");

        $email->setMessage('
        <div style="text-align: center;">
            <h2>Olá ' . $std->sender->name . '</h2><br>
            <h2>Código do pedido:  ' . $std->code . '</h2>
            <h3>Status:' . getStatusCodePag($std->status) . '</h3>
            <br>
            
            Data:               ' . $std->date . '<br>
            Referência:         ' . $std->reference . '<br>
            Valor:              ' . $std->grossAmount . '<br>
            
         </div>
        ');


        return $email->send();
    }
}
