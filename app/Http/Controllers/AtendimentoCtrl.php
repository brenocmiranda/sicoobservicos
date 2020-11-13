<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Associados;
use App\Models\AssociadosAtividades;
use App\Models\Conglomerados;
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
	  		if($associado->RelationConglomerados){
	  			$conglomerado = Conglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
	  		}else{
	  			$conglomerado = null;
	  		}
	  		$atividades = AssociadosAtividades::where('cli_id_associado', $associado->id)->orderBy('created_at', 'DESC')->paginate(7);
	  		return view('atendimento.painel.exibir')->with('associado', $associado)->with('conglomerado', $conglomerado)->with('atividades', $atividades);
		}else{
			\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário está bloqueado, contate o administrador.'
				));
			return view('atendimento.painel.pesquisar');
		}
	}

	// Cadastrando nova atividade
	public function Atividades(Request $request){
  		AssociadosAtividades::create([
  			'tipo' => $request->tipo, 
  			'descricao' => $request->descricao, 
  			'contato' => $request->contato, 
  			'cli_id_associado' => $request->cli_id_associado,
  			'usr_id_usuario' => Auth::id(),
  		]);
  		return response()->json(['success' => true]);
	}

	// Editando a atividade
	public function Editando(Request $request){
  		AssociadosAtividades::find($request->id)->update([
  			'tipo' => $request->tipo, 
  			'descricao' => $request->descricao, 
  			'contato' => $request->contato
  		]);
  		return response()->json(['success' => true]);
	}
	
	// Detalhes da atividade
	public function Detalhes($id){
  		$atividade = AssociadosAtividades::find($id);
  		return response()->json($atividade);
	}
}
