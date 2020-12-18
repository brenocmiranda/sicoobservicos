<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Notifications\Recuperacao;
use App\Http\Requests\LoginRqt; 
use App\Models\Atividades; 
use App\Models\Base; 
use App\Models\Usuarios;
use App\Models\Homepage;
use App\Models\Imagens;
use PDF;

class PublicCtrl extends Controller
{
	// Tela de homepage
	public function Homepage(){
		$homepage = Imagens::where('tipo', 'homepage_principal')->get();
		$dados = Homepage::orderBy('titulo')->get();
		return view('tecnologia.homepage.exibir')->with('homepages', $dados)->with('homepage', $homepage);
	}
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
		Auth::logoutOtherDevices($request->password);
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
	// Verificação do token para recuperação
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
	// Alterando password por solicitação
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

	// Importação de documentos
	public function ExibirImportacao(){
		$usuarios = Usuarios::where('status', 'Ativo')->orderBy('login', 'ASC')->get();
		$homepage = Imagens::where('tipo', 'homepage_principal')->get();
		return view('digitalizar.exibir')->with('usuarios', $usuarios)->with('homepage', $homepage);
	}
	public function Importar(Request $request){
		if ($request->arquivos) {
			if($request->pagina == 1){
		        foreach($request->arquivos as $key => $arq){
		        	// Copia arquivo para servidor com a nomeclatura
	            	$nameFile = 'Digitalizar_'.date('Y_m_d_H_i_s_').$key.'.'.$arq->getClientOriginalExtension();
					$upload = $arq->storeAs('digitalizar', $nameFile);

					// Compactando a imagem
					$info = getimagesize(storage_path().'/app/digitalizar/'.$nameFile);
					if ($info['mime'] == 'image/jpeg') {
				        $image = imagecreatefromjpeg(storage_path().'/app/digitalizar/'.$nameFile);
					}elseif ($info['mime'] == 'image/gif') {
				        $image = imagecreatefromgif(storage_path().'/app/digitalizar/'.$nameFile);
					}elseif ($info['mime'] == 'image/png') {
				        $image = imagecreatefrompng(storage_path().'/app/digitalizar/'.$nameFile);
					}
					imagejpeg($image, storage_path().'/app/digitalizar/'.$nameFile, 70);

					// Criando nome do arquivo do PDF
					$namePdf = str_replace('.'.$arq->getClientOriginalExtension(), '', $nameFile).'.pdf';
					// HTML para criação do PDF
					$html = '<img src='.storage_path().'/app/digitalizar/'.$nameFile.' style="width:100%">';
					// Gerando PDF

					if(is_dir("//10.11.26.1/digitalizar_ss$/".$request->usuario)){
						if(is_dir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta)){
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
						}else{
							mkdir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta, 0755);
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
						}
				    }else{
				    	mkdir("//10.11.26.1/digitalizar_ss$/".$request->usuario, 0755);
				    	if(is_dir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta)){
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
						}else{
							mkdir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta, 0755);
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
						}
				    }
	            }
            }elseif($request->pagina == 2){
            	foreach($request->arquivos as $key => $arq){
		        	// Copia arquivo para servidor com a nomeclatura
	            	$nameFile = 'Digitalizar_'.date('Y_m_d_H_i_s_').$key.'.'.$arq->getClientOriginalExtension();
					$upload = $arq->storeAs('digitalizar', $nameFile);

					// Compactando a imagem
					$info = getimagesize(storage_path().'/app/digitalizar/'.$nameFile);
					if ($info['mime'] == 'image/jpeg') {
				        $image = imagecreatefromjpeg(storage_path().'/app/digitalizar/'.$nameFile);
					}elseif ($info['mime'] == 'image/gif') {
				        $image = imagecreatefromgif(storage_path().'/app/digitalizar/'.$nameFile);
					}elseif ($info['mime'] == 'image/png') {
				        $image = imagecreatefrompng(storage_path().'/app/digitalizar/'.$nameFile);
					}

					// Criando nome do arquivo do PDF
					$namePdf = str_replace('.'.$arq->getClientOriginalExtension(), '', $nameFile).'.pdf';
					// Gerando PDF
					$html[] = "<img src=".storage_path().'/app/digitalizar/'.$nameFile." style='width:100%'><div style='page-break-after: always;'></div>";
				}
				// Gerando PDF
				if(is_dir("//10.11.26.1/digitalizar_ss$/".$request->usuario)){
					if(is_dir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta)){
						$pdf = PDF::loadView('digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
					}else{
						mkdir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta, 0755);
						$pdf = PDF::loadView('digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
					}
			    }else{
			        mkdir("//10.11.26.1/digitalizar_ss$/".$request->usuario, 0755);
			       	if(is_dir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta)){
						$pdf = PDF::loadView('digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
					}else{
						mkdir("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta, 0755);
						$pdf = PDF::loadView('digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->save("//10.11.26.1/digitalizar_ss$/".$request->usuario.'/'.$request->nomePasta.'/'.$namePdf);
					}
			    }
           	 }
        }
		\Session::flash('confirm', array(
			'class' => 'success',
			'mensagem' => 'Seu arquivos foram enviados com sucesso.'
		));
		return redirect()->route('digitalizar');
	}
}
