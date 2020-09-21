<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\CategoriasRqt;
use App\Models\Atividades; 
use App\Models\Categorias;

class CategoriasCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando todos os funções
	public function Exibir(){
		return view('gestao.materiais.categorias.listar');
	}
	public function Datatables(){
		return datatables()->of(Categorias::all())
		->editColumn('nome1', function(Categorias $dados){ 
			return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
		})
		->editColumn('status1', function(Categorias $dados){
			return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
		})
		->editColumn('acoes', function(Categorias $dados){ 
			return ($dados->status == 1 ? '
				<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
				<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
				<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
				<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
		})->rawColumns(['nome1',  'status1','acoes'])->make(true);
	}

	// Adicionando nova função
	public function Adicionar(CategoriasRqt $request){
		$create = Categorias::create([
			'nome' => $request->nome, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de nova categoria',
			'descricao' => 'Você cadastrou uma nova categoria, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.todos.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(CategoriasRqt $request, $id){
		Categorias::find($id)->update([
			'nome' => $request->nome, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações a categoria '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.todos.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$tipos = Categorias::find($id);
		if($tipos->status == 1){
			Categorias::find($id)->update(['status' => 0]);
		}else{
			Categorias::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status da categoria '.$tipos->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.todos.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Categorias::find($id);
		return $dados;
	}
}
