<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Associados;
use App\Models\AssociadosAtividades;
use App\Models\AssociadosConglomerados;
use App\Models\Atividades;
use PDF;

class AtendimentoCtrl extends Controller
{
  
  	public function __construct()
	{
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Painel do associado
	#-------------------------------------------------------------------
	// Listando painel
 	public function ExibirPainel(){
    	return view('atendimento.painel.pesquisar');
	}
	// Pesquisando associados por partes do nome
	public function PesquisarPainel(Request $request){
  		$search = $request->get('term');
  		$result = Associados::where('nome', 'LIKE', '%'. $search. '%')->orWhere('nome_fantasia', 'LIKE', '%'. $search. '%')->orWhere('documento', 'LIKE', '%'. $search. '%')->select('nome', 'documento', 'id')->get();
  		return response()->json($result);
	}
	// Retorno de dados completos do associado
	public function MostrarPainel(Request $request){
		if(isset($request->pesquisar)){
			$documento = explode(': ', $request->pesquisar);
	  		$associado = Associados::where('documento', $documento[1])->first();
	  		if($associado->RelationConglomerados){
	  			$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
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
	public function AtividadesPainel(Request $request){
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
	public function EditandoPainel(Request $request){
  		AssociadosAtividades::find($request->id)->update([
  			'tipo' => $request->tipo, 
  			'descricao' => $request->descricao, 
  			'contato' => $request->contato
  		]);
  		return response()->json(['success' => true]);
	}
	// Detalhes da atividade
	public function DetalhesPainel($id){
  		$atividade = AssociadosAtividades::find($id);
  		return response()->json($atividade);
	}

	// Detalhes da atividade
	public function Relatorio(Request $request, $id){
	  	$associado = Associados::find($id);
	  	$atividades = AssociadosAtividades::where('cli_id_associado', $id)->orderBy('created_at', 'DESC')->get();
	  	$imprimir = $request->except('_token');
	  	if($associado->RelationConglomerados){
	  		$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
	  	}else{
	  		$conglomerado = null;
	  	}

	  	$pdf = PDF::loadView('atendimento.painel.relatorio', compact('associado', 'conglomerado', 'atividades', 'imprimir'))->setPaper('a4', 'portrait');
	    return $pdf->stream();
	}
}
