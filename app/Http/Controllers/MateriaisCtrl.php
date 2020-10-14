<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Notifications\SolicitacaoMaterialCliente;
use App\Notifications\SolicitacaoMaterialAdmin;
use App\Http\Requests\MateriaisRqt;
use App\Models\Atividades;
use App\Models\Materiais;
use App\Models\MateriaisCategorias;
use App\Models\MateriaisHistorico;
use App\Models\CogEmailsMaterial;

class MateriaisCtrl extends Controller
{
    public function __construct(){
    	$this->email = CogEmailsMaterial::first();
		$this->middleware('auth');
	}

	// -------------------------------------
	// Funções do módulo de suporte
	// -------------------------------------
	// Exibir solicitações
	public function ExibirSuporte(){
		$historico = MateriaisHistorico::where('id_usuario', Auth::id())->orderBy('created_at', 'DESC')->get();
		$pendencias = MateriaisHistorico::where('status', 0)->orderBy('created_at', 'DESC')->get();
		$categorias = MateriaisCategorias::where('status', 1)->get();
		return view('suporte.materiais.exibir')->with('pendencias', $pendencias)->with('requisicoes', $historico)->with('categorias', $categorias);
	}
	// Efetuar solicitação
	public function Solicitacao(Request $request){
		$create = MateriaisHistorico::create([
			'tipo' => 's',
			'quantidade' => $request->quantidade,
			'id_material' => $request->id_material, 
			'id_usuario' => Auth::id(), 
			'status' => 0,
		]);
		Auth::user()->notify(new SolicitacaoMaterialCliente($create));	
		$this->email->notify(new SolicitacaoMaterialAdmin($create));
		Atividades::create([
			'nome' => 'Solicitação de material',
			'descricao' => 'Você acabou de solicitar o material '.$create->RelationMaterial->nome.'.',
			'icone' => 'mdi-cube-send',
			'url' => route('exibir.solicitacoes.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}
	// Listando materiais para solicitação
	public function ListarMateriais($id){
		$dados = Materiais::where('id_categoria', $id)->get();
		return $dados;
	}


	// -------------------------------------
	// Funções do módulo de administrativo
	// -------------------------------------
	// Exibir solicitações
	public function ExibirSuporteAdmin(){
		$pendencias = MateriaisHistorico::where('status', 0)->orderBy('created_at', 'DESC')->get();
		$categorias = MateriaisCategorias::where('status', 1)->get();
		return view('administrativo.materiais.exibir')->with('pendencias', $pendencias)->with('categorias', $categorias);
	}
	// Aprovando solicitação
	public function SolicitacaoAprovacao($id){
		$historico = MateriaisHistorico::find($id);
		if($historico->RelationMaterial->quantidade >= $historico->quantidade){
			MateriaisHistorico::find($id)->update(['status' => 1]);
			Materiais::find($historico->id_material)->decrement('quantidade', $historico->quantidade);
			$historico->RelationUsuario->notify(new SolicitacaoMaterialCliente($historico));	
			Atividades::create([
				'nome' => 'Aprovação de solicitação de material',
				'descricao' => 'Você acabou de aprovar a solicitação do material, '.$historico->RelationMaterial->nome.'.',
				'icone' => ' mdi-cube-outline',
				'url' => route('exibir.solicitacoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return response()->json(['success' => false]);
		}
	}


	// -------------------------------------
	// Funções do módulo de configurações
	// -------------------------------------
	 // Listando todos materiais
	public function Exibir(){
		$categorias = MateriaisCategorias::where('status', 1)->get();
		return view('gestao.materiais.todos.listar')->with('categorias', $categorias);
	}
	public function Datatables(){
		return datatables()->of(Materiais::all())
            ->editColumn('nome1', function(Materiais $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
             ->editColumn('categoria1', function(Materiais $dados){ 
                return '<label>'.$dados->RelationCategoria->nome.'</label>';
            })
            ->editColumn('status1', function(Materiais $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(Materiais $dados){ 
                return ($dados->status == 1 ? '
                	<button class="btn btn-dark btn-xs btn-rounded mx-1" id="reposicao" title="Reposição de material"><i class="mx-0 mdi mdi-plus"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da material"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a material"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="reposicao" title="Reposição de material"><i class="mx-0 mdi mdi-plus"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar  material"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'status1', 'categoria1', 'acoes'])->make(true);
	}
	// Adicionando novo material
	public function Adicionar(MateriaisRqt $request){
		$create = Materiais::create([
			'nome' => $request->nome, 
			'descricao' => $request->descricao, 
			'quantidade' => $request->quantidade, 
			'quantidade_min' => $request->quantidade_min, 
			'id_categoria' => $request->id_categoria, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		Atividades::create([
			'nome' => 'Cadastro de um novo material',
			'descricao' => 'Você cadastrou um novo material, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.todos.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}
	// Editando informações do material
	public function Editar(MateriaisRqt $request, $id){
		Materiais::find($id)->update([
			'nome' => $request->nome, 
			'descricao' => $request->descricao, 
			'quantidade_min' => $request->quantidade_min, 
			'id_categoria' => $request->id_categoria, 
			'status' => ($request->status == "on" ? 1 : 0)
		]);
		$create = Materiais::find($id);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do material, '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.todos.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}
	// Alterar o status
	public function Alterar($id){
		$fontes = Materiais::find($id);
		if($fontes->status == 1){
			Materiais::find($id)->update(['status' => 0]);
		}else{
			Materiais::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status do material '.$modalidades->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.todos.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}
	// Detalhes do material
	public function Detalhes($id){
		$dados = Materiais::find($id);
		return $dados;
	}
	// Reposição de materiais
	public function Reposicao(Request $request){
		$create = MateriaisHistorico::create([
			'tipo' => 'e',
			'quantidade' => $request->quantidade,
			'id_material' => $request->id_material, 
			'id_usuario' => Auth::id(), 
			'status' => 1,
		]);
		Materiais::find($request->id_material)->increment('quantidade', $request->quantidade);
		Atividades::create([
			'nome' => 'Reposição de estoque do material',
			'descricao' => 'Você acabou de repor o estoque do material '.$create->RelationMaterial->nome.'.',
			'icone' => 'mdi-plus-one',
			'url' => route('exibir.todos.materiais'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}	
}
