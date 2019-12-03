<?php

/**
 * Helpers referentes a pagamentos
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */

/**
 * Retornar código de status
 *
 * @param integer $position
 * @return String
 */
function getStatusCodePag(int $position = null): String
{
    if (is_numeric($position)) {
        $types = array(
            1 => '<span class="badge badge-info btn-block">Aguardando pagamento</span>',
            2 => '<span class="badge badge-secondary btn-block">Em análise</span>',
            3 => '<span class="badge badge-success btn-block">Paga</span>',
            4 => '<span class="badge badge-success btn-block">Disponível</span>',
            5 => '<span class="badge badge-warning btn-block">Em disputa</span>',
            6 => '<span class="badge badge-info btn-block">Devolvida</span>',
            7 => '<span class="badge badge-danger btn-block">Cancelada</span>',
            8 => '<span class="badge badge-light btn-block">Debitado</span>',
            9 => '<span class="badge badge-dark btn-block">Retenção temporária</span>',
        );

        return array_key_exists($position, $types) ? '<h5>' . $types[$position] . '</h5>' : '<span class="badge badge-danger">Não encontrado</span>';
    }
    return '<span class="badge badge-danger">Não encontrado</span>';
}

/**
 * Retornar o tipo de pagamento
 *
 * @param int $position
 * @return String
 */
function getStatusTypePag(int $position = null): String
{
    if (is_numeric($position)) {
        $types = array(
            1 => 'Cartão de crédito',
            2 => 'Boleto',
            3 => 'Débito online (TEF)',
            4 => 'Saldo PagSeguro',
            5 => 'Oi Paggo',
            7 => 'Depósito em conta',
        );
        return array_key_exists($position, $types) ? $types[$position] : 'Não encontrado';
    }

    return 'Não encontrado';
}
