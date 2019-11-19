<?php namespace App\Controllers;

use App\Models\TransacoesModel;
use CodeIgniter\Controller;

class Home extends Controller
{
	public function index()
	{
		$model = new TransacoesModel();
        
		$data['transacoes'] = $model->getTransacao();
		
		return view('list', $data);
	}



}
