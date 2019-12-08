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
    /**
     * Listar todas transações
     * 
     * @param int $id
     * @return array
     */
    public function list($id = null)
    {
        $model = new TransacoesModel();

        if (isset($id)) {
            $query = $model->getTransacao($id);
            return $query ? $query : false;
        }

        return $model->getTransacao();
    }
}
