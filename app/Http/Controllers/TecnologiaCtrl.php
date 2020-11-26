<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Notifications\SolicitacaoChamadosCliente;
use App\Http\Requests\AtivoRqt; 
use App\Http\Requests\BaseRqt;
use App\Http\Requests\FontesRqt;
use App\Http\Requests\TiposRqt;
use App\Http\Requests\StatusRqt;
use App\Http\Requests\HomepageRqt;
use App\Models\Ativos;
use App\Models\AtivosImagens;
use App\Models\AtivosUsuarios;
use App\Models\Atividades;
use App\Models\Chamados;
use App\Models\ChamadosStatus;
use App\Models\Status;
use App\Models\Base;
use App\Models\BaseArquivos; 
use App\Models\Fontes;
use App\Models\Tipos;
use App\Models\Arquivos; 
use App\Models\Homepage;
use App\Models\Imagens;
use App\Models\Usuarios;
use App\Models\Setores;
use App\Models\Unidades;
use App\Models\CogEmailsChamado;
use PDF;

class TecnologiaCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Dashboard 
	#-------------------------------------------------------------------
	public function Dashboard(){
		$homepage = Homepage::all();
		$chamados = Chamados::all();
		$chamadosEmaberto = 0;
		$chamadosEmandamento = 0;
		$chamadosEncerrado = 0;
		foreach ($chamados as $value) {
			if($value->RelationStatus->first()->pivot->gti_id_status == 1){
				$chamadosEmaberto++;
			}elseif ($value->RelationStatus->first()->pivot->gti_id_status == 2) {
				$chamadosEmandamento++;
			}elseif ($value->RelationStatus->first()->pivot->gti_id_status == 3) {
				$chamadosEncerrado++;
			}
		}
		$chamadosTipos = Chamados::join('gti_tipos', 'gti_id_tipos', 'gti_tipos.id')->select('gti_id_tipos', 'gti_tipos.nome', \DB::raw('count(gti_id_tipos) as quantidade'))->groupBy('gti_id_tipos')->get();
		$chamadosFontes = Chamados::join('gti_fontes', 'gti_id_fontes', 'gti_fontes.id')->select('gti_id_fontes', 'gti_fontes.nome', \DB::raw('count(gti_id_fontes) as quantidade'))->groupBy('gti_id_fontes')->get();
		$chamadosUsuarios = Chamados::join('gti_fontes', 'gti_id_fontes', 'gti_fontes.id')->select('gti_id_fontes', 'gti_fontes.nome', \DB::raw('count(gti_id_fontes) as quantidade'))->groupBy('gti_id_fontes')->get();
		$chamadosDia = Chamados::select(\DB::raw('DATE(created_at) as data'), \DB::raw('count(created_at) as quantidade'))->groupBy(\DB::raw('DATE(created_at)'))->get();
		$chamadosUsuarios = Chamados::groupBy('usr_id_usuarios')->select('usr_id_usuarios', \DB::raw('count(usr_id_usuarios) as quantidade'))->get();
		$equipamentosSetor = Ativos::join('usr_setores', 'id_setor', 'usr_setores.id')->select('id_setor', 'usr_setores.nome', \DB::raw('count(id_setor) as quantidade'))->groupBy('id_setor')->get();
		$equipamentosPA = Ativos::join('usr_unidades', 'id_unidade', 'usr_unidades.id')->select('id_unidade', 'usr_unidades.nome', \DB::raw('count(id_unidade) as quantidade'))->groupBy('id_unidade')->get();
		$equipamentosUsuarios = AtivosUsuarios::groupBy('usr_id_usuarios')->whereNotNull('dataDevolucao')->select('usr_id_usuarios', \DB::raw('count(usr_id_usuarios) as quantidade'))->get();
		$equipamentosMarca = Ativos::groupBy('marca')->select('marca', \DB::raw('count(marca) as quantidade'))->get();

		return view('tecnologia.dashboard')->with('homepage', $homepage)->with('chamados', $chamados)->with('chamadosEmaberto', $chamadosEmaberto) ->with('chamadosEmandamento', $chamadosEmandamento) ->with('chamadosEncerrado', $chamadosEncerrado) ->with('chamadosTipos', $chamadosTipos) ->with('chamadosFontes', $chamadosFontes) ->with('chamadosDia', $chamadosDia) ->with('chamadosUsuarios', $chamadosUsuarios) ->with('equipamentosSetor', $equipamentosSetor) ->with('equipamentosPA', $equipamentosPA) ->with('equipamentosMarca', $equipamentosMarca) ->with('equipamentosUsuarios', $equipamentosUsuarios); 
	}

	#-------------------------------------------------------------------
	# Chamados 
	#-------------------------------------------------------------------
	// Exibir todos chamados
    public function ExibirChamados(){
        if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
            $chamados = Chamados::orderBy('created_at', 'ASC')->get();
            $status = Status::where('status', 1)->get();
            return view('tecnologia.chamados.listar')->with('chamados', $chamados)->with('statusAtivos', $status);
        }else{
            return redirect(route('403'));
        }
    }
    // Detalhes do chamado
    public function DetalhesChamados($id){
        if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
            $chamado = Chamados::find($id);
            $historicoStatus = ChamadosStatus::where('gti_id_chamados', $id)->orderBy('created_at', 'DESC')->get();
            $status = Status::where('status', 1)->get();
            return view('tecnologia.chamados.detalhes')->with('chamado', $chamado)->with('statusAtivos', $status)->with('historicoStatus', $historicoStatus);
        }else{
            return redirect(route('403'));
        }
    }
    // Finalizando chamado
    public function FinalizaChamados(Request $request, $id){
        if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
            $finalizar = Status::where('finish', 1)->first();
            $status = ChamadosStatus::create([
                'gti_id_chamados' => $id,
                'gti_id_status' => $finalizar->id,
                'descricao' => (isset($request->descricao) ? $request->descricao : "Chamado finalizado por ".Auth::user()->RelationAssociado->nome."."),
                'usr_id_usuarios' => Auth::id()
            ]);
            $create = Chamados::find($id);
            $create->RelationUsuario->notify(new SolicitacaoChamadosCliente($create));
            Atividades::create([
                'nome' => 'Encerramento de chamado',
                'descricao' => 'Você efetuou o encerramento do chamado, '.$create->assunto.'.',
                'icone' => 'mdi-headset-off',
                'url' => route('detalhes.chamados.gti', $id),
                'id_usuario' => Auth::id()
            ]);
            return response()->json(['success' => true]);
        }else{
            return redirect(route('403'));
        }
    }
    // Relatório do chamado
    public function RelatorioChamados($id){
        $dados = Chamados::find($id);
        $historicoStatus = ChamadosStatus::where('gti_id_chamados', $id)->orderBy('created_at', 'DESC')->get();
        Atividades::create([
            'nome' => 'Emissão de relatório do chamado',
            'descricao' => 'Você efetuou a emissão do relatório do chamado, '.$dados->assunto.'.',
            'icone' => 'mdi-file-document',
            'url' => route('detalhes.chamados.gti', $id),
            'id_usuario' => Auth::id()
        ]);
        return view('tecnologia.chamados.relatorio')->with('chamado', $dados)->with('historicoStatus', $historicoStatus);
    }
    // Atualizando status
    public function StatusChamados(Request $request, $id){
        if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
            $chamado = Chamados::find($id);
            $status = ChamadosStatus::create([
                'gti_id_chamados' => $id,
                'gti_id_status' => $request->status,
                'descricao' => (isset($request->descricao) ? $request->descricao : "Estado do chamado alterado por ".Auth::user()->RelationAssociado->nome."."),
                'usr_id_usuarios' => Auth::id()
            ]);
            $chamado->RelationUsuario->notify(new SolicitacaoChamadosCliente($chamado));  
            Atividades::create([
                'nome' => 'Alteração de estado do chamado',
                'descricao' => 'Você modificou o status do chamado, '.$chamado->assunto.'.',
                'icone' => 'mdi-file-document',
                'url' => route('detalhes.chamados.gti', $id),
                'id_usuario' => Auth::id()
            ]);
            return response()->json(['success' => true]);
        }else{
            return redirect(route('403'));
        }
    }
    // Dados dos status
    public function InfoChamados($id){
        $dados = ChamadosStatus::find($id);
        return $dados;
    }
    // Alterando descrição dos status
    public function DescricaoChamados(Request $request){
        if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
            ChamadosStatus::find($request->id)->update(['descricao' => $request->descricao]);
            return $request;
        }else{
            return redirect(route('403'));
        }
    }
    // Removendo status
    public function RemoveChamados($id){
        if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
            $status = ChamadosStatus::find($id);
            Atividades::create([
                'nome' => 'Remoção de status do chamado',
                'descricao' => 'Você remove um status do chamado, '.$status->RelationStatus->assunto.'.',
                'icone' => 'mdi-delete-forever',
                'url' => route('detalhes.chamados.gti', $status->gti_id_chamados),
                'id_usuario' => Auth::id()
            ]);
            ChamadosStatus::find($id)->delete();
            return response()->json(['success' => true]);
        }else{
            return redirect(route('403'));
        }
    }
    // Monitorando atualizações no status
    public function MonitorarChamados($id_chamado, $id_status){
        $novo = ChamadosStatus::where('gti_id_chamados', $id_chamado)->where('id', '>', $id_status)->get();
        return $novo;
    }


	#-------------------------------------------------------------------
	# Configurações (Aprendizagem)
	#-------------------------------------------------------------------
	// Listando todos tópicos
	public function ExibirAprendizagem(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$topicos = Base::all();
			return view('tecnologia.configuracoes.aprendizagem.exibir')->with('topicos', $topicos);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando novos tópicos
	public function AdicionarAprendizagem(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$fontes = Fontes::where('status', 1)->orderBy('nome', 'ASC')->get();
			$tipos = Tipos::where('status', 1)->orderBy('nome', 'ASC')->get();
			return view('tecnologia.configuracoes.aprendizagem.adicionar')->with('fontes', $fontes)->with('tipos', $tipos);
		}else{
			return redirect(route('403'));
		}
	}
	public function AdicionarSalvarAprendizagem(BaseRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Base::create([
				'titulo' => $request->titulo,
				'subtitulo' => $request->subtitulo, 
				'descricao' => $request->descricao, 
				'gti_id_fontes' => $request->gti_id_fontes,
				'gti_id_tipos' => $request->gti_id_tipos,
			]);
			// Cadastramento de vários arquivos 
	        if ($request->arquivos) {
	            foreach($request->arquivos as $arq){
	                $imagem_produto = BaseArquivos::create([
	                    'gti_id_topico' => $create->id,
	                    'id_arquivo' => $arq                    
	                ]);
	            }
	        }
			Atividades::create([
				'nome' => 'Cadastro de novo tópico',
				'descricao' => 'Você cadastrou um novo tópico, '.$create->titulo.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.base.aprendizagem'),
				'id_usuario' => Auth::id()
			]);
			return redirect()->route('exibir.base');
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações
	public function EditarAprendizagem($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$base = Base::find($id);
			$fontes = Fontes::where('status', 1)->orderBy('nome', 'ASC')->get();
			$tipos = Tipos::where('status', 1)->where('gti_id_fontes', $base->gti_id_fontes)->orderBy('nome', 'ASC')->get();
			return view('tecnologia.configuracoes.aprendizagem.editar')->with('base', $base)->with('fontes', $fontes)->with('tipos', $tipos);
		}else{
			return redirect(route('403'));
		}
	}
	public function EditarSalvarAprendizagem(BaseRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Base::find($id)->update([
				'titulo' => $request->titulo,
				'subtitulo' => $request->subtitulo, 
				'descricao' => $request->descricao, 
				'gti_id_fontes' => $request->gti_id_fontes,
				'gti_id_tipos' => $request->gti_id_tipos,  
			]);
			// Cadastramento de vários arquivos 
	        if ($request->arquivos){
	        	BaseArquivos::where('gti_id_topico', $id)->delete();
	            foreach($request->arquivos as $arq){
	                $imagem_produto = BaseArquivos::create([
	                    'gti_id_topico' => $id,
	                    'id_arquivo' => $arq                    
	                ]);
	            }
	        }
			$create = Base::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do tópico '.$create->titulo.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.base.aprendizagem'),
				'id_usuario' => Auth::id()
			]);
			return redirect()->route('exibir.base');
		}else{
			return redirect(route('403'));
		}
	}
	// Deletando o tópico
	public function DeleteAprendizagem($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Base::find($id);
			Atividades::create([
				'nome' => 'Remoção de ativo',
				'descricao' => 'Você acabou de remover o ativo '.$create->titulo.'.',
				'icone' => 'mdi-delete-forever',
				'url' => route('exibir.base.aprendizagem'),
				'id_usuario' => Auth::id()
			]);
			BaseArquivos::where('gti_id_topico', $id)->delete();
			Base::find($id)->delete();
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do tópico
	public function DetalhesAprendizagem($id){
		$dados = Base::find($id);
		$topicos = Base::where('gti_id_fontes', $dados->gti_id_fontes)->where('gti_id_tipos', $dados->gti_id_tipos)->where('id', '<>', $dados->id)->limit(5)->get();
		return view('suporte.base.detalhes')->with('dados', $dados)->with('topicos', $topicos);
	}
	// Importando arquivos de anexo
    public function ArquivosAprendizagem(Request $request){
        // Cadastramento de várias imagens do mesmo produto
        if ($request->hasFile('arquivos')) {
            foreach($request->file('arquivos') as $imagem){
                if($imagem->isValid()){
                    $string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($imagem->extension(), '', $imagem->getClientOriginalName()));
					$name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
                    $extension =  $imagem->extension();
                    $nameFile = "{$name}.{$extension}";
                    $upload =  $imagem->storeAs('base', $nameFile);
                }
                $arquivos[] = Arquivos::create(['endereco' => $upload, 'tipo' => 'base']);
            }
        }
        return response()->json($arquivos);
    }
    // Removendo arquivos de anexo
    public function RemoveArquivosAprendizagem($id){
        $arquivo = Arquivos::find($id);
        unlink(getcwd().'/storage/app/'.$arquivo->endereco);
        BaseArquivos::where('id_arquivo', $id)->delete();
        Arquivos::find($id)->delete();
        return response()->json(['success' => true]);
    }


    #-------------------------------------------------------------------
	# Configurações (Fontes)
	#-------------------------------------------------------------------
    // Listando todos os fontes
	public function ExibirFontes(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return view('tecnologia.configuracoes.chamados.fontes.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesFontes(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return datatables()->of(Fontes::all())
	            ->editColumn('nome1', function(Fontes $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Fontes $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Fontes $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a fonte"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a fonte"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }else{
        	return datatables()->of(Fontes::all())
	            ->editColumn('nome1', function(Fontes $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Fontes $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Fontes $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }
	}
	// Adicionando nova fontes
	public function AdicionarFontes(FontesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Fontes::create([
				'nome' => $request->nome, 
				'descricao' => $request->descricao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova fonte de aprendizagem',
				'descricao' => 'Você cadastrou um nova fonte de aprendizagem, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.fontes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações da fontes
	public function EditarFontes(FontesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Fontes::find($id)->update([
				'nome' => $request->nome, 
				'descricao' => $request->descricao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Fontes::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da fonte de aprendizagem '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.fontes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarFontes($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$fontes = Fontes::find($id);
			if($fontes->status == 1){
				Fontes::find($id)->update(['status' => 0]);
			}else{
				Fontes::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da fonte de aprendizagem '.$fontes->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.fontes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes da fontes
	public function DetalhesFontes($id){
		$dados = Fontes::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Configurações (Tipos)
	#-------------------------------------------------------------------
	// Listando todos os tipos
	public function ExibirTipos(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$dados = Fontes::where('status', 1)->get();
			return view('tecnologia.configuracoes.chamados.tipos.listar')->with('fontes', $dados);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesTipos(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return datatables()->of(Tipos::all())
	            ->editColumn('nome1', function(Tipos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Tipos $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('fonte', function(Tipos $dados){
	                return $dados->RelationTipos->nome;
	            })
	            ->editColumn('acoes', function(Tipos $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'status1', 'fonte', 'acoes'])->make(true);
	    }else{
	    	return datatables()->of(Tipos::all())
	            ->editColumn('nome1', function(Tipos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Tipos $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('fonte', function(Tipos $dados){
	                return $dados->RelationTipos->nome;
	            })
	            ->editColumn('acoes', function(Tipos $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'fonte', 'acoes'])->make(true);
	    }
	}
	// Adicionando novo tipo
	public function AdicionarTipos(TiposRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Tipos::create([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'gti_id_fontes' => $request->gti_id_fontes,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo tipo de chamado',
				'descricao' => 'Você cadastrou um novo tipo de chamado, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.tipos.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações dos tipos
	public function EditarTipos(TiposRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Tipos::find($id)->update([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'gti_id_fontes' => $request->gti_id_fontes,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Tipos::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do tipo de chamado '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.tipos.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarTipos($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$tipos = Tipos::find($id);
			if($tipos->status == 1){
				Tipos::find($id)->update(['status' => 0]);
			}else{
				Tipos::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status do tipo de chamado '.$tipos->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.tipos.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do tipo
	public function DetalhesTipos($id){
		$dados = Tipos::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Configurações (Status)
	#-------------------------------------------------------------------
	 // Listando todos os status
	public function ExibirStatus(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return view('tecnologia.configuracoes.chamados.status.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesStatus(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return datatables()->of(Status::all())
				->editColumn('color1', function(Status $dados){ 
	                return '<div class="mx-auto rounded" style="height: 38px;width: 37px; background:'.$dados->color.'""></div>';
	            })
	            ->editColumn('nome1', function(Status $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('tempo1', function(Status $dados){
	                return substr($dados->tempo, 0, 5);
	            })
	            ->editColumn('status1', function(Status $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Status $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['color1', 'nome1', 'status1', 'acoes'])->make(true);
	    }else{
	    	return datatables()->of(Status::all())
				->editColumn('color1', function(Status $dados){ 
	                return '<div class="mx-auto rounded" style="height: 38px;width: 37px; background:'.$dados->color.'""></div>';
	            })
	            ->editColumn('nome1', function(Status $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('tempo1', function(Status $dados){
	                return substr($dados->tempo, 0, 5);
	            })
	            ->editColumn('status1', function(Status $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Status $dados){ 
	                return '';
	            })->rawColumns(['color1', 'nome1', 'status1', 'acoes'])->make(true);
	    }
	}
	// Adicionando novo status
	public function AdicionarStatus(StatusRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			/*
			if($request->open == "on"){
				Status::update(['open' => 0]);
			}
			if($request->finish == "on"){
				Status::update(['finish' => 0]);
			}*/
			$create = Status::create([
				'nome' => $request->nome, 
				'tempo' => $request->tempo,
				'color' => $request->color,
				'open' => ($request->open == "on" ? 1 : 0),
				'finish' => ($request->finish == "on" ? 1 : 0),
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo status de chamado',
				'descricao' => 'Você cadastrou um novo status de chamado, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.status.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do status
	public function EditarStatus(StatusRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			/*
			if($request->open == "on"){
				Status::update('open', 0);
			}
			if($request->finish == "on"){
				Status::update('finish', 0);
			}*/		
			Status::find($id)->update([
				'nome' => $request->nome, 
				'tempo' => $request->tempo,
				'color' => $request->color,
				'open' => ($request->open == "on" ? 1 : 0),
				'finish' => ($request->finish == "on" ? 1 : 0),
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Status::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do status de chamado '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.status.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarStatus($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$status = Status::find($id);
			if($status->status == 1){
				Status::find($id)->update(['status' => 0]);
			}else{
				Status::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status do status de chamado '.$status->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.status.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do status
	public function DetalhesStatus($id){
		$dados = Status::find($id);
		return $dados;
	}

	#-------------------------------------------------------------------
	# Homepage
	#-------------------------------------------------------------------
	// Listando todos os atalhos
	public function ExibirHomepage(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$dados = Homepage::orderBy('titulo')->get();
			return view('tecnologia.homepage.listar')->with('homepages', $dados);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando novo atalho
	public function AdicionarHomepage(HomepageRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			if(!empty($request->upload_img)){
	            $nameFile = null;
	            if ($request->hasFile('upload_img') && $request->file('upload_img')->isValid()) {
	                $name = uniqid(date('HisYmd'));
	                $extension =  $request->upload_img->extension();
	                $nameFile = "{$name}.{$extension}";
	                $upload =  $request->upload_img->storeAs('homepage', $nameFile);
	                $imagem = Imagens::create(['tipo' => 'homepage', 'endereco' => $upload]);
	            }
	        }else{
	        	if(is_dir(getcwd().'/storage/app/homepage')){
	                $nameFile = uniqid(date('HisYmd')).'.png';
	                copy(getcwd().'/public/img/padrao.png', getcwd().'/storage/app/homepage/'.$nameFile);
	                $caminho = 'homepage/'.$nameFile;
	                $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'homepage']);
	            }else{
	                mkdir(getcwd().'/storage/app/homepage', 0755);
	                $nameFile = uniqid(date('HisYmd')).'.png';
	                copy(getcwd().'/public/img/padrao.png', getcwd().'/storage/app/homepage/'.$nameFile);
	                $caminho = 'homepage/'.$nameFile;
	                $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'homepage']);
	            } 
	        }
			$create = Homepage::create([
				'titulo' => $request->titulo,
				'subtitulo' => $request->subtitulo,
				'endereco' => $request->endereco, 
				'id_imagem' => $imagem->id,
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo atalho',
				'descricao' => 'Você cadastrou um novo atalho da homepage, '.$create->titulo.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.homepage'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do atalho
	public function EditarHomepage(HomepageRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			if(!empty($request->upload_img)){
	            $nameFile = null;
	            if ($request->hasFile('upload_img') && $request->file('upload_img')->isValid()) {
	                $name = uniqid(date('HisYmd'));
	                $extension =  $request->upload_img->extension();
	                $nameFile = "{$name}.{$extension}";
	                $upload =  $request->upload_img->storeAs('homepage', $nameFile);
	                $imagem = Imagens::create(['tipo' => 'homepage', 'endereco' => $upload]);
	            }  
	        }
	        $dados = Homepage::find($id);
			Homepage::find($id)->update([
				'titulo' => $request->titulo,
				'subtitulo' => $request->subtitulo,
				'endereco' => $request->endereco, 
				'id_imagem' => (isset($imagem->id) ? $imagem->id : $dados->id_imagem),
			]);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do atalho '.$dados->titulo.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.homepage'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function DeleteHomepage($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Homepage::find($id);
			Atividades::create([
				'nome' => 'Remoção de atalho',
				'descricao' => 'Você acabou de remover o atalho da homepage '.$create->titulo.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.homepage'),
				'id_usuario' => Auth::id()
			]);
			Homepage::find($id)->delete();
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do atalho
	public function DetalhesHomepage($id){
		$dados = Homepage::find($id);
		$dados->image = $dados->RelationImagem->endereco;
		return $dados;
	}

	#-------------------------------------------------------------------
	# Inventário
	#-------------------------------------------------------------------
	// Listando todos os equipamentos
	public function ExibirInventario(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$equipamentos = Ativos::all();
			return view('tecnologia.equipamentos.listar')->with('ativos', $equipamentos);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesInventario(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return datatables()->of(Ativos::all())
				->editColumn('imagem1', function(Ativos $dados){ 
	                return '<img src="'.asset('storage/app/'.$dados->RelationImagemPrincipal->endereco).'" height="50" class="rounded">';
	            })
	            ->editColumn('setor', function(Ativos $dados){ 
	                return $dados->RelationSetor->nome;
	            })
	            ->editColumn('usuario', function(Ativos $dados){ 
	                return $dados->RelationUsuario->last()->RelationAssociado->nome;
	            })
	            ->editColumn('nome1', function(Ativos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'<br><small>'.$dados->marca.' <b>&#183</b> '.$dados->modelo.'</small></a>';
	            })
	            ->editColumn('acoes', function(Ativos $dados){ 
	                return '
	                <a href="'.route('editar.equipamentos', $dados->id).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do equipamento"><i class="mx-0 mdi mdi-settings"></i></a>
						<button class="btn btn-dark btn-xs btn-rounded" id="remover" title="Remover o equipamento"><i class="mx-0 mdi mdi-close"></i></button>';
	            })->rawColumns(['imagem1', 'nome1', 'acoes'])->make(true);
	        }else{
				return datatables()->of(Ativos::all())
					->editColumn('imagem1', function(Ativos $dados){ 
		                return '<img src="'.asset('storage/app/'.$dados->RelationImagemPrincipal->endereco).'" height="50" class="rounded">';
		            })
		            ->editColumn('setor', function(Ativos $dados){ 
		                return $dados->RelationSetor->nome;
		            })
		            ->editColumn('usuario', function(Ativos $dados){ 
		                return $dados->RelationUsuario->last()->RelationAssociado->nome;
		            })
		            ->editColumn('nome1', function(Ativos $dados){ 
		                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'<br><small>'.$dados->marca.' <b>&#183</b> '.$dados->modelo.'</small></a>';
		            })
		            ->editColumn('acoes', function(Ativos $dados){ 
		                return '';
		            })->rawColumns(['imagem1', 'nome1', 'acoes'])->make(true);
	        }
	}
	// Listando equipamentos por usuário
	public function ExibirUsuariosInventario(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$equipamentos = Ativos::all();
			$usuarios = AtivosUsuarios::join('usr_usuarios', 'usr_id_usuarios', 'usr_usuarios.id')->join('cli_associados', 'usr_usuarios.cli_id_associado', 'cli_associados.id')->whereNull('dataDevolucao')->select('cli_associados.nome', 'usr_usuarios.id')->groupBy('id')->get();
		
			return view('tecnologia.equipamentos.listarUsuarios')->with('ativos', $equipamentos)->with('usuarios', $usuarios);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando novos equipamentos
	public function AdicionarInventario(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$usuarios = Usuarios::where('status', 1)->get();
			$setores = Setores::where('status', 1)->get();
			$unidades = Unidades::where('status', 1)->get();
			return view('tecnologia.equipamentos.adicionar')->with('usuarios', $usuarios)->with('setores', $setores)->with('unidades', $unidades);
		}else{
			return redirect(route('403'));
		}
	}
	public function AdicionarSalvarInventario(AtivoRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Ativos::create([
				'nome' => $request->nome,
				'n_patrimonio' => (isset($request->n_patrimonio) ? $request->n_patrimonio : null), 
				'serialNumber' => $request->serialNumber, 
				'marca' => $request->marca,
				'modelo' => $request->modelo,
				'id_setor' => $request->id_setor,
				'id_unidade' => $request->id_unidade,
				'descricao' => (isset($request->descricao) ? $request->descricao : null), 
			]);
			// Carregando imagem principal
			if ($request->hasFile('imagem_principal')) {
				if($request->imagem_principal->isValid()){
					$name = uniqid(date('HisYmd'));
					$extension =  $request->imagem_principal->extension();
					$nameFile = "{$name}.{$extension}";
					$upload =  $request->imagem_principal->storeAs('equipamentos', $nameFile);
				}
				$imagem = Imagens::create(['endereco' => $upload, 'tipo' => 'ativos_principal']);
				Ativos::find($create->id)->update(['id_imagem' => $imagem->id]);
			}
			// Cadastramento de várias imagens
			if ($request->imagens) {
				foreach($request->imagens as $img){
					$imagem_produto = AtivosImagens::create([
						'id_ativo' => $create->id,
						'id_imagem' => $img                    
					]);
				}
			}
	        // Cadastrando o usuário responsável
			$usuarios = AtivosUsuarios::create([
				'gti_id_ativos' => $create->id,
				'usr_id_usuarios' => $request->usuario,
				'dataRecebimento' => now()
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo equipamento de tecnologia',
				'descricao' => 'Você cadastrou um novo equipamento de tecnologia, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.geral.equipamentos'),
				'id_usuario' => Auth::id()
			]);
			return redirect()->route('exibir.geral.equipamentos');
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do equipamento
	public function EditarInventario($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$equipamentos = Ativos::find($id);
			$usuarios = Usuarios::where('status', 1)->get();
			$setores = Setores::where('status', 1)->get();
			$unidades = Unidades::where('status', 1)->get();
			return view('tecnologia.equipamentos.editar')->with('usuarios', $usuarios)->with('setores', $setores)->with('equipamentos', $equipamentos)->with('unidades', $unidades);
		}else{
			return redirect(route('403'));
		}
	}
	public function EditarSalvarInventario(AtivoRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Ativos::find($id)->update([
				'nome' => $request->nome,
				'n_patrimonio' => (isset($request->n_patrimonio) ? $request->n_patrimonio : null),  
				'serialNumber' => $request->serialNumber, 
				'marca' => $request->marca,
				'modelo' => $request->modelo,
				'id_setor' => $request->id_setor,
				'id_unidade' => $request->id_unidade,
				'descricao' => (isset($request->descricao) ? $request->descricao : null),  
			]);
			// Carregando imagem principal
			if ($request->hasFile('imagem_principal')) {
				if($request->imagem_principal->isValid()){
					$name = uniqid(date('HisYmd'));
					$extension =  $request->imagem_principal->extension();
					$nameFile = "{$name}.{$extension}";
					$upload =  $request->imagem_principal->storeAs('ativos', $nameFile);
				}
				$imagem = Imagens::create(['endereco' => $upload, 'tipo' => 'ativos_principal']);
				Ativos::find($id)->update(['id_imagem' => $imagem->id]);
			}
	    	// Cadastramento de várias imagens
			if ($request->imagens) {
				AtivosImagens::where('id_ativo', $id)->delete();
				foreach($request->imagens as $img){
					$imagem_produto = AtivosImagens::create([
						'id_ativo' => $id,
						'id_imagem' => $img                    
					]);
				}
			}
	        // Cadastrando o usuário responsável
			$equipamento = Ativos::find($id);
			if($request->usuario){
				if($equipamento->RelationUsuario->first()->id != $request->usuario){
					AtivosUsuarios::find($equipamento->RelationUsuario->first()->pivot->id)->update(['dataDevolucao' => now()]);
					$usuarios = AtivosUsuarios::create([
						'gti_id_ativos' => $id,
						'usr_id_usuarios' => $request->usuario,
						'dataRecebimento' => now()
					]);
				}
			}
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do equipamento de tecnologia '.$equipamento->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.geral.equipamentos'),
				'id_usuario' => Auth::id()
			]);
			return redirect()->route('exibir.geral.equipamentos');
		}else{
			return redirect(route('403'));
		}
	}
	// Deletando o equipamento
	public function DeleteInventario($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Ativos::find($id);
			Atividades::create([
				'nome' => 'Remoção de equipamento',
				'descricao' => 'Você acabou de remover o equipamento de tecnologia '.$create->nome.'.',
				'icone' => 'mdi-delete-forever',
				'url' => route('exibir.geral.equipamentos'),
				'id_usuario' => Auth::id()
			]);
			AtivosImagens::where('id_ativo', $id)->delete();
			AtivosUsuarios::where('gti_id_ativos', $id)->delete();
			Ativos::find($id)->delete();
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do equipamento
	public function DetalhesInventario($id){
		$dados = Ativos::find($id);
		$dados->imagem = $dados->RelationImagemPrincipal;
		$dados->imagens  = $dados->RelationImagem;
		$dados->setor  = $dados->RelationSetor->nome;
		$dados->unidade  = $dados->RelationUnidade->nome;
		return response()->json($dados);
	}
	// Importando fotos do equipamento
	public function ImagensInventario(Request $request){
        // Cadastramento de várias imagens do mesmo produto
		if ($request->hasFile('imagens')) {
			foreach($request->file('imagens') as $imagem){
				if($imagem->isValid()){
					$name = uniqid(date('HisYmd'));
					$extension =  $imagem->extension();
					$nameFile = "{$name}.{$extension}";
					$upload =  $imagem->storeAs('ativos', $nameFile);
				}
				$imagens[] = Imagens::create(['endereco' => $upload, 'tipo' => 'ativos']);
			}
		}
		return response()->json($imagens);
	}


	#-------------------------------------------------------------------
	# Relatórios
	#-------------------------------------------------------------------
	// Listando lista de relatórios
	public function Relatorios(){
	    if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1 || Auth::user()->RelationFuncao->ver_administrativo == 1){
	    	$usuarios = AtivosUsuarios::join('usr_usuarios', 'usr_id_usuarios', 'usr_usuarios.id')->join('cli_associados', 'usr_usuarios.cli_id_associado', 'cli_associados.id')->whereNull('dataDevolucao')->select('cli_associados.nome', 'usr_usuarios.id')->groupBy('id')->get();
	      	return view('tecnologia.relatorios.exibir')->with('usuarios', $usuarios);
	    }else{
	      return redirect(route('403'));
	    }
	}
	// Relatório do equipamento
	public function RelatoriosInventario(Request $request){
		$equipamentos = AtivosUsuarios::join('gti_ativos', 'gti_id_ativos', 'gti_ativos.id')->whereNull('dataDevolucao')->where('usr_id_usuarios', $request->usuario)->get();
		Atividades::create([
	          'nome' => 'Geração do relatório de termo de uso',
	          'descricao' => 'Você gerou o relatório de termo de uso do associado '.$equipamentos->first()->RelationUsuarios->RelationAssociado->nome.'.',
	          'icone' => 'mdi-file-document',
	          'url' => 'javascript:',
	          'id_usuario' => Auth::id()
	        ]);
		$pdf = PDF::loadView('tecnologia.relatorios.termo', compact('equipamentos'))->setPaper('a4', 'portrait');
	    return $pdf->stream();
	}
}
