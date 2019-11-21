<?php

namespace App\Controllers;

use App\Models\TransacoesModel;
use CodeIgniter\Controller;

/**
 * Pagina inicial com a listagem de transações
 */
class Home extends Controller
{
	public function index()
	{
		helper('pagamento');

		$model = new TransacoesModel();
		$data['transacoes'] = $model->getTransacao();
		return view('list', $data);
	}
}
