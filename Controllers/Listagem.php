<?php

namespace App\Controllers;

use App\Models\TransacoesModel;
use CodeIgniter\Controller;

/**
 * Pagina inicial com a listagem de transações
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Listagem extends Controller
{
	public function index()
	{
		helper('pagamento');
		$transacoes = new TransacoesModel();
		$data['transacoes'] = $transacoes->getTransacao();
		return view('listagem', $data);
	}
}
