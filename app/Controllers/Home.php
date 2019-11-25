<?php

namespace App\Controllers;

use App\Models\TransacoesModel;
use CodeIgniter\Controller;

/**
 * Pagina inicial com a listagem de transações
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Home extends Controller
{
	public function __construct()
	{
		header("Access-Control-Allow-Origin: https://sandbox.pagseguro.uol.com.br");
	}
	public function index()
	{
		helper('pagamento');

		$model = new TransacoesModel();
		$data['transacoes'] = $model->getTransacao();
		return view('list', $data);
	}
}
