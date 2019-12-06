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
    public function notificar_pg($std = null, $who = null): bool
    {
        if ($std == null or $who == null) return false;

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

        return $email->send();
    }
}
