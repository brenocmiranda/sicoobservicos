<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Solicitacoes;
use App\Models\SolicitacoesStatus;
use App\Models\Contratos;

class SolicitacoesCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    // Listando todos produtos
	public function Exibir(){
		$dados = Solicitacoes::all();
		return view('credito.solicitacoes.exibir')->with('dados', $dados);
	}

	// Efetuando a solicitação
	public function Solicitar(Request $request){
	}

	// Imprimir a solicitação
	public function Imprimir($id){
	}

	// Imprimir a solicitação
	public function Remover($id){
	}

	// Alteração de status
	public function Alterar(Request $request){
		SolicitacoesStatus::create([
			'observacoes' => $request->observacoes,
			'status' => $request->status,
			'usr_id_usuario_alteracao' => Auth::id(),
			'cre_id_solicitacoes' => $request->id
		]);
	}
}
