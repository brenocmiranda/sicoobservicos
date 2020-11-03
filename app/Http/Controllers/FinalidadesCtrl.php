<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\FinalidadesRqt;
use App\Models\Atividades;
use App\Models\Finalidades;

class FinalidadesCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando todos os funções
	public function Exibir(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return view('credito.configuracoes.finalidades.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function Datatables(){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return datatables()->of(Finalidades::all())
	            ->editColumn('nome1', function(Finalidades $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Finalidades $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Finalidades $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'codigo', 'status1','acoes'])->make(true);
	   	}else{
			return datatables()->of(Finalidades::all())
	            ->editColumn('nome1', function(Finalidades $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Finalidades $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Finalidades $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'codigo', 'status1','acoes'])->make(true);
	   	}
	}


	// Adicionando nova função
	public function Adicionar(FinalidadesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$create = Finalidades::create([
				'nome' => $request->nome, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova finalidade de crédito',
				'descricao' => 'Você cadastrou um nova finalidade de crédito, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.finalidades.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Editando informações da função
	public function Editar(FinalidadesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			Finalidades::find($id)->update([
				'nome' => $request->nome, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Finalidades::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da finalidade de crédito '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.finalidades.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Alterar o status
	public function Alterar($id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$tipos = Finalidades::find($id);
			if($tipos->status == 1){
				Finalidades::find($id)->update(['status' => 0]);
			}else{
				Finalidades::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da finalidade de crédito '.$tipos->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.credito.armarios'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Finalidades::find($id);
		return $dados;
	}
}

