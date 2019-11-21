<?php 

function getStatusCodePag($position = null){
    $types = array(
        1 => 'Aguardando pagamento',
        2 => 'Em análise',
        3 => 'Paga',
        4 => 'Disponível',
        5 =>  'Em disputa', 
        6 => 'Devolvida', 
        7 => 'Cancelada',
        8 =>  'Debitado',
        9 => 'Retenção temporária', 
    );

   return  $types[$position];
    
}