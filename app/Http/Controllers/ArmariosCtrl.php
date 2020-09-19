<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\ArmariosRqt;
use App\Models\Atividades; 
use App\Models\Armarios;

class ArmariosCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando todos os funções
	public function Exibir(){
		return view('gestao.credito.armarios.listar');
	}
	public function Datatables(){
		return datatables()->of(Armarios::all())
		->editColumn('nome1', function(Armarios $dados){ 
			return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
		})
		->editColumn('referencia', function(Armarios $dados){
			return $dados->referencia;
		})
		->editColumn('status1', function(Armarios $dados){
			return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
		})
		->editColumn('acoes', function(Armarios $dados){ 
			return ($dados->status == 1 ? '
				<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
				<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
				<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
				<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
		})->rawColumns(['nome1', 'referencia', 'status1','acoes'])->make(true);
	}


	// Adicionando nova função
	public function Adicionar(ArmariosRqt $request){
		$create = Armarios::create([
			'nome' => $request->nome, 
			'referencia' => $request->referencia,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de novo armário de crédito',
			'descricao' => 'Você cadastrou um novo armário de crédito, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.credito.armarios'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(ArmariosRqt $request, $id){
		Armarios::find($id)->update([
			'nome' => $request->nome, 
			'referencia' => $request->referencia,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do armário de crédito '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.credito.armarios'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$tipos = Armarios::find($id);
		if($tipos->status == 1){
			Armarios::find($id)->update(['status' => 0]);
		}else{
			Armarios::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status do armário de crédito '.$create->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.credito.armarios'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Armarios::find($id);
		return $dados;
	}
}
