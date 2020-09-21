<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\SetoresRqt;
use App\Models\Atividades;
use App\Models\Setores;

class SetoresCtrl extends Controller
{
    // Listando todos produtos
	public function Exibir(){
		$dados = Setores::orderBy('nome')->get();
		return view('gestao.administrativo.setores.listar')->with('setores', $dados);
	}
	public function Datatables(){
		return datatables()->of(Setores::all())
            ->editColumn('nome1', function(Setores $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('status1', function(Setores $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(Setores $dados){ 
                return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
	}

	// Adicionando novo setor
	public function Adicionar(SetoresRqt $request){
		$create = Setores::create([
			'nome' => $request->nome, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de um novo setor administrativo',
			'descricao' => 'Você cadastrou um novo setor administrativo, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.setores.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações do setor
	public function Editar(SetoresRqt $request, $id){
		Setores::find($id)->update([
			'nome' => $request->nome, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do setor administrativo '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.setores.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$setores = Setores::find($id);
		if($setores->status == 1){
			Setores::find($id)->update(['status' => 0]);
		}else{
			Setores::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status do setor administrativo '.$setores->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.setores.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes do setor
	public function Detalhes($id){
		$dados = Setores::find($id);
		return $dados;
	}
}
