<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Notifications\SolicitacaoMaterialCliente;
use App\Notifications\SolicitacaoMaterialAdmin;
use App\Notifications\SolicitacaoChamadosCliente;
use App\Notifications\SolicitacaoChamadosAdmin;
use App\Notifications\SolicitacaoChamadosReAdmin;
use App\Notifications\SolicitacaoChamadosReCliente;
use App\Models\Base;
use App\Models\Fontes;
use App\Models\Tipos;
use App\Models\Status;
use App\Models\Arquivos;
use App\Models\Atividades; 
use App\Models\Documentos;
use App\Models\Materiais;
use App\Models\MateriaisCategorias;
use App\Models\MateriaisHistorico;
use App\Models\Chamados;
use App\Models\ChamadosArquivos;
use App\Models\ChamadosStatus;
use App\Models\CogEmailsChamado;

class SuporteCtrl extends Controller
{
   	public function __construct(){
   		$this->email = CogEmailsChamado::first();
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Aprendizagem
	#-------------------------------------------------------------------
	// Exibir base de conhecimento
	public function Aprendizagem(){
		$fontes = Base::join('gti_fontes', 'gti_id_fontes', 'gti_fontes.id')->where('gti_fontes.status', 1)->select('gti_fontes.*')->orderBy('nome', 'ASC')->get();
		$tipos = Base::join('gti_tipos', 'gti_id_tipos', 'gti_tipos.id')->where('gti_tipos.status', 1)->select('gti_tipos.*')->orderBy('nome', 'ASC')->get();
		return view('suporte.base.exibir')->with('fontes', $fontes)->with('tipos', $tipos);	
	}
	// Listar todos os itens da base
	public function AprendizagemListar($fonte, $tipo){
		$todos = Base::where('gti_id_fontes', $fonte)->where('gti_id_tipos', $tipo)->get();
		$fonte = Fontes::find($fonte);
		$tipo = Tipos::find($tipo);
		return view('suporte.base.listar')->with('todos', $todos)->with('fonte', $fonte)->with('tipo', $tipo);
	}


	#-------------------------------------------------------------------
	# Chamados
	#-------------------------------------------------------------------
	// Exibir todos chamados
    public function Chamados(){
        $chamados = Chamados::where('usr_id_usuarios', Auth::id())->orderBy('created_at', 'ASC')->get();
        $status = Status::where('status', 1)->get();
        if(Auth::user()->RelationFuncao->gerenciar_gti != 1){
            return view('suporte.chamados.listar')->with('chamados', $chamados)->with('statusAtivos', $status);
        }else{
            return redirect(route('exibir.chamados.gti'));
        }
    }
	// Abertura de chamados
	public function AberturaChamados(){
		$fontes = Fontes::orderBy('nome', 'ASC')->get();
		return view('suporte.chamados.abertura')->with('fontes', $fontes);
	}
    // Salvando o chamado
    public function AberturaEnviarChamados(Request $request){
        // Abertura
        $create = Chamados::create([
            'assunto' => $request->assunto, 
            'descricao' => $request->descricao, 
            'gti_id_tipos' => $request->tipos, 
            'gti_id_fontes' => $request->fontes, 
            'usr_id_usuarios' => Auth::id(), 
        ]);

        // Cadastramento do status de abertura
        $statusAbertura = Status::where('open', 1)->first();
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $create->id,
            'gti_id_status' => $statusAbertura->id,
            'descricao' => "Abertura do chamado registrado junto a equipe de TI. Aguarde alguns instantes que logo estaremos analisando sua solicitação."
        ]);

        // Cadastramento de vários arquivos 
        if ($request->arquivos) {
            foreach($request->arquivos as $arq){
                $imagem_produto = ChamadosArquivos::create([
                    'gti_id_chamados' => $create->id,
                    'id_arquivo' => $arq                    
                ]);
            }
        }

        Auth::user()->notify(new SolicitacaoChamadosCliente($create));  
        $this->email->notify(new SolicitacaoChamadosAdmin($create));

