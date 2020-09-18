<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\ModalidadesRqt;
use App\Models\Modalidades;

class ModalidadesCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando todos os funções
	public function Exibir(){
		return view('gestao.credito.modalidades.listar');
	}
	public function Datatables(){
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
	}


	// Adicionando nova função
	public function Adicionar(ModalidadesRqt $request){
		$create = Modalidades::create([
			'nome' => $request->nome, 
			'codigo' => $request->codigo,
			'sigla' => $request->sigla,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(ModalidadesRqt $request, $id){
		Modalidades::find($id)->update([
			'nome' => $request->nome, 
			'codigo' => $request->codigo,
			'sigla' => $request->sigla,
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$tipos = Modalidades::find($id);
		if($tipos->status == 1){
			Modalidades::find($id)->update(['status' => 0]);
		}else{
			Modalidades::find($id)->update(['status' => 1]);
		}
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Modalidades::find($id);
		return $dados;
	}
}
