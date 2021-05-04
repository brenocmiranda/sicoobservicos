<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Notifications\Recuperacao;
use App\Http\Requests\LoginRqt; 
use App\Models\Associados;
use App\Models\Atividades; 
use App\Models\Base; 
use App\Models\Unidades; 
use App\Models\Usuarios;
use App\Models\Homepage;
use App\Models\Imagens;
use PDF;

class PublicCtrl extends Controller
{
	// Tela de homepage
	public function Homepage(){
		$wallpapers = Imagens::where('tipo', 'homepage_principal')->get();
		$atalhos = Homepage::orderBy('titulo')->get();
		$aniversariantes = Associados::where('funcionario', 1)->whereDay('data_nascimento', date('d'))->whereMonth('data_nascimento', date('m'))->where('id', '<>', 1)->select('nome', 'data_nascimento')->orderByRaw('day(data_nascimento) asc')->get();
		return view('tecnologia.atalhos.exibir')->with('atalhos', $atalhos)->with('wallpapers', $wallpapers)->with('aniversariantes', $aniversariantes);
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

	#-------------------------------------------------------------------
	# Digitalização de arquivos
	#-------------------------------------------------------------------
	// Importação de documentos
	public function ExibirImportacao(){
		$usuarios = Usuarios::where('id', '<>', 1)->where('status', 'Ativo')->orderBy('login', 'ASC')->get();
		$homepage = Imagens::where('tipo', 'homepage_principal')->get();
		return view('public.digitalizar.exibir')->with('usuarios', $usuarios)->with('homepage', $homepage);
	}
	// Fazendo upload de arquivos
    public function ArquivoDigitalizar(Request $request){
        if ($request->hasFile('arquivos')) {
            foreach($request->file('arquivos') as $imagem){
                if($imagem->isValid()){
                    $name = 'Digitalizar_'.date('Y_m_d_H_i_s_').rand(1, 999);
                    $extension =  $imagem->extension();
                    $nameFile = "{$name}.{$extension}";
                    $upload =  $imagem->storeAs('digitalizar', $nameFile);
                }
                // Compactando a imagem
				$info = getimagesize(storage_path().'/app/digitalizar/'.$nameFile);
				if ($info['mime'] == 'image/jpeg') {
			        $image = imagecreatefromjpeg(storage_path().'/app/digitalizar/'.$nameFile);
				}elseif ($info['mime'] == 'image/gif') {
			        $image = imagecreatefromgif(storage_path().'/app/digitalizar/'.$nameFile);
				}elseif ($info['mime'] == 'image/png') {
			        $image = imagecreatefrompng(storage_path().'/app/digitalizar/'.$nameFile);
				}

				// Alterando filtros da imagem
				imagefilter($image, IMG_FILTER_BRIGHTNESS, 30);

				// Alterando a orientação da imagem
				$arq = storage_path().'/app/digitalizar/'.$nameFile;
				$exif = @exif_read_data($arq);
                if(!empty($exif['Orientation'])) {
	                switch($exif['Orientation']) {
	                case 8:
	                    $newimage = imagerotate($image,90,0);
	                    break;
	                case 3:
	                    $newimage = imagerotate($image,180,0);
	                    break;
	                case 6:
	                    $newimage = imagerotate($image,-90,0);
	                    break;
	                case 1:
	                   	$newimage = $image;
	                    break;
	                }
                }else{
                	//$newimage = imagerotate($image, -90,0);
                	$newimage = $image;
                }	
				// Gerando nova imagem
				imagejpeg($newimage, storage_path().'/app/digitalizar/'.$nameFile, 30);
				$urlImage = 'app/digitalizar/'.$nameFile;
				return $urlImage;
            }
        }
    }
    // Transformando imagens em pdf
	public function Upload(Request $request){
		// Documento de identificação
		if(isset($request->identificacao)){
			foreach($request->identificacao as $key => $arq){
				// HTML para criação do PDF
				$usuario = Usuarios::where('login', $request->usuario)->first();
				$html[] = preg_replace("/>s+</", "><", '<div><img src="'.asset('storage/'.$arq).'" style="max-width: 100%; max-height: 26cm;"><div style="font-size: 1px !important; text-align:right; color:white; width:100%; background-color: #292828; padding-right: 1px; padding-top: 0.5px; padding-bottom: 0.5px;">Confere com o original <br>'.$usuario->RelationAssociado->nome.'</div></div>');
			}
			// Gerando PDF
			if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
				if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
					$pdf = PDF::loadView('public.digitalizar.todos', compact('html'))->setPaper('a4', 'portrait')->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.'DOC.pdf');
				}else{
					mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
					$pdf = PDF::loadView('public.digitalizar.todos', compact('html'))->setPaper('a4', 'portrait')->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.'DOC.pdf');
				}
			}else{
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
				$pdf = PDF::loadView('public.digitalizar.todos', compact('html'))->setPaper('a4', 'portrait')->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.'DOC.pdf');
			}
		}

		// Documento CPF
		if(isset($request->cpf)){
			// HTML para criação do PDF
			$usuario = Usuarios::where('login', $request->usuario)->first();
			$html = '<div><img src="'.asset('storage/'.$request->cpf[0]).'" style="max-width: 100%; max-height: 27cm;"><div style="font-size: 1px !important; text-align:right; color:white; width:100%; background-color: #292828; padding-right: 1px; padding-top: 0.5px; padding-bottom: 0.5px;">Confere com o original <br> '.$usuario->RelationAssociado->nome.'</div></div>';
			$html = preg_replace("/>s+</", "><", $html);

			// Gerando PDF
			if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
				if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
					$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/CPF.pdf');
					
				}else{
					mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
					$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/CPF.pdf');
				}
			}else{
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
				$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/CPF.pdf');
			}
		}

		// Comprovante de renda
		if(isset($request->renda)){
			// HTML para criação do PDF
			$usuario = Usuarios::where('login', $request->usuario)->first();
			$html = '<div><img src="'.asset('storage/'.$request->renda[0]).'" style="max-width: 100%; max-height: 27cm;"><div style="font-size: 1px !important; text-align:right; color:white; width:100%; background-color: #292828; padding-right: 1px; padding-top: 0.5px; padding-bottom: 0.5px;">Confere com o original <br> '.$usuario->RelationAssociado->nome.'</div></div>';
			$html = preg_replace("/>s+</", "><", $html);

			// Gerando PDF
			if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
				if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
					$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/RENDA.pdf');
					
				}else{
					mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
					$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/RENDA.pdf');
				}
			}else{
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
				$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/RENDA.pdf');
			}
		}

		// Comprovante de residência
		if(isset($request->residencia)){
			// HTML para criação do PDF
			$usuario = Usuarios::where('login', $request->usuario)->first();
			$html = '<div><img src="'.asset('storage/'.$request->residencia[0]).'" style="max-width: 100%; max-height: 27cm;"><div style="font-size: 1px !important; text-align:right; color:white; width:100%; background-color: #292828; padding-right: 1px; padding-top: 0.5px; padding-bottom: 0.5px;">Confere com o original <br> '.$usuario->RelationAssociado->nome.'</div></div>';
			$html = preg_replace("/>s+</", "><", $html);

			// Gerando PDF
			if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
				if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
					$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/ENDEREÇO.pdf');
					
				}else{
					mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
					$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/ENDEREÇO.pdf');
				}
			}else{
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
				$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/ENDEREÇO.pdf');
			}
		}

		// Cartão de assinatura
		if(isset($request->assinatura)){
			if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
				if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
					$file = asset('storage/'.$request->assinatura[0]);
					$newfile = "//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/CARTAO DE ASSINATURA.jpg';
					copy($file, $newfile);
					
				}else{
					mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
					$file = asset('storage/'.$request->assinatura[0]);
					$newfile = "//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/CARTAO DE ASSINATURA.jpg';
					copy($file, $newfile);
				}
			}else{
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
				mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
				$file = asset('storage/'.$request->assinatura[0]);
				$newfile = "//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/CARTAO DE ASSINATURA.jpg';
				copy($file, $newfile);
			}
		}

		// Outros arquivos
		if (isset($request->outros)) {
			if($request->pagina == 1){
		        foreach($request->outros as $key => $arq){
					// Criando nome do arquivo do PDF
					if($request->nomeArquivos[$key]){
						if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$request->nomeArquivos[$key].'.pdf')){
							$namePdf = strtoupper($request->nomeArquivos[$key]).'.pdf';
						}else{
							$namePdf = strtoupper($request->nomeArquivos[$key]).date('His').'.pdf';
						}
					}else{
						$namePdf = str_replace('.'.$arq->getClientOriginalExtension(), '', $request->outros[$key]).'.pdf';
					}
					
					// HTML para criação do PDF
					$usuario = Usuarios::where('login', $request->usuario)->first();
					$html = '<div><img src="'.asset('storage/'.$request->outros[$key]).'" style="max-width: 100%; max-height: 26cm;"><div style="font-size: 1.5px !important; text-align:right; color:white; width:100%; background-color: #292828; padding-right: 1px; padding-top: 0.5px; padding-bottom: 0.5px;">Confere com o original <br> '.$usuario->RelationAssociado->nome.'</div></div>';
					$html = preg_replace("/>s+</", "><", $html);

					// Gerando PDF
					if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
						if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
						}else{
							mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
						}
				    }else{
				    	mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
				    	if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
						}else{
							mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
							$pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
						}
				    }
	            }
            }elseif($request->pagina == 2){
            	foreach($request->arquivos as $key => $arq){
					// Criando nome do arquivo do PDF
					$namePdf = str_replace('.'.$arq->getClientOriginalExtension(), '', $request->outros[$key]).'.pdf';
					// Gerando PDF
					$usuario = Usuarios::where('login', $request->usuario)->first();
					$html[] = preg_replace("/>s+</", "><", '<div style="page-break-after: always;"><img src="'.asset('storage/'.$request->outros[$key]).'" style="max-width: 100%; max-height: 27cm;"><div style="font-size: 1.5px !important; text-align:right; color:white; width:100%; background-color: #292828; padding-right: 1px; padding-top: 0.5px; padding-bottom: 0.5px;">Confere com o original <br>'.$usuario->RelationAssociado->nome.'</div></div>');
				}
				// Gerando PDF 
				if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
					if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
						$pdf = PDF::loadView('public.digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
					}else{
						mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
						$pdf = PDF::loadView('public.digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
					}
			    }else{
			        mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
			       	if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta))){
						$pdf = PDF::loadView('public.digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
					}else{
						mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta), 0755);
						$pdf = PDF::loadView('public.digitalizar.todos', compact('html'))->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.strtoupper($request->nomePasta).'/'.$namePdf);
					}
			    }
           	 }
        }

        if(isset($request->identificacao) || isset($request->cpf) || isset($request->renda) || isset($request->residencia) || isset($request->assinatura) || isset($request->arquivos) || isset($request->outros)) {
			\Session::flash('confirm', array(
				'class' => 'success',
				'mensagem' => 'Seu arquivos foram enviados com sucesso.'
			));
		}else{
			\Session::flash('confirm', array(
				'class' => 'danger',
				'mensagem' => 'Não existe arquivos para ser importados.'
			));
		}
		return redirect()->route('digitalizar');
	}

	#-------------------------------------------------------------------
	# Telefones internos
	#-------------------------------------------------------------------
	public function ExibirTelefones(){
		$unidades = Unidades::where('status', 1)->whereNotNull('cep')->get();
		$usuariosRamal = Usuarios::where('id', '<>', 1)->where('status', 'Ativo')->whereNotNull('telefone_ramal')->get();
		$usuariosCorporativo = Usuarios::where('id', '<>', 1)->where('status', 'Ativo')->whereNotNull('telefone_corporativo')->get();
		$homepage = Imagens::where('tipo', 'homepage_principal')->get();
		return view('public.telefones.exibir')->with('unidades', $unidades)->with('usuariosRamal', $usuariosRamal)->with('usuariosCorporativo', $usuariosCorporativo)->with('homepage', $homepage);
	}
}