        Atividades::create([
            'nome' => 'Abertura de chamado',
            'descricao' => 'Você efetuou a abertura de uma chamado, '.$create->assunto.'.',
            'icone' => 'mdi-headset',
            'url' => route('detalhes.chamados', $create->id),
            'id_usuario' => Auth::id()
        ]);
        return redirect()->route('detalhes.chamados', $create->id);
    }
    // Detalhes do chamado
    public function DetalhesChamados($id){
        $chamado = Chamados::find($id);
        $status = Status::where('status', 1)->get();
        $historicoStatus = ChamadosStatus::where('gti_id_chamados', $id)->orderBy('created_at', 'DESC')->get();
        return view('suporte.chamados.detalhes')->with('chamado', $chamado)->with('statusAtivos', $status)->with('historicoStatus', $historicoStatus);
    }
    // Finalizando chamado
    public function FinalizarChamados(Request $request, $id){
        $finalizar = Status::where('finish', 1)->first();
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $id,
            'gti_id_status' => $finalizar->id,
            'descricao' => (isset($request->descricao) ? $request->descricao : "Chamado finalizado por ".Auth::user()->RelationAssociado->nome.".")
        ]);
        $create = Chamados::find($id);
        $status->RelationUsuario->notify(new SolicitacaoChamadosCliente($status));  
        Atividades::create([
            'nome' => 'Encerramento de chamado',
            'descricao' => 'Você efetuou o encerramento do chamado, '.$create->assunto.'.',
            'icone' => 'mdi-headset-off',
            'url' => route('detalhes.chamados', $id),
            'id_usuario' => Auth::id()
        ]);
        return response()->json(['success' => true]);
    }
    // Reabertura chamado
    public function ReaberturaChamados($id){
        $abertura = Status::where('open', 1)->first();
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $id,
            'gti_id_status' => $abertura->id,
            'descricao' =>  "Chamado reaberto pelo colaborador: ".Auth::user()->RelationAssociado->nome."."
        ]);
        $create = Chamados::find($id);
        Auth::user()->notify(new SolicitacaoChamadosReCliente($create));  
        $this->email->notify(new SolicitacaoChamadosReAdmin($create));
        Atividades::create([
            'nome' => 'Reabertura de chamado',
            'descricao' => 'Você efetuou a reabertura do chamado, '.$create->assunto.'.',
            'icone' => 'mdi-headset',
            'url' => route('detalhes.chamados', $id),
            'id_usuario' => Auth::id()
        ]);
        return response()->json(['success' => true]);
    }
    // Listando os tipos
    public function ListarTiposChamados($idFonte){
        $tipos = Tipos::where('gti_id_fontes', $idFonte)->get();
        return $tipos;
    }
    // Listando items da base de conhecimento
    public function ListarBaseChamados($idTipo, $idFonte){
        $dados = Base::where('gti_id_fontes', $idFonte)->where('gti_id_tipos', $idTipo)->limit(5)->get();
        return $dados;
    }
    // Fazendo upload de arquivos
    public function ArquivosChamados(Request $request){
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
    public function RemoveArquivosChamados($id){
        $arquivo = Arquivos::find($id);
        unlink(getcwd().'/storage/app/'.$arquivo->endereco);
        $dados = ChamadosArquivos::where('id_arquivo', $id)->get();
        if(isset($dados)){
            ChamadosArquivos::where('id_arquivo', $id)->delete();
        }
        Arquivos::find($id)->delete();
        return response()->json(['success' => true]);
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


	#-------------------------------------------------------------------
	# Documentos
	#-------------------------------------------------------------------
	public function Documentos(){
		$dados = Documentos::where('status', 1)->get();
		return view('suporte.documentos.exibir')->with('dados', $dados);
	}


	#-------------------------------------------------------------------
	# Solicitação de materiais
	#-------------------------------------------------------------------
	public function Materiais(){
		$historico = MateriaisHistorico::where('id_usuario', Auth::id())->where('tipo', 's')->orderBy('created_at', 'DESC')->get();
		$pendencias = MateriaisHistorico::where('status', 0)->orderBy('created_at', 'DESC')->get();
		$categorias = MateriaisCategorias::where('status', 1)->orderBy('nome', 'ASC')->get();
		return view('suporte.materiais.exibir')->with('pendencias', $pendencias)->with('requisicoes', $historico)->with('categorias', $categorias);
	}
	// Efetuar solicitação
	public function MateriaisSolicitacao(Request $request){
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
	public function MateriaisListar($id){
		$dados = Materiais::where('id_categoria', $id)->get();
		return $dados;
	}
	
}
