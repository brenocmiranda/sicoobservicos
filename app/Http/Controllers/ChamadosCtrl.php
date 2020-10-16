<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Notifications\ChamadosReaberturaAdmin;
use App\Notifications\ChamadosReaberturaCliente;
use App\Notifications\ChamadosCliente;
use App\Notifications\ChamadosAdmin;
use App\Notifications\ChamadosAlteracaoCliente;
use App\Http\Requests\FuncoesRqt;
use App\Http\Requests\MessageRqt;
use App\Models\Arquivos;
use App\Models\Atividades;
use App\Models\Chamados;
use App\Models\CogEmailsChamado;
use App\Models\ChamadosArquivos;
use App\Models\ChamadosStatus;
use App\Models\ChamadosMensagens;
use App\Models\Imagens;
use App\Models\Status;
use App\Models\Base;
use App\Models\Tipos;
use App\Models\Fontes;

class ChamadosCtrl extends Controller
{   

    public function __construct(){
        $this->email = CogEmailsChamado::first();
		$this->middleware('auth');
	}

    // ------------------------------------------
    // Funções para todos usuários
    // ------------------------------------------

    // Exibir para usuários
    public function ExibirUsuarios(){
        $chamados = Chamados::where('usr_id_usuarios', Auth::id())->orderBy('created_at', 'ASC')->get();
        $status = Status::where('status', 1)->get();
        if(Auth::user()->RelationFuncao->gerenciar_gti != 1){
            return view('suporte.chamados.listar')->with('chamados', $chamados)->with('statusAtivos', $status);
        }else{
            return redirect(route('exibir.chamados.gti'));
        }
    }
	// Abertura de chamados
	public function Abertura(){
		$fontes = Fontes::orderBy('nome', 'ASC')->get();
		return view('suporte.chamados.abertura')->with('fontes', $fontes);
	}
    // Salvando o chamado
    public function AberturaEnviar(Request $request){
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

        Auth::user()->notify(new ChamadosCliente($create));  
        $this->email->notify(new ChamadosAdmin($create));

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
    public function Detalhes($id){
        $chamado = Chamados::find($id);
        $status = Status::where('status', 1)->get();
        return view('suporte.chamados.detalhes')->with('chamado', $chamado)->with('statusAtivos', $status);
    }
    // Finalizando chamado
    public function Finalizar(Request $request, $id){
        $finalizar = Status::where('finish', 1)->first();
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $id,
            'gti_id_status' => $finalizar->id,
            'descricao' => (isset($request->descricao) ? $request->descricao : "Chamado finalizado por ".Auth::user()->RelationAssociado->nome.".")
        ]);
        $create = Chamados::find($id);
        $status->RelationUsuario->notify(new ChamadosAlteracaoCliente($status));  
        Atividades::create([
            'nome' => 'Encerramento de chamado',
            'descricao' => 'Você efetuou o encerramento do chamado, '.$create->assunto.'.',
            'icone' => 'mdi-headset-off',
            'url' => route('detalhes.chamados', $id),
            'id_usuario' => Auth::id()
        ]);
        return response()->json(['success' => true]);
    }
    // Finalizando chamado
    public function Reabertura($id){
        $abertura = Status::where('open', 1)->first();
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $id,
            'gti_id_status' => $abertura->id,
            'descricao' =>  "Chamado reaberto pelo colaborador: ".Auth::user()->RelationAssociado->nome."."
        ]);
        $create = Chamados::find($id);
        Auth::user()->notify(new ChamadosReaberturaCliente($create));  
        $this->email->notify(new ChamadosReaberturaAdmin($create));
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
    public function ListarTipos($idFonte){
        $tipos = Tipos::where('gti_id_fontes', $idFonte)->get();
        return $tipos;
    }
    // Listando items da base de conhecimento
    public function ListarBase($idTipo, $idFonte){
        $dados = Base::where('gti_id_fontes', $idFonte)->where('gti_id_tipos', $idTipo)->limit(5)->get();
        return $dados;
    }
    public function Arquivos(Request $request){
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
    public function RemoveArquivos($id){
        $arquivo = Arquivos::find($id);
        unlink(getcwd().'/storage/app/'.$arquivo->endereco);
        ChamadosArquivos::where('id_arquivo', $id)->delete();
        Arquivos::find($id)->delete();
        return response()->json(['success' => true]);
    }
    // Relatório do chamado
    public function Relatorio($id){
        $dados = Chamados::find($id);
        Atividades::create([
            'nome' => 'Emissão de relatório do chamado',
            'descricao' => 'Você efetuou a emissão do relatório do chamado, '.$dados->assunto.'.',
            'icone' => 'mdi-file-document',
            'url' => route('detalhes.chamados.gti', $id),
            'id_usuario' => Auth::id()
        ]);
        return view('tecnologia.chamados.relatorio')->with('chamado', $dados);
    }

    // ------------------------------------------
    // Funções para membro GTI
    // ------------------------------------------

    // Exibir todos chamados
    public function ExibirGTI(){
        $chamados = Chamados::orderBy('created_at', 'ASC')->get();
        $status = Status::where('status', 1)->get();
        return view('tecnologia.chamados.listar')->with('chamados', $chamados)->with('statusAtivos', $status);
    }
    // Detalhes do chamado
    public function DetalhesGTI($id){
        $chamado = Chamados::find($id);
        $status = Status::where('status', 1)->get();
        return view('tecnologia.chamados.detalhes')->with('chamado', $chamado)->with('statusAtivos', $status);
    }
    // Finalizando chamado
    public function FinalizarGTI(Request $request, $id){
        $finalizar = Status::where('finish', 1)->first();
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $id,
            'gti_id_status' => $finalizar->id,
            'descricao' => (isset($request->descricao) ? $request->descricao : "Chamado finalizado por ".Auth::user()->RelationAssociado->nome."."),
            'usr_id_usuarios' => Auth::id()
        ]);
        $create = Chamados::find($id);
        $create->RelationUsuario->notify(new ChamadosAlteracaoCliente($create));  
        Atividades::create([
            'nome' => 'Encerramento de chamado',
            'descricao' => 'Você efetuou o encerramento do chamado, '.$create->assunto.'.',
            'icone' => 'mdi-headset-off',
            'url' => route('detalhes.chamados.gti', $id),
            'id_usuario' => Auth::id()
        ]);
        return response()->json(['success' => true]);
    }
    // Relatório do chamado
    public function RelatorioGTI($id){
        $dados = Chamados::find($id);
        Atividades::create([
            'nome' => 'Emissão de relatório do chamado',
            'descricao' => 'Você efetuou a emissão do relatório do chamado, '.$dados->assunto.'.',
            'icone' => 'mdi-file-document',
            'url' => route('detalhes.chamados.gti', $id),
            'id_usuario' => Auth::id()
        ]);
        return view('tecnologia.chamados.relatorio')->with('chamado', $dados);
    }
    // Atualizando status
    public function StatusGTI(Request $request, $id){
        $chamado = Chamados::find($id);
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $id,
            'gti_id_status' => $request->status,
            'descricao' => (isset($request->descricao) ? $request->descricao : "Estado do chamado alterado por ".Auth::user()->RelationAssociado->nome."."),
            'usr_id_usuarios' => Auth::id()
        ]);
        
        if($chamado->RelationStatus->first()->finish == 1){
            $chamado->RelationUsuario->notify(new ChamadosCliente($chamado));  
        }else{
            $chamado->RelationUsuario->notify(new ChamadosAlteracaoCliente($chamado));  
        }

        Atividades::create([
            'nome' => 'Alteração de estado do chamado',
            'descricao' => 'Você modificou o status do chamado, '.$chamado->assunto.'.',
            'icone' => 'mdi-file-document',
            'url' => route('detalhes.chamados.gti', $id),
            'id_usuario' => Auth::id()
        ]);
        return response()->json(['success' => true]);
    }
    // Dados dos status
    public function InfoGTI($id){
        $dados = ChamadosStatus::find($id);
        return $dados;
    }
    // Alterando descrição dos status
    public function DescricaoGTI(Request $request){
        ChamadosStatus::find($request->id)->update(['descricao' => $request->descricao]);
        return $request;
    }
    // Removendo status
    public function RemoveGTI($id){
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
    }
    // Monitorando atualizações no status
    public function MonitorarGTI($id_chamado, $id_status){
        $novo = ChamadosStatus::where('gti_id_chamados', $id_chamado)->where('id', '>', $id_status)->get();
        return $novo;
    }
}
