<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\ModalidadesRqt;
use App\Models\Atividades;
use App\Models\Modalidades;

class ModalidadesCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando todos os funções
	public function Exibir(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return view('credito.configuracoes.modalidades.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function Datatables(){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return datatables()->of(Modalidades::all())
	            ->editColumn('nome1', function(Modalidades $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('sigla', function(Modalidades $dados){
	                return $dados->sigla;
	            })
	            ->editColumn('status1', function(Modalidades $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Modalidades $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'sigla', 'status1','acoes'])->make(true);
	   	}else{
	   		return datatables()->of(Modalidades::all())
	            ->editColumn('nome1', function(Modalidades $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('sigla', function(Modalidades $dados){
	                return $dados->sigla;
	            })
	            ->editColumn('status1', function(Modalidades $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Modalidades $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'sigla', 'status1','acoes'])->make(true);
	   	}
	}

	// Adicionando nova função
	public function Adicionar(ModalidadesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$create = Modalidades::create([
				'nome' => $request->nome, 
				'codigo' => $request->codigo,
				'sigla' => $request->sigla,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova modalidade de crédito',
				'descricao' => 'Você cadastrou um nova modalidade de crédito, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.modalidades.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Editando informações da função
	public function Editar(ModalidadesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			Modalidades::find($id)->update([
				'nome' => $request->nome, 
				'codigo' => $request->codigo,
				'sigla' => $request->sigla,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create	= Modalidades::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da modalidade de crédito '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.modalidades.credito'),
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
			$modalidades = Modalidades::find($id);
			if($modalidades->status == 1){
				Modalidades::find($id)->update(['status' => 0]);
			}else{
				Modalidades::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da modalidade de crédito '.$modalidades->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.modalidades.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Modalidades::find($id);
		return $dados;
	}
}
