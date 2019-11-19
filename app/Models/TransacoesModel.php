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

    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    //Caso queira colocar pra BR
    /*
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    */

    public function getTransacao($id = false)
    {
        if ($id === false) {
            //Caso queira trazer o deletado com o deletedAt preenchido
            //$this->withDeleted();
            return $this->findAll();
        }
        return $this->find($id);
    }
}
