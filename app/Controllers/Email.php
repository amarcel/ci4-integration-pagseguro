<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Realiza o envio de notificações por e-mail dos status das transações
 */
class Email extends Controller
{
    /**
     * Realiza o envio de e-mail de acordo com cada requisição a API
     *
     * @param array $std
     * @param int $who
     * $who = 1 -> Controller | Pagar
     * $who = 2 -> Controller | Notificação
     * @return boolean
     */
    public function notificar_pg($std, $who): bool
    {
        helper('pagamento');
        $email = \Config\Services::email();

        //Alterar no config/Email.php
        $config = array(
            'protocol' => 'smtp',
            'SMTPHost' => env('mail.host'), 
            'SMTPPort' => env('mail.port'), 
            'SMTPUser' => env('mail.user'),
            'SMTPPass' => env('mail.pass')
        );

        $email->initialize($config);

        $email->setFrom('your@example.com', 'Sistema');
        $email->setTo($std->sender->email);
        /*
        $email->setCC('another@another-example.com');
        $email->setBCC('them@their-example.com');
        */
        $email->setSubject($who == 1 ? "Pedido recebido com sucesso" : "Atualização na sua compra");
        $email->setMessage('
            Status:             ' . getStatusCodePag($std->status) . '

            Seu pedido código:  ' . $std->code . '
            Data:               ' . $std->date . '
            Referência:         ' . $std->reference . '
            Valor:              ' . $std->grossAmount . '

            Nome:               ' . $std->sender->name . '
            Endereço:           ' . $std->grossAmount . '


            <a href="' . $std->paymentLink . '">Baixar boleto</a> 
        ');


        return $email->send();
    }
}