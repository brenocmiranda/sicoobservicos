<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Notifications\ResetPassword;
use App\Notifications\Cadastro;
use App\Notifications\Recuperacao;
use App\Http\Requests\LoginRqt; 
use App\Http\Requests\UsuariosRqt; 
use App\Models\Atividades; 
use App\Models\Base; 
use App\Models\Usuarios;
use App\Models\Funcoes;
use App\Models\Setores;
use App\Models\Instituicoes;
use App\Models\Unidades;
use App\Models\Associados;
use App\Models\Emails;
use App\Models\Telefones;
use App\Models\Imagens;

class UsuariosCtrl extends Controller
{
	#-------------------------------------------------------------------
	# Funções de gestão
	#-------------------------------------------------------------------
	// Listando todos usuários
	public function Exibir(){
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
	public function Datatables(){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			return datatables()->of(Usuarios::where('id', '!=', Auth::id())->get())
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
	                return ($dados->status == 'Ativo' ? '<button class="btn btn-dark btn-xs btn-rounded mx-1" name="editar" id="editar" title="Editar informações do usuário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="resetar" id="resetar" title="Resetar senha do usuário"><i class="mx-0 mdi mdi-sync"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="alterar" id="alterar" title="Alterar estado do usuário"><i class="mx-0 mdi mdi-account-switch"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" name="editar" id="editar" title="Editar informações do usuário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="resetar" id="resetar" title="Resetar senha do usuário"><i class="mx-0 mdi mdi-sync"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" name="alterar" id="alterar" title="Alterar estado do usuário"><i class="mx-0 mdi mdi-account-switch"></i></button>');
	            })->rawColumns(['image', 'funcao', 'nome', 'status1', 'acoes'])->make(true);
	    }else{
	    	return datatables()->of(Usuarios::where('id', '!=', Auth::id())->get())
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
	public function Adicionar(UsuariosRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			$create = Usuarios::create([
				'login' => $request->login,
				'password' => Hash::make('Sicoob4133'), 
				'email' => $request->email,
				'telefone' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $request->telefone))),
				'status' => $request->status, 
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
	public function Editar(UsuariosRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1){
			Usuarios::find($id)->update([
				'login' => $request->login, 
				'email' => $request->email, 
				'telefone' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $request->telefone))),
				'status' => $request->status, 
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
	public function Alterar(Request $request, $id){
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
	public function Resetar($id){
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
	public function Detalhes($id){
		$dados = Usuarios::find($id);
		return $dados;
	}

	#-------------------------------------------------------------------
	# Funções da plataforma
	#-------------------------------------------------------------------
    // Tela de login
	public function Login(){
		if (Auth::check() && Auth::user()->status == "Ativo") {
			return redirect(route('inicio'));
		}else{
			$login = Imagens::where('tipo', 'login_principal')->get();
			return view('system.login')->with('login', $login);
		}
	}
	// Autenticação de usuário
	public function Redirecionar(LoginRqt $request){
		//Auth::logoutOtherDevices($request->password);
		if (Auth::attempt(['login' => $request->login, 'password' => $request->password])){
			if(Usuarios::where('login', $request->login)->where('status', 'Ativo')->first()){
				Atividades::create([
					'nome' => 'Inicio de sessão',
					'descricao' => 'Você entrou na plataforma.',
					'icone' => 'mdi-check',
					'url' => route('inicio'),
					'id_usuario' => Auth::id()
				]);
				Usuarios::where('login', $request->login)->update(['attempts' => 0]);
				return redirect()->intended(route('inicio'));
			}elseif (Usuarios::where('login', $request->login)->where('status', 'Desativado')->first()){
				\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário está desativado, contate o administrador.'
				));
				return redirect()->route('login');
			}elseif(Usuarios::where('login', $request->login)->where('status', 'Bloqueado')->first()){
				\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário está bloqueado, contate o administrador.'
				));
				return redirect()->route('login');
			}
		}elseif(Usuarios::where('login', $request->login)->first()){
			$usuario = Usuarios::where('login', $request->login)->first();
			if($usuario->attempts < 3){
				Usuarios::where('login', $request->login)->increment('attempts');
				\Session::flash('login', array(
				'class' => 'danger',
				'mensagem' => 'A senha inserida não confere'
			));
			}else{
				Usuarios::where('login', $request->login)->update(['status' => 'Bloqueado']);
				\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário está bloqueado, contate o administrador.'
				));
			}
			return redirect()->route('login');
		}else{
			\Session::flash('login', array(
				'class' => 'danger',
				'mensagem' => 'Usuário não existente'
			));
			return redirect()->route('login');
		}	
	}
	// Tela de inicial
	public function Inicio(){
		if (Auth::check() && Auth::user()->status == "Ativo") {
			$base = Base::orderBy('created_at', 'DESC')->take(5)->get();
			return view('system.home')->with('base', $base);
		}else{
			return redirect(route('login'));
		}	
	}
    // Sair
	public function Sair(){
		Atividades::create([
			'nome' => 'Logout do sistema',
			'descricao' => 'Você saiu da plataforma.',
			'icone' => 'mdi-close',
			'url' => 'javascript:void(0)',
			'id_usuario' => Auth::id()
		]);
		Auth::logout();
		return redirect(route('login'));
	}
	// Configurações
	public function Configuracoes(){
		return view('configuracoes.geral');
	}
	// Primeiro acesso
	public function PrimeiroAcesso(){
		return view('system.new');
	}
	// Permissão de acesso
	public function Permission403(){
		return view('system.permission');
	}
    public function SalvarPrimeiroAcesso(Request $request){
		$dados = Usuarios::find(Auth::user()->id)->update([
            'password' => Hash::make($request->confirmpassword), 
            'remember_token' => Str::random(60),
            'email_verified_at' => date("Y-m-d H:i:s")    
        ]);
        Atividades::create([
			'nome' => 'Seu primero acesso',
			'descricao' => 'Você acessou a plataforma pela primeira vez.',
			'icone' => 'mdi-human-greeting',
			'url' => route('inicio'),
			'id_usuario' => Auth::id()
		]);
        return redirect(route('inicio'));
	}
	// Esquecimento de password
	public function Solicitar(Request $request){
		$user = Usuarios::where('login', $request->login)->first();
		if(!empty($user->login)){
			$user->notify(new Recuperacao($user));
			Atividades::create([
				'nome' => 'Solicitação de redefinição',
				'descricao' => 'Você solicitou a redefinição da sua senha pelo login.',
				'icone' => 'mdi-send',
				'url' => 'javascript:void(0)',
				'id_usuario' => $user->id
			]);
			return response()->json(['success' => true]);
		}else{
			return response()->json(['success' => false]);
		}
	}
	public function Verificar($token){
		$user = Usuarios::where('remember_token', $token)->first();
		if(!empty($user)){
			return view('system.trocar')->with('usuario', $user);
		}else{
			\Session::flash('login', array(
			'class' => 'danger',
			'mensagem' => 'Tente recuperar novamente.'
			));
			return redirect(route('login'));
		}
	}
	public function Trocar(Request $request){
		$user = Usuarios::find($request->id);
		$dados = Usuarios::find($user->id)->update([
			'password' => Hash::make($request->password), 
			'remember_token' => $request->_token
		]);
		Usuarios::find($user->id)->update(['attempts' => 0]);
		//$user->notify(new ResetPassword($user));
		\Session::flash('login', array(
			'class' => 'success',
			'mensagem' => 'Senha alterada com sucesso, faça o login.'
		));
		Atividades::create([
			'nome' => 'Redefinação de senha',
			'descricao' => 'Você efetuar a redefinição da sua senha.',
			'icone' => 'mdi-account-key',
			'url' => 'javascript:void(0)',
			'id_usuario' => $user->id
		]);
		return redirect(route('login'));
	}

	#-------------------------------------------------------------------
	# Gestão do perfil
	#-------------------------------------------------------------------
	// Perfil do usuário
	public function Perfil(){
		$usuario = Usuarios::find(Auth::id());
		return view('system.perfil')->with('usuario', $usuario);
	}
	public function SalvarPerfil(Request $request){
        if(!empty($request->upload_img)){
            $nameFile = null;
            if ($request->hasFile('upload_img') && $request->file('upload_img')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->upload_img->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->upload_img->storeAs('usuarios', $nameFile);

                $imagem = Imagens::create(['tipo' => 'perfil', 'endereco' => $upload]);
            	$imagemNova = Usuarios::find(Auth::id())->update(['id_imagem' => $imagem->id]);
            }  
        }
        // Alterando password
		if($request->password){
			$usuario = Usuarios::find(Auth::id())->update(['password' => Hash::make($request->password)]);
		}
		// Alterando e-mail e telefone
		$usuario = Usuarios::find(Auth::id())->update(['email' => $request->email, 'telefone' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $request->telefone)))]);
		Atividades::create([
			'nome' => 'Atualização do perfil',
			'descricao' => 'Você teve seu perfil atualizado.',
			'icone' => 'mdi-account-convert',
			'url' => route('perfil'),
			'id_usuario' => Auth::id()
		]);
		\Session::flash('alteracao', array(
				'class' => 'success',
				'mensagem' => 'Seus dados foram alterados com sucesso.'
			));
		return redirect(route('perfil'));
	}


	#-------------------------------------------------------------------
	# Atividades
	#-------------------------------------------------------------------
	public function Atividades(){
		$dados = Atividades::where('id_usuario', Auth::id())->orderBy('created_at', 'DESC')->paginate(10);
		return view('system.atividades')->with('dados', $dados);
	}

}
