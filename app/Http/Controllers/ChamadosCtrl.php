<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\FuncoesRqt;
use App\Http\Requests\MessageRqt;
use App\Models\Chamados;
use App\Models\ChamadosImagens;
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
		$this->middleware('auth');
	}

    // ------------------------------------------
    // Funções para todos usuários
    // ------------------------------------------

    // Exibir para usuários
    public function ExibirUsuarios(){
        $chamados = Chamados::where('usr_id_usuarios', Auth::id())->orderBy('created_at', 'ASC')->get();
        $status = Status::where('status', 1)->get();
        return view('suporte.chamados.listar')->with('chamados', $chamados)->with('statusAtivos', $status);
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

        // Cadastramento de várias imagens do chamado
        if ($request->imagens) {
            foreach($request->imagens as $img){
                $imagem_produto = ChamadosImagens::create([
                    'gti_id_chamados' => $create->id,
                    'id_imagem' => $img                    
                ]);
            }
        }
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
    // Importando fotos do chamado
    public function Imagens(Request $request){
        // Cadastramento de várias imagens do mesmo produto
        if ($request->hasFile('imagens')) {
            foreach($request->file('imagens') as $imagem){
                if($imagem->isValid()){
                    $name = uniqid(date('HisYmd'));
                    $extension =  $imagem->extension();
                    $nameFile = "{$name}.{$extension}";
                    $upload =  $imagem->storeAs('chamados', $nameFile);
                }
                $imagens[] = Imagens::create(['endereco' => $upload, 'tipo' => 'chamados']);
            }
        }
        return response()->json($imagens);
    }
    // Removendo as fotos do chamado
    public function RemoveImagens($id){
        $imagem = Imagens::find($id);
        unlink(getcwd().'/storage/app/'.$imagem->endereco);
        //ChamadosImagens::find($id)->delete();
        Imagens::find($id)->delete();
        return response()->json(['success' => true]);
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
            'descricao' => (isset($request->descricao) ? $request->descricao : "Chamado finalizado por ".Auth::user()->RelationAssociado->nome.".")
        ]);
        return response()->json(['success' => true]);
    }
    // Relatório do chamado
    public function RelatorioGTI($id){
        $dados = Chamados::find($id);
        return view('tecnologia.chamados.relatorio')->with('chamado', $dados);
    }
    // Atualizando status
    public function StatusGTI(Request $request, $id){
        $chamado = Chamados::find($id);
        $status = ChamadosStatus::create([
            'gti_id_chamados' => $id,
            'gti_id_status' => $request->status,
            'descricao' => (isset($request->descricao) ? $request->descricao : "Estado do chamado alterado por ".Auth::user()->RelationAssociado->nome.".")
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
        ChamadosStatus::find($id)->delete();
        return response()->json(['success' => true]);
    }
    // Monitorando atualizações no status
    public function MonitorarGTI($id_chamado, $id_status){
        $novo = ChamadosStatus::where('gti_id_chamados', $id_chamado)->where('id', '>', $id_status)->get();
        return $novo;
    }
}
