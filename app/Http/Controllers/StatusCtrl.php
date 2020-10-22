<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\StatusRqt;
use App\Models\Atividades;
use App\Models\Status;

class StatusCtrl extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}
	
    // Listando todos os funções
	public function Exibir(){
		return view('tecnologia.configuracoes.chamados.status.listar');
	}
	public function Datatables(){
		return datatables()->of(Status::all())
			->editColumn('color1', function(Status $dados){ 
                return '<div class="mx-auto rounded" style="height: 38px;width: 37px; background:'.$dados->color.'""></div>';
            })
            ->editColumn('nome1', function(Status $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('tempo1', function(Status $dados){
                return substr($dados->tempo, 0, 5);
            })
            ->editColumn('status1', function(Status $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(Status $dados){ 
                return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['color1', 'nome1', 'status1', 'acoes'])->make(true);
	}

	// Adicionando nova função
	public function Adicionar(StatusRqt $request){
		/*
		if($request->open == "on"){
			Status::update(['open' => 0]);
		}
		if($request->finish == "on"){
			Status::update(['finish' => 0]);
		}*/

		$create = Status::create([
			'nome' => $request->nome, 
			'tempo' => $request->tempo,
			'color' => $request->color,
			'open' => ($request->open == "on" ? 1 : 0),
			'finish' => ($request->finish == "on" ? 1 : 0),
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de novo status de chamado',
			'descricao' => 'Você cadastrou um novo status de chamado, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.status.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(StatusRqt $request, $id){
		/*
		if($request->open == "on"){
			Status::update('open', 0);
		}
		if($request->finish == "on"){
			Status::update('finish', 0);
		}*/		
		Status::find($id)->update([
			'nome' => $request->nome, 
			'tempo' => $request->tempo,
			'color' => $request->color,
			'open' => ($request->open == "on" ? 1 : 0),
			'finish' => ($request->finish == "on" ? 1 : 0),
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		$create = Status::find($id);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do status de chamado '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.status.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$status = Status::find($id);
		if($status->status == 1){
			Status::find($id)->update(['status' => 0]);
		}else{
			Status::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status do status de chamado '.$status->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.status.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Status::find($id);
		return $dados;
	}
}
