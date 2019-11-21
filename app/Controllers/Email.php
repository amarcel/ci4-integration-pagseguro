<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Pagina inicial com a listagem de transações
 */
class Email extends Controller
{
    public function notificar_pg($std): bool
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
        $email->setSubject('Notificação de pagamento');
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