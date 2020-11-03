<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\UnidadesRqt;
use App\Models\Atividades;
use App\Models\Unidades;
use App\Models\Instituicoes;

class UnidadesCtrl extends Controller
{	
	public function __construct(){
		$this->middleware('auth');
	}
	
   // Listando todos os instituições
	public function Exibir(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$instituicoes = Instituicoes::where('status', 1)->get();
			$unidades = Unidades::orderBy('nome', 'ASC')->get();
			return view('configuracoes.administrativo.unidades.listar')->with('unidades', $unidades)->with('instituicoes', $instituicoes);
		}else{
			return redirect(route('403'));
		}
	}

	// Adicionando novo item
	public function Adicionar(UnidadesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$create = Unidades::create([
				'nome' => $request->nome,
				'referencia' => $request->referencia,
				'usr_id_instituicao' => $request->usr_id_instituicao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de um novo setor administrativo',
				'descricao' => 'Você cadastrou um novo setor administrativo, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.instituicoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Editando informações 
	public function Editar(UnidadesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			Unidades::find($id)->update([
				'nome' => $request->nome,
				'referencia' => $request->referencia,
				'usr_id_instituicao' => $request->usr_id_instituicao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Unidades::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da unidade administrativa '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.instituicoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Alterar o estado 
	public function Alterar($id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$unidades = Unidades::find($id);
			if($unidades->status == 1){
				Unidades::find($id)->update(['status' => 0]);
			}else{
				Unidades::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da unidade administrativa '.$unidades->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.instituicoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}

	// Detallhes
	public function Detalhes($id){
		$dados = Unidades::find($id);
		return $dados;
	}
}
