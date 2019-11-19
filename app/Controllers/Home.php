<?php namespace App\Controllers;
use CodeIgniter\Controller;

class Home extends Controller
{
	public function index()
	{
	
		echo env("CI_ENVIRONMENT");

		//return view('home');
	}


}
