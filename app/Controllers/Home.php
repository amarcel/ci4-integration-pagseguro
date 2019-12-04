<?php

namespace App\Controllers;

use App\Controllers\Transacoes;
use CodeIgniter\Controller;

/**
 * Pagina inicial com a listagem de transações
 * @author Matheus Castro <matheuscastroweb@gmail.com>
 * @version 1.0.0
 */
class Home extends Controller
{
	public function __construct()
	{ }

	public function index()
	{
		helper('pagamento');

		$transacoes = new Transacoes();

		$data['transacoes'] = $transacoes->list();

		return view('list', $data);
	}

	public function list($id)
	{
		helper('pagamento');

		$transacoes = new Transacoes();

		$data['transacao'] = $transacoes->list($id);

		return view('listOne', $data);
	}
}
