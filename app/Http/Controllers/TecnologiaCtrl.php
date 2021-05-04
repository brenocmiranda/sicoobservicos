<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Notifications\SolicitacaoChamadosCliente;
use App\Notifications\SolicitacaoChamadosAdmin;
use App\Notifications\SolicitacaoChamadosAdminAtraso;
use App\Http\Requests\AtivoRqt; 
use App\Http\Requests\BaseRqt;
use App\Http\Requests\AmbientesRqt;
use App\Http\Requests\EquipamentosRqt;
use App\Http\Requests\MarcasRqt;
use App\Http\Requests\FontesRqt;
use App\Http\Requests\StatusRqt;
use App\Http\Requests\HomepageRqt;
use App\Models\Ativos;
use App\Models\AtivosImagens;
use App\Models\AtivosUsuarios;
use App\Models\AtivosMarcas;
use App\Models\AtivosEquipamentos;
use App\Models\Atividades;
use App\Models\Chamados;
use App\Models\ChamadosStatus;
use App\Models\ChamadosStatusArquivos;
use App\Models\Status;
use App\Models\Base;
use App\Models\BaseArquivos; 
use App\Models\Ambientes;
use App\Models\Fontes;
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
        $this->email = CogEmailsChamado::first();
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
		$chamadosFontes = Chamados::join('gti_fontes', 'gti_id_fontes', 'gti_fontes.id')->select('gti_id_fontes', 'gti_fontes.nome', \DB::raw('count(gti_id_fontes) as quantidade'))->groupBy('gti_id_fontes')->get();
		$chamadosAmbientes = Chamados::join('gti_ambientes', 'gti_id_ambientes', 'gti_ambientes.id')->select('gti_id_ambientes', 'gti_ambientes.nome', \DB::raw('count(gti_id_ambientes) as quantidade'))->groupBy('gti_id_ambientes')->get();
		$chamadosUsuarios = Chamados::join('gti_ambientes', 'gti_id_ambientes', 'gti_ambientes.id')->select('gti_id_ambientes', 'gti_ambientes.nome', \DB::raw('count(gti_id_ambientes) as quantidade'))->groupBy('gti_id_ambientes')->get();
		$chamadosDia = Chamados::select(\DB::raw('DATE(created_at) as data'), \DB::raw('count(created_at) as quantidade'))->orderBy(\DB::raw('DATE(created_at)'), 'DESC')->groupBy(\DB::raw('DATE(created_at)'))->limit(7)->get();
		$chamadosUsuarios = Chamados::groupBy('usr_id_usuarios')->select('usr_id_usuarios', \DB::raw('count(usr_id_usuarios) as quantidade'))->get();
		$equipamentosSetor = Ativos::join('usr_setores', 'id_setor', 'usr_setores.id')->select('id_setor', 'usr_setores.nome', \DB::raw('count(id_setor) as quantidade'))->groupBy('id_setor')->get();
		$equipamentosPA = Ativos::join('usr_unidades', 'id_unidade', 'usr_unidades.id')->select('id_unidade', 'usr_unidades.nome', \DB::raw('count(id_unidade) as quantidade'))->groupBy('id_unidade')->get();
		$equipamentosUsuarios = AtivosUsuarios::groupBy('usr_id_usuarios')->whereNotNull('dataDevolucao')->select('usr_id_usuarios', \DB::raw('count(usr_id_usuarios) as quantidade'))->get();
		$equipamentosMarca = Ativos::join('gti_ativos_has_marcas', 'id_marca', 'gti_ativos_has_marcas.id')->groupBy('id_marca')->select('nome', \DB::raw('count(id_marca) as quantidade'))->get();

		return view('tecnologia.dashboard')->with('homepage', $homepage)->with('chamados', $chamados)->with('chamadosEmaberto', $chamadosEmaberto)->with('chamadosEmandamento', $chamadosEmandamento)->with('chamadosEncerrado', $chamadosEncerrado)->with('chamadosFontes', $chamadosFontes)->with('chamadosAmbientes', $chamadosAmbientes)->with('chamadosDia', $chamadosDia)->with('chamadosUsuarios', $chamadosUsuarios)->with('equipamentosSetor', $equipamentosSetor)->with('equipamentosPA', $equipamentosPA)->with('equipamentosMarca', $equipamentosMarca)->with('equipamentosUsuarios', $equipamentosUsuarios); 
	}

	#-------------------------------------------------------------------
	# Chamados 
	#-------------------------------------------------------------------
	// Exibir todos chamados
    public function ExibirChamados(){
        if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
            $chamados = Chamados::orderBy('created_at', 'ASC')->get();
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
            $status = Status::where('status', 1)->get();
            return view('tecnologia.chamados.listar')->with('chamados', $chamados)->with('chamadosEmaberto', $chamadosEmaberto)->with('chamadosEmandamento', $chamadosEmandamento)->with('chamadosEncerrado', $chamadosEncerrado)->with('statusAtivos', $status);
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
    public function FinalizarChamados(Request $request, $id){
        if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
            $finalizar = Status::where('finish', 1)->first();
            $status = ChamadosStatus::create([
                'gti_id_chamados' => $id,
                'gti_id_status' => $finalizar->id,
                'descricao' => (isset($request->descricao) ? $request->descricao : "Chamado finalizado por ".Auth::user()->RelationAssociado->nome."."),
                'usr_id_usuarios' => Auth::id()
            ]);            
            // Cadastramento de vários arquivos 
	        if ($request->arquivos) {
	            foreach($request->arquivos as $arq){
	                $imagem_produto = ChamadosStatusArquivos::create([
	                    'gti_id_status' => $status->id,
	                    'id_arquivo' => $arq,                    
	                ]);
	            }
	        }
            // Alteração feita para atualizar a ordem de tratamento
            $create = Chamados::find($id);
            $atualizacao = Chamados::where('id', $id)->update(['assunto' => $create->assunto]);
            // Criando notificações por e-mail
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
        $historicoStatus = ChamadosStatus::where('gti_id_chamados', $id)->orderBy('created_at', 'ASC')->get();
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
            $status = ChamadosStatus::create([
                'gti_id_chamados' => $id,
                'gti_id_status' => $request->status,
                'descricao' => (isset($request->descricao) ? $request->descricao : "Estado do chamado alterado por ".Auth::user()->RelationAssociado->nome."."),
                'usr_id_usuarios' => Auth::id()
            ]);
            // Cadastramento de vários arquivos 
	        if ($request->arquivos) {
	            foreach($request->arquivos as $arq){
	                $imagem_produto = ChamadosStatusArquivos::create([
	                    'gti_id_status' => $status->id,
	                    'id_arquivo' => $arq,                    
	                ]);
	            }
	        }
            // Alteração feita para atualizar a ordem de tratamento
            $create = Chamados::find($id);
            $atualizacao = Chamados::where('id', $id)->update(['assunto' => $create->assunto]);
            // Criando notificações por e-mail
	        $create->RelationUsuario->notify(new SolicitacaoChamadosCliente($create));     
            $this->email->notify(new SolicitacaoChamadosAdmin($create));        
            Atividades::create([
                'nome' => 'Alteração de estado do chamado',
                'descricao' => 'Você modificou o status do chamado, '.$create->assunto.'.',
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
            ChamadosStatusArquivos::where('gti_id_status', $id)->delete();
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
    // Fazendo upload de arquivos
    public function ArquivosChamadosStatus(Request $request){
        // Cadastramento de várias imagens do mesmo produto
        if ($request->hasFile('arquivos')) {
            foreach($request->file('arquivos') as $imagem){
                if($imagem->isValid()){
                    $string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($imagem->extension(), '', $imagem->getClientOriginalName()));
                    $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
                    $extension =  $imagem->extension();
                    $nameFile = "{$name}.{$extension}";
                    $upload =  $imagem->storeAs('chamados', $nameFile);
                }
                $arquivos[] = Arquivos::create(['endereco' => $upload, 'tipo' => 'chamados']);
            }
        }
        return response()->json($arquivos);
    }
    // Removendo arquivos de anexo
    public function RemoveArquivosChamadosStatus($id){
        $arquivo = Arquivos::find($id);
        unlink(getcwd().'/storage/app/'.$arquivo->endereco);
        $dados = ChamadosStatusArquivos::where('id_arquivo', $id)->get();
        if(isset($dados)){
            ChamadosStatusArquivos::where('id_arquivo', $id)->delete();
        }
        Arquivos::find($id)->delete();
        return response()->json(['success' => true]);
    }
    // Monitorando tempo de vida do status
    public function MonitorarTempoVidaStatus(){
    	$chamados = Chamados::all();
    	foreach($chamados as $dados){
    		$tempo = explode(':', $dados->RelationStatus->first()->tempo);
            if($dados->RelationStatus->first()->pivot->created_at < date('Y-m-d H:i:s', strtotime('-'.explode(':', $dados->RelationStatus->first()->tempo)[0].' hours -'.explode(':', $dados->RelationStatus->first()->tempo)[1].' minutes -'.explode(':', $dados->RelationStatus->first()->tempo)[2].' seconds')) && ($dados->RelationStatus->first()->finish != 1)){
                $atrasados[] = $dados;  
            }
    	}
        if(isset($dados)){
            $configuracoes = CogEmailsChamado::first();
            $configuracoes->notify(new SolicitacaoChamadosAdminAtraso($atrasados)); 
        }
        return response()->json(['success' => true]);
    }


	#-------------------------------------------------------------------
	# Configurações (Aprendizagem)
	#-------------------------------------------------------------------
	// Listando todos tópicos
	public function ExibirAprendizagem(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$topicos = Base::orderBy('created_at', 'DESC')->get();
			return view('tecnologia.aprendizagem.exibir')->with('topicos', $topicos);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando novos tópicos
	public function AdicionarAprendizagem(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$ambientes = Ambientes::where('status', 1)->orderBy('nome', 'ASC')->get();
			$fontes = Fontes::where('status', 1)->orderBy('nome', 'ASC')->get();
			return view('tecnologia.aprendizagem.adicionar')->with('ambientes', $ambientes)->with('fontes', $fontes);
		}else{
			return redirect(route('403'));
		}
	}
	public function AdicionarSalvarAprendizagem(BaseRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Base::create([
				'titulo' => $request->titulo,
				'subtitulo' => (isset($request->subtitulo) ? $request->subtitulo : null), 
				'descricao' => $request->descricao, 
                'tipo' => $request->tipo, 
				'gti_id_ambientes' => $request->gti_id_ambientes,
				'gti_id_fontes' => $request->gti_id_fontes,
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
			$ambientes = Ambientes::where('status', 1)->orderBy('nome', 'ASC')->get();
			$fontes = Fontes::where('status', 1)->where('gti_id_ambientes', $base->gti_id_ambientes)->orderBy('nome', 'ASC')->get();
			return view('tecnologia.aprendizagem.editar')->with('base', $base)->with('ambientes', $ambientes)->with('fontes', $fontes);
		}else{
			return redirect(route('403'));
		}
	}
	public function EditarSalvarAprendizagem(BaseRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Base::find($id)->update([
				'titulo' => $request->titulo,
				'subtitulo' => (isset($request->subtitulo) ? $request->subtitulo : null),
				'descricao' => $request->descricao, 
                'tipo' => $request->tipo, 
				'gti_id_ambientes' => $request->gti_id_ambientes,
				'gti_id_fontes' => $request->gti_id_fontes, 
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
	// Importando arquivos de anexo
    public function ArquivosAprendizagem(Request $request){
        // Cadastramento de várias imagens do mesmo tópico
        if ($request->hasFile('arquivos')) {
            foreach($request->file('arquivos') as $key => $imagem){
                if($imagem->isValid()){
                    $name = 'Arquivo_'.rand(1, 999);
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
	# Configurações (Ambientes)
	#-------------------------------------------------------------------
    // Listando todos os ambientes
	public function ExibirAmbientes(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return view('tecnologia.configuracoes.chamados.ambientes.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesAmbientes(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return datatables()->of(Ambientes::all())
	            ->editColumn('nome1', function(Ambientes $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Ambientes $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Ambientes $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a fonte"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a fonte"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }else{
        	return datatables()->of(Ambientes::all())
	            ->editColumn('nome1', function(Ambientes $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Ambientes $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Ambientes $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }
	}
	// Adicionando novos ambientes
	public function AdicionarAmbientes(AmbientesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Ambientes::create([
				'nome' => $request->nome, 
				'descricao' => $request->descricao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo ambiente',
				'descricao' => 'Você cadastrou uma nova configuração de ambiente, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.ambientes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return $create;
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do ambiente
	public function EditarAmbientes(AmbientesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Ambientes::find($id)->update([
				'nome' => $request->nome, 
				'descricao' => $request->descricao, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Ambientes::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do ambiente: '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.ambientes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarAmbientes($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$ambientes = Ambientes::find($id);
			if($ambientes->status == 1){
				Ambientes::find($id)->update(['status' => 0]);
			}else{
				Ambientes::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status do ambiente, '.$ambientes->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.ambientes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes da ambientes
	public function DetalhesAmbientes($id){
		$dados = Ambientes::find($id);
		return $dados;
	}

	#-------------------------------------------------------------------
	# Configurações (Equipamentos)
	#-------------------------------------------------------------------
    // Listando todos os equipamentos
	public function ExibirEquipamentos(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return view('tecnologia.configuracoes.inventario.equipamentos.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesEquipamentos(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return datatables()->of(AtivosEquipamentos::all())
	            ->editColumn('nome1', function(AtivosEquipamentos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(AtivosEquipamentos $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(AtivosEquipamentos $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a fonte"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a fonte"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }else{
        	return datatables()->of(AtivosEquipamentos::all())
	            ->editColumn('nome1', function(AtivosEquipamentos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(AtivosEquipamentos $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(AtivosEquipamentos $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }
	}
	// Adicionando novo equipamento
	public function AdicionarEquipamentos(EquipamentosRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = AtivosEquipamentos::create([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo equipamento',
				'descricao' => 'Você cadastrou um nova configuração de equipamento, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.equipamentos.inventario'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações dos equipamentos
	public function EditarEquipamentos(EquipamentosRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			AtivosEquipamentos::find($id)->update([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = AtivosEquipamentos::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da configuração de equipamento '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.equipamentos.inventario'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarEquipamentos($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$equipamentos = AtivosEquipamentos::find($id);
			if($equipamentos->status == 1){
				AtivosEquipamentos::find($id)->update(['status' => 0]);
			}else{
				AtivosEquipamentos::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da configuração de equipamento '.$equipamentos->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.equipamentos.inventario'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do equipamento
	public function DetalhesEquipamentos($id){
		$dados = AtivosEquipamentos::find($id);
		return $dados;
	}

	#-------------------------------------------------------------------
	# Configurações (Marcas)
	#-------------------------------------------------------------------
    // Listando todos as marcas
	public function ExibirMarcas(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return view('tecnologia.configuracoes.inventario.marcas.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesMarcas(){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			return datatables()->of(AtivosMarcas::all())
	            ->editColumn('nome1', function(AtivosMarcas $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(AtivosMarcas $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(AtivosMarcas $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a fonte"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da fonte"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a fonte"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }else{
        	return datatables()->of(AtivosMarcas::all())
	            ->editColumn('nome1', function(AtivosMarcas $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(AtivosMarcas $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(AtivosMarcas $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'acoes'])->make(true);
        }
	}
	// Adicionando nova marca
	public function AdicionarMarcas(MarcasRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = AtivosMarcas::create([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova marca',
				'descricao' => 'Você cadastrou um nova configuração de marca, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.equipamentos.inventario'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações das marcas
	public function EditarMarcas(MarcasRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			AtivosMarcas::find($id)->update([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = AtivosMarcas::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da configuração de marca '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.equipamentos.inventario'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarMarcas($id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$equipamentos = AtivosMarcas::find($id);
			if($equipamentos->status == 1){
				AtivosMarcas::find($id)->update(['status' => 0]);
			}else{
				AtivosMarcas::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da configuração da marca '.$equipamentos->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.equipamentos.inventario'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes da marca
	public function DetalhesMarcas($id){
		$dados = AtivosMarcas::find($id);
		return $dados;
	}

	#-------------------------------------------------------------------
	# Configurações (Fontes)
	#-------------------------------------------------------------------
	// Listando todos os fontes
	public function ExibirFontes(){
		if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$ambientes = Ambientes::where('status', 1)->orderBy('nome', 'ASC')->get();
			return view('tecnologia.configuracoes.chamados.fontes.listar')->with('ambientes', $ambientes);
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
	            ->editColumn('fonte', function(Fontes $dados){
	                return $dados->RelationAmbientes->nome;
	            })
	            ->editColumn('acoes', function(Fontes $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'status1', 'fonte', 'acoes'])->make(true);
	    }else{
	    	return datatables()->of(Fontes::all())
	            ->editColumn('nome1', function(Fontes $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('status1', function(Fontes $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('fonte', function(Fontes $dados){
	                return $dados->RelationAmbientes->nome;
	            })
	            ->editColumn('acoes', function(Fontes $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'fonte', 'acoes'])->make(true);
	    }
	}
	// Adicionando novo tipo
	public function AdicionarFontes(FontesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Fontes::create([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'gti_id_ambientes' => $request->gti_id_ambientes,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova fonte',
				'descricao' => 'Você cadastrou um nova fonte de chamado, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.fontes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações dos fontes
	public function EditarFontes(FontesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Fontes::find($id)->update([
				'nome' => $request->nome, 
				'descricao' => $request->descricao,
				'gti_id_ambientes' => $request->gti_id_ambientes,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Fontes::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da fonte de chamado '.$create->nome.'.',
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
				'descricao' => 'Você alterou o status da fonte de chamado '.$fontes->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.fontes.chamados'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do tipo
	public function DetalhesFontes($id){
		$dados = Fontes::find($id);
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
			return view('tecnologia.atalhos.listar')->with('atalhos', $dados);
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
				'url' => route('exibir.atalhos'),
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
				'url' => route('exibir.atalhos'),
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
				'url' => route('exibir.atalhos'),
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
            $usuarios = Usuarios::where('status', 1)->orderBy('login', 'ASC')->get();
			return view('tecnologia.equipamentos.listar')->with('ativos', $equipamentos)->with('usuarios', $usuarios);
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
	            ->editColumn('marca', function(Ativos $dados){ 
	                return $dados->RelationMarca->nome;
	            })
                ->editColumn('localizacao', function(Ativos $dados){ 
                    return $dados->RelationSetor->nome;
                })
	            ->editColumn('equipamento', function(Ativos $dados){ 
	                return $dados->RelationEquipamento->nome;
	            })
	            ->editColumn('nome1', function(Ativos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationEquipamento->nome.' '.$dados->RelationMarca->nome.'<br><small>'.$dados->modelo.'</small></a>';
	            })
	            ->editColumn('acoes', function(Ativos $dados){ 
	                return '
                    <a href="javascript:" class="btn btn-dark btn-xs btn-rounded mx-1" id="historico" title="Histórico de usuários"><i class="mx-0 mdi mdi-file-document-box"></i></a>
	                <a href="'.route('editar.equipamentos', $dados->id).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do equipamento"><i class="mx-0 mdi mdi-settings"></i></a>
                    <a href="javascript:" class="btn btn-dark btn-xs btn-rounded mx-1" id="alterar" title="Alterar usuário responsável"><i class="mx-0 mdi mdi-account-convert"></i></a>
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
		            ->editColumn('marca', function(Ativos $dados){ 
	                return $dados->RelationMarca->nome;
		            })
                    ->editColumn('localizacao', function(Ativos $dados){ 
                        return $dados->RelationSetor->nome;
                    })
		            ->editColumn('equipamento', function(Ativos $dados){ 
		                return $dados->RelationEquipamento->nome;
		            })
		            ->editColumn('nome1', function(Ativos $dados){ 
	                  return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationEquipamento->nome.' '.$dados->RelationMarca->nome.'<br><small>'.$dados->modelo.'</small></a>';
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
			$marcas = AtivosMarcas::where('status', 1)->orderBy('nome', 'ASC')->get();
			$equipamentos = AtivosEquipamentos::where('status', 1)->orderBy('nome', 'ASC')->get();
			$usuarios = Usuarios::where('status', 1)->orderBy('login', 'ASC')->get();
			$setores = Setores::where('status', 1)->get();
			$unidades = Unidades::where('status', 1)->get();
			return view('tecnologia.equipamentos.adicionar')->with('usuarios', $usuarios)->with('setores', $setores)->with('unidades', $unidades)->with('equipamentos', $equipamentos)->with('marcas', $marcas);
		}else{
			return redirect(route('403'));
		}
	}
	public function AdicionarSalvarInventario(AtivoRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			$create = Ativos::create([
				'id_equipamento' => $request->id_equipamento,
                'sistema_operacional' => (isset($request->sistema_operacional) ? $request->sistema_operacional : null),
                'tipo_licenca' => (isset($request->tipo_licenca) ? $request->tipo_licenca : null),
                'antivirus' => (isset($request->antivirus) ? $request->antivirus : null),
				'n_patrimonio' => (isset($request->n_patrimonio) ? strtoupper($request->n_patrimonio) : null), 
				'serviceTag' => (isset($request->serviceTag) ? strtoupper($request->serviceTag) : null),
                'serialNumber' => strtoupper($request->serialNumber), 
				'id_marca' => $request->id_marca,
				'modelo' => strtoupper($request->modelo),
				'id_setor' => $request->id_setor,
				'id_unidade' => $request->id_unidade,
				'descricao' => (isset($request->descricao) ? strtoupper($request->descricao) : null), 
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
			$ativo = Ativos::find($id);
			$marcas = AtivosMarcas::where('status', 1)->orderBy('nome', 'ASC')->get();
			$equipamentos = AtivosEquipamentos::where('status', 1)->orderBy('nome', 'ASC')->get();
			$usuarios = Usuarios::where('status', 1)->orderBy('login', 'ASC')->get();
			$setores = Setores::where('status', 1)->get();
			$unidades = Unidades::where('status', 1)->get();
			return view('tecnologia.equipamentos.editar')->with('usuarios', $usuarios)->with('setores', $setores)->with('ativo', $ativo)->with('unidades', $unidades)->with('equipamentos', $equipamentos)->with('marcas', $marcas);
		}else{
			return redirect(route('403'));
		}
	}
	public function EditarSalvarInventario(AtivoRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_gti == 1){
			Ativos::find($id)->update([
				'id_equipamento' => $request->id_equipamento,
                'sistema_operacional' => (isset($request->sistema_operacional) ? $request->sistema_operacional : null),
                'tipo_licenca' => (isset($request->tipo_licenca) ? $request->tipo_licenca : null),
                'antivirus' => (isset($request->antivirus) ? $request->antivirus : null),
                'n_patrimonio' => (isset($request->n_patrimonio) ? strtoupper($request->n_patrimonio) : null), 
                'serviceTag' => (isset($request->serviceTag) ? strtoupper($request->serviceTag) : null),
                'serialNumber' => strtoupper($request->serialNumber), 
                'id_marca' => $request->id_marca,
                'modelo' => strtoupper($request->modelo),
                'id_setor' => $request->id_setor,
                'id_unidade' => $request->id_unidade,
                'descricao' => (isset($request->descricao) ? strtoupper($request->descricao) : null),  
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
		$dados->marca = $dados->RelationMarca->nome;
		$dados->equipamento = $dados->RelationEquipamento->nome;
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
    // Alterando o usuário responsável
    public function AlterarUsuarioInvetario(Request $request){
        $equipamento = Ativos::find($request->id);
        if($request->usuario){
            if($equipamento->RelationUsuario->first()->id != $request->usuario){
                AtivosUsuarios::find($equipamento->RelationUsuario->first()->pivot->id)->update(['dataDevolucao' => now()]);
                $usuarios = AtivosUsuarios::create([
                    'gti_id_ativos' => $request->id,
                    'usr_id_usuarios' => $request->usuario,
                    'dataRecebimento' => now()
                ]);
            }
        }
    }

    // Histórico dos usuários
    public function HistoricoInvetario($id){
        $dados = AtivosUsuarios::join('usr_usuarios', 'usr_id_usuarios', 'usr_usuarios.id')->join('cli_associados', 'usr_usuarios.cli_id_associado', 'cli_associados.id')->where('gti_id_ativos', $id)->select('gti_ativos_has_usuarios.*', 'cli_associados.nome')->get();
        return response()->json($dados); 
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
