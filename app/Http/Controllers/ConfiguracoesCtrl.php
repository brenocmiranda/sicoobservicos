<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Notifications\Cadastro;
use App\Notifications\ResetPassword;
use App\Http\Requests\FuncoesRqt;
use App\Http\Requests\UnidadesRqt;
use App\Http\Requests\InstituicoesRqt;
use App\Http\Requests\SetoresRqt;
use App\Http\Requests\UsuariosRqt; 
use App\Models\Atividades;
use App\Models\Unidades;
use App\Models\Funcoes;
use App\Models\Instituicoes;
use App\Models\Setores;
use App\Models\Usuarios;
use App\Models\Associados;
use App\Models\Imagens;
use App\Models\CogEmailsMaterial;
use App\Models\CogEmailsContrato;
use App\Models\CogEmailsChamado;

class ConfiguracoesCtrl extends Controller
{	
	public function __construct(){
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Configurações em Geral
	#-------------------------------------------------------------------
	public function Configuracoes(){
		return view('configuracoes.geral');
	}

	#-------------------------------------------------------------------
	# Administrativo (Funções)
	#-------------------------------------------------------------------
	// Listando todos os funções
	public function ExibirFuncoes(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			return view('configuracoes.administrativo.funcoes.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesFuncoes(){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
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
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }else{
        	return datatables()->of(Funcoes::all())
            ->editColumn('nome1', function(Funcoes $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('status1', function(Funcoes $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(Funcoes $dados){ 
                return '';
            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }
	}
	// Adicionando nova função
	public function AdicionarFuncoes(FuncoesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
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
				'ver_cadastro' => ($request->ver_cadastro == "on" ? 1 : 0),
				'gerenciar_cadastro' => ($request->gerenciar_cadastro == "on" ? 1 : 0),
				'ver_produtos' => ($request->ver_produtos == "on" ? 1 : 0),
				'gerenciar_produtos' => ($request->gerenciar_produtos == "on" ? 1 : 0),
				'ver_atendimento' => ($request->ver_atendimento == "on" ? 1 : 0),
				'gerenciar_atendimento' => ($request->gerenciar_atendimento == "on" ? 1 : 0),
				'ver_suporte' => ($request->ver_suporte == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova função administrativa',
				'descricao' => 'Você cadastrou um nova função administrativa, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.funcoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações da função
	public function EditarFuncoes(FuncoesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
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
				'ver_cadastro' => ($request->ver_cadastro == "on" ? 1 : 0),
				'gerenciar_cadastro' => ($request->gerenciar_cadastro == "on" ? 1 : 0),
				'ver_produtos' => ($request->ver_produtos == "on" ? 1 : 0),
				'gerenciar_produtos' => ($request->gerenciar_produtos == "on" ? 1 : 0),
				'ver_atendimento' => ($request->ver_atendimento == "on" ? 1 : 0),
				'gerenciar_atendimento' => ($request->gerenciar_atendimento == "on" ? 1 : 0),
				'ver_suporte' => ($request->ver_suporte == "on" ? 1 : 0)
			]);
			$create = Funcoes::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da função administrativa '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.funcoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarFuncoes($id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
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
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes da função
	public function DetalhesFuncoes($id){
		$dados = Funcoes::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Administrativo (Instituições)
	#-------------------------------------------------------------------
	// Listando todos os instituições
	public function ExibirInstituicoes(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$dados = Instituicoes::orderBy('nome')->get();
			return view('configuracoes.administrativo.instituicoes.listar')->with('instituicoes', $dados);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando nova instituições
	public function AdicionarInstituicoes(InstituicoesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$create = Instituicoes::create([
				'nome' => $request->nome,
				'telefone' => $request->telefone, 
				'email' => $request->email, 
				'descricao' => $request->descricao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova instituição administrativa',
				'descricao' => 'Você cadastrou um nova instituição administrativa, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.instituicoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações da instituição
	public function EditarInstituicoes(InstituicoesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			Instituicoes::find($id)->update([
				'nome' => $request->nome,
				'telefone' => $request->telefone, 
				'email' => $request->email, 
				'descricao' => $request->descricao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da instituição administrativa '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.instituicoes.administrativo'),
				'id_usuario' => Auth::id()
			]);
		}else{
			return redirect(route('403'));
		}
		return response()->json(['success' => true]);
	}
	// Alterar o status
	public function AlterarInstituicoes($id){
		$instituicao = Instituicoes::find($id);
		if($instituicao->status == 1){
			Instituicoes::find($id)->update(['status' => 0]);
		}else{
			Instituicoes::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status da instituição administrativa '.$instituicao->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.instituicoes.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}
	// Detallhes da instituição
	public function DetalhesInstituicoes($id){
		$dados = Instituicoes::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Administrativo (Setores)
	#-------------------------------------------------------------------
	// Listando todos setores
	public function ExibirSetores(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$dados = Setores::orderBy('nome')->get();
			return view('configuracoes.administrativo.setores.listar')->with('setores', $dados);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesSetores(){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
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
	    }else{
	    	return datatables()->of(Setores::all())
	            ->editColumn('nome1', function(Setores $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Setores $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Setores $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
	    }
	}
	// Adicionando novo setor
	public function AdicionarSetores(SetoresRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
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
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do setor
	public function EditarSetores(SetoresRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			Setores::find($id)->update([
				'nome' => $request->nome, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Setores::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do setor administrativo '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.setores.administrativo'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarSetores($id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
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
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do setor
	public function DetalhesSetores($id){
		$dados = Setores::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Administrativo (Unidades)
	#-------------------------------------------------------------------
   	// Listando todos os unidades
	public function ExibirUnidades(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$instituicoes = Instituicoes::where('status', 1)->get();
			$unidades = Unidades::orderBy('nome', 'ASC')->get();
			return view('configuracoes.administrativo.unidades.listar')->with('unidades', $unidades)->with('instituicoes', $instituicoes);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando nova unidades
	public function AdicionarUnidades(UnidadesRqt $request){
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
	public function EditarUnidades(UnidadesRqt $request, $id){
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
	// Alterar o status da unidade 
	public function AlterarUnidades($id){
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
	// Detallhes da unidade
	public function DetalhesUnidades($id){
		$dados = Unidades::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Administrativo (Usuários)
	#-------------------------------------------------------------------
	// Listando todos usuários
	public function ExibirUsuarios(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$associados = Associados::where('funcionario', 1)->orderBy('nome', 'asc')->get();
			$associadosTodos = Associados::where('funcionario', 1)->orderBy('nome', 'asc')->get();
			foreach ($associados as $key => $value) {
				$dados = Usuarios::where('cli_id_associado', $value->id)->first();
				if(isset($dados)){
					unset($associados[$key]);
				}
			}
			$setores = Setores::where('status', 1)->orderBy('nome', 'asc')->get();
			$funcoes = Funcoes::where('status', 1)->orderBy('nome', 'asc')->get();
			$instituicoes = Instituicoes::where('status', 1)->orderBy('nome', 'asc')->get();
			$unidades = Unidades::where('status', 1)->orderBy('nome', 'asc')->get();
			return view('configuracoes.administrativo.usuarios.listar')->with('associados', $associados)->with('associadosTodos', $associadosTodos)->with('setores', $setores)->with('funcoes', $funcoes)->with('instituicoes', $instituicoes)->with('unidades', $unidades);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesUsuarios(){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			return datatables()->of(Usuarios::where('id', '!=', Auth::id())->where('id', '<>', 1)->get())
	            ->editColumn('image', function(Usuarios $dados){ 
	                return '<div class="text-center px-3"><img class="img-circle" width="36" height="36" src="'.($dados->id_imagem != null ? asset('storage/app/'.$dados->RelationImagem->endereco) : asset('public/img/user.png'))."?".rand().'"></div>';
	            })
	            ->editColumn('funcao', function(Usuarios $dados){ 
	                return $dados->RelationFuncao->nome;
	            })
	            ->editColumn('acesso', function(Usuarios $dados){ 
	                return date('d/m/Y H:i:s', strtotime(@$dados->RelationAtividades->created_at));
	            })
	            ->editColumn('nome', function(Usuarios $dados){
	                return '<div class="text-left"><a href="javascript:void(0)" id="detalhes">'.$dados->RelationAssociado->nome.'</a><br><small>'.$dados->login.'</small></div>';
	            })
	            ->editColumn('status1', function(Usuarios $dados){
	                return '<label class="badge'.($dados->status == 'Ativo' ? " badge-success" : ($dados->status == 'Bloqueado' ? " badge-warning" : " badge-danger")).'">'.($dados->status == 'Ativo' ? "Ativo" : ($dados->status == 'Bloqueado' ? "Bloqueado" : "Desativado")).'</label>';
	            })
	            ->editColumn('acoes', function(Usuarios $dados){ 
	                return ($dados->status == 'Ativo' ? '<button class="btn btn-dark btn-xs btn-rounded mx-1" name="editar" id="editar" title="Editar informações do usuário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="resetar" id="resetar" title="Resetar senha do usuário"><i class="mx-0 mdi mdi-sync"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="alterar" id="alterar" title="Alterar estado do usuário"><i class="mx-0 mdi mdi-account-switch"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" name="editar" id="editar" title="Editar informações do usuário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="resetar" id="resetar" title="Resetar senha do usuário"><i class="mx-0 mdi mdi-sync"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="alterar" id="alterar" title="Alterar estado do usuário"><i class="mx-0 mdi mdi-account-switch"></i></button>');
	            })->rawColumns(['image', 'funcao', 'nome', 'status1', 'acoes'])->make(true);
	    }else{
	    	return datatables()->of(Usuarios::where('id', '!=', Auth::id())->where('id', '<>', 1)->get())
	            ->editColumn('image', function(Usuarios $dados){ 
	                return '<div class="text-center"><img class="img-circle" width="36" height="36" src="'.($dados->id_imagem != null ? asset('storage/app/'.$dados->RelationImagem->endereco) : asset('public/img/user.png'))."?".rand().'"></div>';
	            })
	            ->editColumn('funcao', function(Usuarios $dados){ 
	                return $dados->RelationFuncao->nome;
	            })
	            ->editColumn('nome', function(Usuarios $dados){
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationAssociado->nome.'</a>';
	            })
	            ->editColumn('status1', function(Usuarios $dados){
	                return '<label class="badge'.($dados->status == 'Ativo' ? " badge-success" : ($dados->status == 'Bloqueado' ? " badge-warning" : " badge-danger")).'">'.($dados->status == 'Ativo' ? "Ativo" : ($dados->status == 'Bloqueado' ? "Bloqueado" : "Desativado")).'</label>';
	            })
	            ->editColumn('acoes', function(Usuarios $dados){ 
	                return '';
	            })->rawColumns(['image', 'funcao', 'nome', 'status1', 'acoes'])->make(true);
	    }
	}
	// Adicionando novo usuário
	public function AdicionarUsuarios(UsuariosRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$create = Usuarios::create([
				'login' => $request->login,
				'password' => Hash::make('Sicoob4133'), 
				'email' => $request->email,
				'telefone' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $request->telefone))),
				'status' => $request->status, 
				'remember_token' => $request->_token, 
				'usr_id_setor' => $request->usr_id_setor, 
				'usr_id_funcao' => $request->usr_id_funcao, 
				'cli_id_associado' => $request->cli_id_associado, 
				'usr_id_instituicao' => $request->usr_id_instituicao, 
				'usr_id_unidade' => $request->usr_id_unidade
			]);
			
			if($create->RelationAssociado->sexo == "M"){
				// Importando imagem masculina
				if(is_dir(getcwd().'/storage/app/usuarios')){
			        $nameFile = uniqid(date('HisYmd')).'.png';
			        copy(getcwd().'/public/img/userm.png', getcwd().'/storage/app/usuarios/'.$nameFile);
			        $caminho = 'usuarios/'.$nameFile;
			        $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'usuarios']);
			        Usuarios::find($create->id)->update(['id_imagem' => $imagem->id]);
			    }else{
			        mkdir(getcwd().'/storage/app/usuarios', 0755);
			        $nameFile = uniqid(date('HisYmd')).'.png';
			        copy(getcwd().'/public/img/userm.png', getcwd().'/storage/app/usuarios/'.$nameFile);
			        $caminho = 'usuarios/'.$nameFile;
			        $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'usuarios']);
			        Usuarios::find($create->id)->update(['id_imagem' => $imagem->id]);
			    }
			}else{
				// Importando imagem feminina
				if(is_dir(getcwd().'/storage/app/usuarios')){
			        $nameFile = uniqid(date('HisYmd')).'.png';
			        copy(getcwd().'/public/img/userf.png', getcwd().'/storage/app/usuarios/'.$nameFile);
			        $caminho = 'usuarios/'.$nameFile;
			        $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'usuarios']);
			        Usuarios::find($create->id)->update(['id_imagem' => $imagem->id]);
			    }else{
			        mkdir(getcwd().'/storage/app/usuarios', 0755);
			        $nameFile = uniqid(date('HisYmd')).'.png';
			        copy(getcwd().'/public/img/userf.png', getcwd().'/storage/app/usuarios/'.$nameFile);
			        $caminho = 'usuarios/'.$nameFile;
			        $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'usuarios']);
			        Usuarios::find($create->id)->update(['id_imagem' => $imagem->id]);
			    }
			}
	        $create->notify(new Cadastro($create));
	        Atividades::create([
					'nome' => 'Cadastro de novo usuário',
					'descricao' => 'Você cadastrou um novo usuário com login: '.$create->login.'.',
					'icone' => 'mdi-plus',
					'url' => route('exibir.usuarios.administrativo'),
					'id_usuario' => Auth::id()
				]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do usuário
	public function EditarUsuarios(UsuariosRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			Usuarios::find($id)->update([
				'login' => $request->login, 
				'email' => $request->email, 
				'telefone' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $request->telefone))),
				'status' => $request->status, 
				'remember_token' => $request->_token, 
				'usr_id_setor' => $request->usr_id_setor, 
				'usr_id_funcao' => $request->usr_id_funcao, 
				'usr_id_instituicao' => $request->usr_id_instituicao, 
				'usr_id_unidade' => $request->usr_id_unidade
			]);
			$create = Usuarios::find($id);
			Atividades::create([
					'nome' => 'Edição de informações',
					'descricao' => 'Você modificou as informações do usuário '.$create->login.'.',
					'icone' => 'mdi-account-edit',
					'url' => route('exibir.usuarios.administrativo'),
					'id_usuario' => Auth::id()
				]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar status do usuário
	public function AlterarUsuarios(Request $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			Usuarios::find($id)->update(['status' => $request->status]);
			$create = Usuarios::find($id);
			Atividades::create([
					'nome' => 'Alteração de estado',
					'descricao' => 'Você alterou o status do usuário '.$create->login.'.',
					'icone' => 'mdi-account-switch',
					'url' => route('exibir.usuarios.administrativo'),
					'id_usuario' => Auth::id()
				]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Resetar a senha do usuário
	public function ResetarUsuarios($id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			Usuarios::find($id)->update([
				'password' => Hash::make('Sicoob4133'),
				'email_verified_at' => null
			]);
			$user = Usuarios::find($id);
			$user->notify(new ResetPassword($user));
			Atividades::create([
				'nome' => 'Redefinação de senha',
				'descricao' => 'Você redefiniu a senha do usuário '.$user->login.'.',
				'icone' => 'mdi-sync',
				'url' => 'javascript:void(0)',
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do usuário
	public function DetalhesUsuarios($id){
		$dados = Usuarios::find($id);
		return $dados;
	}

	#-------------------------------------------------------------------
	# E-mails
	#-------------------------------------------------------------------
	// Exibindo ajustes
	public function ExibirAjustesEmails(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$material = CogEmailsMaterial::find(1);
			$contrato = CogEmailsContrato::find(1);
			$chamado = CogEmailsChamado::find(1);
			return view('configuracoes.emails.ajustes.exibir')->with('material', $material)->with('contrato', $contrato)->with('chamado', $chamado);
		}else{
			return redirect(route('403'));
		}
	}
	// Alteranndo informações
	public function SalvarAjustesEmails(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			CogEmailsMaterial::find(1)->update([
				'email_material' => $request->email_material,
			]);
			CogEmailsContrato::find(1)->update([
				'email_contrato' => $request->email_contrato,
			]);
			CogEmailsChamado::find(1)->update([
				'email_chamado' => $request->email_chamado,
			]);
			Atividades::create([
				'nome' => 'Alteração de ajuste de e-mail',
				'descricao' => 'Você alterou as informações de ajustes de e-mail',
				'icone' => 'mdi-json',
				'url' => route('exibir.ajustes.emails'),
				'id_usuario' => Auth::id()
			]);
			\Session::flash('alteracao', array(
					'class' => 'success',
					'mensagem' => 'Seus dados foram alterados com sucesso.'
				));
			return redirect(route('exibir.ajustes.emails'));
		}else{
			return redirect(route('403'));
		}
	}
	// Exibindo mensagens
	public function ExibirMensagensEmails(){
		if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$material = CogEmailsMaterial::find(1);
			$contrato = CogEmailsContrato::find(1);
			$chamado = CogEmailsChamado::find(1);
			return view('configuracoes.emails.mensagens.exibir')->with('material', $material)->with('contrato', $contrato)->with('chamado', $chamado);
		}else{
			return redirect(route('403'));
		}
	}
	// Alteranndo informações
	public function SalvarMensagensEmails(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			CogEmailsMaterial::find(1)->update([
				'assunto_abertura_material' => $request->assunto_abertura_material,
				'abertura_solicitacao_material' => $request->abertura_solicitacao_material,
				'assunto_fechamento_material' => $request->assunto_fechamento_material,
				'fechamento_solicitacao_material' => $request->fechamento_solicitacao_material,
			]);
			CogEmailsContrato::find(1)->update([
				'assunto_abertura_contrato' => $request->assunto_abertura_contrato,
				'abertura_solicitacao_contrato' => $request->abertura_solicitacao_contrato,
				'assunto_fechamento_contrato' => $request->assunto_fechamento_contrato,
				'fechamento_solicitacao_contrato' => $request->fechamento_solicitacao_contrato,
			]);
			CogEmailsChamado::find(1)->update([
				'assunto_abertura_chamado' => $request->assunto_abertura_chamado,
				'abertura_chamado' => $request->abertura_chamado,
				'assunto_fechamento_chamado' => $request->assunto_fechamento_chamado,
				'fechamento_chamado' => $request->fechamento_chamado,
			]);

			Atividades::create([
				'nome' => 'Alteração as mensagens de e-mail',
				'descricao' => 'Você alterou as informações de mensagens de e-mail',
				'icone' => 'mdi-email-outline',
				'url' => route('exibir.mensagens.emails'),
				'id_usuario' => Auth::id()
			]);

			\Session::flash('alteracao', array(
					'class' => 'success',
					'mensagem' => 'Seus dados foram alterados com sucesso.'
				));
			return redirect(route('exibir.mensagens.emails'));
		}else{
			return redirect(route('403'));
		}
	}


	#-------------------------------------------------------------------
	# Ajustes
	#-------------------------------------------------------------------
	// Listando página
	public function ExibirPlataforma(){
        if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1 || Auth::user()->RelationFuncao->ver_configuracoes == 1){
    		$login = Imagens::where('tipo', 'login_principal')->get();
    		$homepage = Imagens::where('tipo', 'homepage_principal')->get();
    		return view('configuracoes.plataforma.geral')->with('login', $login)->with('homepage', $homepage);
        }else{
            return redirect(route('403'));
        }
	}
    // Importando nova imagens
	public function SalvarPlataforma(Request $request){
        if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
        	if($request->hasFile('login_principal') && $request->file('login_principal')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->login_principal->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->login_principal->storeAs('papelparede', $nameFile);
                $imagem = Imagens::create(['tipo' => 'login_principal', 'endereco' => $upload]);
            }  
            if($request->hasFile('homepage_principal') && $request->file('homepage_principal')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->homepage_principal->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->homepage_principal->storeAs('papelparede', $nameFile);
                $imagem = Imagens::create(['tipo' => 'homepage_principal', 'endereco' => $upload]);
            }  
            Atividades::create([
                'nome' => 'Alteração das conigurações da plataforma',
                'descricao' => 'Você alterou as configurações de imagens de fundo da plataforma.',
                'icone' => 'mdi-settings',
                'url' => route('exibir.plataforma'),
                'id_usuario' => Auth::id()
            ]);

            \Session::flash('alteracao', array(
				'class' => 'success',
				'mensagem' => 'Informações foram alteradas com sucesso.'
			));
            return redirect(route('exibir.plataforma'));
        }else{
            return redirect(route('403'));
        }
	}
}
