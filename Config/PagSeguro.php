<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Classe responsável pelas URL da API do PagSeguro
 * Ao configurar o CodeIgnter acessará essas configurações
 */
class PagSeguro extends BaseConfig
{
    /**
     * E-mail para configuração do PagSeguro
     * @var String
     */
    public $email;

    /**
     * Token para configuração do PagSeguro
     * @var String
     */
    public $token;

    /**
     * URL para gerar as sessões
     * Para alterar para modo e produção basta mudar para: https://ws.pagseguro.uol.com.br/v2/sessions
     * @var String
     */
    public $urlSession = 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions';

    /**
     * URL para gerar as transações
     * 
     * @var String
     */
    public $urlTransaction = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/';


    /**
     * URL para gerar as atualizações das transações
     * Para alterar para modo e produção basta mudar para: https://ws.pagseguro.uol.com.br/v3/transactions/notifications/
     * @var String
     */
    public $urlNotification = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/';
}
