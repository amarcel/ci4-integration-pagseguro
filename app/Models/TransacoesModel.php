<?php

namespace App\Models;

use CodeIgniter\Model;

class TransacoesModel extends Model
{
    //Nome da tabela. Agora é obrigatório
    protected $table = 'transacao';
    protected $primaryKey = 'id';

    //Permitir os tempos a serem inseridos atualizados
    protected $allowedFields = ['id_pedido', 'id_cliente', 'codigo_transacao', 'data_transacao', 'tipo_transacao', 'status_transacao', 'valor_transacao', 'url_boleto', 'lastEvent'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getTransacao($id = false)
    {
        if ($id === false) {
            //Caso queira trazer o deletado com o deletedAt preenchido
            //$this->withDeleted();
            return $this->findAll();
        }
        return $this->find($id);
    }

    public function getTransacaoPorCode($code = false)
    {
        if ($code) {
            return $this->where('codigo_transacao', $code)->first();
        }
    }
}
