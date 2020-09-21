<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\ProdutosCredRqt;
use App\Models\Atividades;
use App\Models\ProdutosCred;

class ProdutosCredCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando todos os funções
	public function Exibir(){
		return view('gestao.credito.produtos.listar');
	}
	public function Datatables(){
		return datatables()->of(ProdutosCred::all())
            ->editColumn('nome1', function(ProdutosCred $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('codigo', function(ProdutosCred $dados){
                return $dados->codigo;
            })
            ->editColumn('status1', function(ProdutosCred $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(ProdutosCred $dados){ 
                return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'codigo', 'status1','acoes'])->make(true);
	}

	// Adicionando nova função
	public function Adicionar(ProdutosCredRqt $request){
		$create = ProdutosCred::create([
			'nome' => $request->nome, 
			'codigo' => $request->codigo,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de novo produto de crédito',
			'descricao' => 'Você cadastrou um novo produto de crédito, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.produtos.credito'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(ProdutosCredRqt $request, $id){
		ProdutosCred::find($id)->update([
			'nome' => $request->nome, 
			'codigo' => $request->codigo,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do produto de crédito '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.modalidades.credito'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$produtos = ProdutosCred::find($id);
		if($produtos->status == 1){
			ProdutosCred::find($id)->update(['status' => 0]);
		}else{
			ProdutosCred::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status do produto de crédito '.$produtos->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.modalidades.credito'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = ProdutosCred::find($id);
		return $dados;
	}

}
