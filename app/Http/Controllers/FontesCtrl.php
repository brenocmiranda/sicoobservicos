<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\FontesRqt;
use App\Models\Atividades;
use App\Models\Fontes;

class FontesCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
	
    // Listando todos os funções
	public function Exibir(){
		return view('gestao.chamados.fontes.listar');
	}
	public function Datatables(){
		return datatables()->of(Fontes::all())
            ->editColumn('nome1', function(Fontes $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('status1', function(Fontes $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(Fontes $dados){ 
                return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
	}

	// Adicionando nova função
	public function Adicionar(FontesRqt $request){
		$create = Fontes::create([
			'nome' => $request->nome, 
			'descricao' => $request->descricao, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de nova fonte de aprendizagem',
			'descricao' => 'Você cadastrou um nova fonte de aprendizagem, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.fontes.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(FontesRqt $request, $id){
		Fontes::find($id)->update([
			'nome' => $request->nome, 
			'descricao' => $request->descricao, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações da fonte de aprendizagem '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.fontes.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$fontes = Fontes::find($id);
		if($fontes->status == 1){
			Fontes::find($id)->update(['status' => 0]);
		}else{
			Fontes::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status da fonte de aprendizagem '.$fontes->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.fontes.chamados'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Fontes::find($id);
		return $dados;
	}

}
