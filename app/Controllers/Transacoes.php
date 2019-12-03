<?php

namespace App\Controllers;

use App\Models\TransacoesModel;
use CodeIgniter\Controller;

/**
 * Classe responsável pela comunicação com o Model transaões
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Transacoes extends Controller
{
    public function __construct()
    { }

    /**
     * Criar uma nova transação do tipo boleto
     *
     * Type 1 = Cartão de crédito
     * Type 2 = Boleto
     * 
     * id_pedido  = Randomico até ter a tabela pedido e relaciona-la
     * id_cliente = Randomico até ter a tabela cliente e relaciona-la
     * 
     * @param array $std 
     * @return void
     */
    public function store($std = null): void
    {
        $model = new TransacoesModel();
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
    }

    /**
     * Atualizar uma transação ao receber o callback do PagSeguro
     * 
     * @param array $std
     * @return void
     */
    public function edit($std = null): void
    {
        if (!isset($std)) throw new \CodeIgniter\Exceptions\PageNotFoundException('É necessário passar campo para editar.');
        $model = new TransacoesModel();

        $transaction = $model->getTransacaoPorRef($std->reference);

        $model->save([
            'id'                => $transaction['id'],
            'status_transacao'  => $std->status
        ]);
    }
}
