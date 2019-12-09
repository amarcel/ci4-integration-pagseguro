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
            1 => 'Aguardando pagamento',
            2 => 'Em análise',
            3 => 'Paga',
            4 => 'Disponível',
            5 => 'Em disputa',
            6 => 'Devolvida',
            7 => 'Cancelada',
            8 => 'Debitado',
            9 => 'Retenção temporária',
        );

        return array_key_exists($position, $types) ? $types[$position] : 'Não encontrado';
    }
    return 'Não encontrado';
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
