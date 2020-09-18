<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\InstituicoesRqt;
use App\Models\Instituicoes;

class InstituicoesCtrl extends Controller
{	
	public function __construct(){
		$this->middleware('auth');
	}
	
    // Listando todos os instituições
	public function Exibir(){
		$dados = Instituicoes::orderBy('nome')->get();
		return view('gestao.administrativo.instituicoes.listar')->with('instituicoes', $dados);
	}

	// Adicionando nova instituições
	public function Adicionar(InstituicoesRqt $request){
		$create = Instituicoes::create([
			'nome' => $request->nome,
			'telefone' => $request->telefone, 
			'email' => $request->email, 
			'descricao' => $request->descricao, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da instituição
	public function Editar(InstituicoesRqt $request, $id){
		Instituicoes::find($id)->update([
			'nome' => $request->nome,
			'telefone' => $request->telefone, 
			'email' => $request->email, 
			'descricao' => $request->descricao, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o estado
	public function Alterar($id){
		$instituicao = Instituicoes::find($id);
		if($instituicao->status == 1){
			Instituicoes::find($id)->update(['status' => 0]);
		}else{
			Instituicoes::find($id)->update(['status' => 1]);
		}
		return response()->json(['success' => true]);
	}

	// Detallhes da instituição
	public function Detalhes($id){
		$dados = Instituicoes::find($id);
		return $dados;
	}
}
