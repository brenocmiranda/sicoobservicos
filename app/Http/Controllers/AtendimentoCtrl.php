<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Associados;
use App\Models\Atividades;

class AtendimentoCtrl extends Controller
{
  
  public function __construct()
	{
		$this->middleware('auth');
	}

	// Listando painel
 	public function Exibir(){
    	return view('atendimento.painel.pesquisar');
	}

	// Pesquisando associados por partes do nome
	public function Pesquisar(Request $request){
  		$search = $request->get('term');
  		$result = Associados::where('nome', 'LIKE', '%'. $search. '%')->orWhere('nome_fantasia', 'LIKE', '%'. $search. '%')->orWhere('documento', 'LIKE', '%'. $search. '%')->select('nome', 'documento', 'id')->get();
  		return response()->json($result);
	}

	// Retorno de dados completos do associado
	public function Mostrar(Request $request){
		if(isset($request->pesquisar)){
			$documento = explode(': ', $request->pesquisar);
	  		$associado = Associados::where('documento', $documento[1])->first();
	  		return view('atendimento.painel.exibir')->with('associado', $associado);
		}else{
			\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário está bloqueado, contate o administrador.'
				));
			return view('atendimento.painel.pesquisar');
		}
	}
}
