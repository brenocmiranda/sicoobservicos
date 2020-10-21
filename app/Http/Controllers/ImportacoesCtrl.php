<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Imports\AssociadosImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportacoesCtrl extends Controller
{
   	public function __construct(){
		$this->middleware('auth');
	}

    // Listando todos os instituições
	public function Exibir(){
		return view('gestao.importacoes');
	}

	// Listando todos os instituições
	public function Importar(Request $request){
		// Recuperando nome
		// return request()->file('cli_associados')->getClientOriginalName();
		// Recuperando a extensão
		// return request()->file('cli_associados')->getClientOriginalExtension();

		Excel::import(new AssociadosImport, request()->file('cli_associados'));
		\Session::flash('upload', array(
				'class' => 'success',
				'mensagem' => 'Importação dos arquivos executadas com sucesso!'
			));
		return redirect(route('exibir.importacoes'));
	}
}
