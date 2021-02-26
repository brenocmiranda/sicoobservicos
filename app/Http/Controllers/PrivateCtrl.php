<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Base; 
use App\Models\Usuarios;
use App\Models\Imagens;

class PrivateCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
	
	// Tela de inicial
	public function Inicio(){
		if (Auth::check() && Auth::user()->status == "Ativo") {
			$base = Base::orderBy('created_at', 'DESC')->where('tipo', 'externo')->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-15 days')))->orWhere('updated_at', '>=', date('Y-m-d H:i:s', strtotime('-15 days')))->take(5)->get();
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
	// Minhas atividades
	public function Atividades(){
		$dados = Atividades::where('id_usuario', Auth::id())->orderBy('created_at', 'DESC')->paginate(10);
		return view('system.atividades')->with('dados', $dados);
	}
	// Permissão de acesso
	public function Permission403(){
		return view('system.permission');
	}
	// Primeiro acesso
	public function PrimeiroAcesso(){
		return view('system.new');
	}
	// Salvando o primeiro acesso
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
	// Perfil do usuário
	public function Perfil(){
		$usuario = Usuarios::find(Auth::id());
		return view('system.perfil')->with('usuario', $usuario);
	}
	// Salvando alteração de perfil
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
	// Controle de inatividade
	public function CheckUser(){
		if(request()->segment(1) == 'app' && request()->segment(2) != 'login' && request()->segment(2) != 'password'){
			if (!(Auth::check()) || (Auth::user()->status != "Ativo")) {
				return response()->json(['success' => true]);
			}else{
				return response()->json(['success' => false]);
			}
		}
	}

}
