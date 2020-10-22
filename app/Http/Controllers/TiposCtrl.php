<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\TiposRqt;
use App\Models\Atividades;
use App\Models\Fontes;
use App\Models\Tipos;

class TiposCtrl extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}
	
    // Listando todos os funções
	public function Exibir(){
		$dados = Fontes::where('status', 1)->get();
		return view('tecnologia.configuracoes.chamados.tipos.listar')->with('fontes', $dados);
	}
	public function Datatables(){
		return datatables()->of(Tipos::all())
            ->editColumn('nome1', function(Tipos $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('status1', function(Tipos $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('fonte', function(Tipos $dados){
                return $dados->RelationTipos->nome;
            })
            ->editColumn('acoes', function(Tipos $dados){ 
                return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'status1', 'fonte', 'acoes'])->make(true);
	}

	// Adicionando nova função
	public function Adicionar(TiposRqt $request){
		$create = Tipos::create([
			'nome' => $request->nome, 
			'descricao' => $request->descricao,
			'gti_id_fontes' => $request->gti_id_fontes,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de novo tipo de chamado',
			'descricao' => 'Você cadastrou um novo tipo de chamado, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.tipos.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(TiposRqt $request, $id){
		Tipos::find($id)->update([
			'nome' => $request->nome, 
			'descricao' => $request->descricao,
			'gti_id_fontes' => $request->gti_id_fontes,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		$create = Tipos::find($id);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do tipo de chamado '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.tipos.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$tipos = Tipos::find($id);
		if($tipos->status == 1){
			Tipos::find($id)->update(['status' => 0]);
		}else{
			Tipos::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status do tipo de chamado '.$tipos->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.tipos.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Tipos::find($id);
		return $dados;
	}
}
