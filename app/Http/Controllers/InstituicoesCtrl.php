<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\InstituicoesRqt;
use App\Models\Atividades;
use App\Models\Instituicoes;

class InstituicoesCtrl extends Controller
{	
	public function __construct(){
		$this->middleware('auth');
	}
	
    // Listando todos os instituições
	public function Exibir(){
		$dados = Instituicoes::orderBy('nome')->get();
		return view('configuracoes.administrativo.instituicoes.listar')->with('instituicoes', $dados);
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
		Atividades::create([
			'nome' => 'Cadastro de nova instituição administrativa',
			'descricao' => 'Você cadastrou um nova instituição administrativa, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.instituicoes.administrativo'),
			'id_usuario' => Auth::id()
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
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações da instituição administrativa '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.instituicoes.administrativo'),
			'id_usuario' => Auth::id()
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
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status da instituição administrativa '.$instituicao->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.instituicoes.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da instituição
	public function Detalhes($id){
		$dados = Instituicoes::find($id);
		return $dados;
	}
}
