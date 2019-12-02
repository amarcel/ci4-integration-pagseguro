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
     * Criar uma nova transação
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
            'url_boleto'            => $std->paymentLink
        ]);
    }

    public function storeCredit($std = null): void
    {
        $model = new TransacoesModel();
        $model->save([
            'id_pedido'             => rand(100, 500),
            'id_cliente'            => rand(100, 500),
            'codigo_transacao'      => $std->code,
            'referencia_transacao'  => $std->reference,
            'tipo_transacao'        => $std->paymentMethod->type,
            'status_transacao'      => $std->status,
            'valor_transacao'       => $std->grossAmount
        ]);
    }

    /**
     * Atualizar uma transação
     *
     * @param array $std
     * @return void
     */
    public function edit($std = null): void
    {
        $model = new TransacoesModel();

        $transaction = $model->getTransacaoPorRef($std->reference);

        $model->save([
            'id'                => $transaction['id'],
            'status_transacao'  => $std->status

        ]);
    }
}
