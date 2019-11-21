<?php

/**
 * Retornar código de status
 *
 * @param integer $position
 * @return String
 */
function getStatusCodePag(int $position = null): String
{
    $types = array(
        1 => '<span class="badge badge-info">Aguardando pagamento</span>',
        2 => '<span class="badge badge-secondary">Em análise</span>',
        3 => '<span class="badge badge-success">Paga</span>',
        4 => '<span class="badge badge-success">Disponível</span>',
        5 => '<span class="badge badge-warning">Em disputa</span>',
        6 => '<span class="badge badge-info">Devolvida</span>',
        7 => '<span class="badge badge-danger">Cancelada</span>',
        8 => '<span class="badge badge-light">Debitado</span>',
        9 => '<span class="badge badge-dark">Retenção temporária</span>',
    );

    return  $types[$position];
}

/**
 * Retornar o tipo de pagamento
 *
 * @param int $position
 * @return String
 */
function getStatusTypePag(int $position = null): String
{
    $types = array(
        1 => '<span class="badge badge-secondary">Cartão de crédito</span>',
        2 => '<span class="badge badge-secondary">Boleto</span>',
        3 => '<span class="badge badge-secondary">Débito online (TEF)</span>',
        4 => '<span class="badge badge-secondary">Saldo PagSeguro</span>',
        5 => '<span class="badge badge-secondary">Oi Paggo</span>',
        7 => '<span class="badge badge-secondary">Depósito em conta</span>',
    );

    return  $types[$position];
}
