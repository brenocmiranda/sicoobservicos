<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\FuncoesRqt;
use App\Models\Atividades;
use App\Models\Funcoes;

class FuncoesCtrl extends Controller
{	
	public function __construct(){
		$this->middleware('auth');
	}
	
    // Listando todos os funções
	public function Exibir(){
		return view('gestao.administrativo.funcoes.listar');
	}
	public function Datatables(){
		return datatables()->of(Funcoes::all())
            ->editColumn('nome1', function(Funcoes $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('status1', function(Funcoes $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(Funcoes $dados){ 
                return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
	}

	// Adicionando nova função
	public function Adicionar(FuncoesRqt $request){
		$create = Funcoes::create([
			'nome' => $request->nome, 
			'status' => ($request->status == "on" ? 1 : 0),
			'ver_credito' => ($request->ver_credito == "on" ? 1 : 0),
			'gerenciar_credito' => ($request->gerenciar_credito == "on" ? 1 : 0),
			'ver_gti' => ($request->ver_gti == "on" ? 1 : 0),
			'gerenciar_gti' => ($request->gerenciar_gti == "on" ? 1 : 0),
			'ver_configuracoes' => ($request->ver_configuracoes == "on" ? 1 : 0),
			'gerenciar_configuracoes' => ($request->gerenciar_configuracoes == "on" ? 1 : 0),
			'ver_administrativo' => ($request->ver_administrativo == "on" ? 1 : 0),
			'gerenciar_administrativo' => ($request->gerenciar_administrativo == "on" ? 1 : 0),
		]);
		Atividades::create([
			'nome' => 'Cadastro de nova função administrativa',
			'descricao' => 'Você cadastrou um nova função administrativa, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.funcoes.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(FuncoesRqt $request, $id){
		Funcoes::find($id)->update([
			'nome' => $request->nome, 
			'status' => ($request->status == "on" ? 1 : 0),
			'ver_credito' => ($request->ver_credito == "on" ? 1 : 0),
			'gerenciar_credito' => ($request->gerenciar_credito == "on" ? 1 : 0),
			'ver_gti' => ($request->ver_gti == "on" ? 1 : 0),
			'gerenciar_gti' => ($request->gerenciar_gti == "on" ? 1 : 0),
			'ver_configuracoes' => ($request->ver_configuracoes == "on" ? 1 : 0),
			'gerenciar_configuracoes' => ($request->gerenciar_configuracoes == "on" ? 1 : 0),
			'ver_administrativo' => ($request->ver_administrativo == "on" ? 1 : 0),
			'gerenciar_administrativo' => ($request->gerenciar_administrativo == "on" ? 1 : 0),
		]);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações da função administrativa '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.funcoes.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$funcoes = Funcoes::find($id);
		if($funcoes->status == 1){
			Funcoes::find($id)->update(['status' => 0]);
		}else{
			Funcoes::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status da função administrativa '.$funcoes->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.funcoes.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Funcoes::find($id);
		return $dados;
	}
}
