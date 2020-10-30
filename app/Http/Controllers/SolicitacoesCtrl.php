<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Notifications\SolicitacaoContratoAdmin;
use App\Notifications\SolicitacaoContratoCliente;
use App\Models\Solicitacoes;
use App\Models\SolicitacoesStatus;
use App\Models\Contratos;
use App\Models\ProdutosCred;
use App\Models\Modalidades;
use App\Models\Atividades;
use App\Models\CogEmailsContrato;

class SolicitacoesCtrl extends Controller
{
	public function __construct(){
		$this->email = CogEmailsContrato::first();
		$this->middleware('auth');
	}

    // Listando todos produtos
	public function Exibir(){
		$dados = Solicitacoes::orderBy('created_at', 'DESC')->get();
		$contratos = Contratos::all();
		$produtos = ProdutosCred::where('status', 1)->orderBy('nome', 'ASC')->get(); 
		$modalidades = Modalidades::where('status', 1)->orderBy('nome', 'ASC')->get();
		return view('credito.solicitacoes.exibir')->with('dados', $dados)->with('contratos', $contratos)->with('produtos', $produtos)->with('modalidades', $modalidades);
	}

	// Efetuando a solicitação
	public function Solicitar(Request $request){
		$create = Solicitacoes::create([
			'usr_id_usuario' => Auth::id(),
			'cre_id_contratos' => $request->contrato,
			'observacoes' => $request->observacoes
		]);
		SolicitacoesStatus::create([
			'status' => 'aberto',
			'usr_id_usuario_alteracao' => Auth::id(),
			'cre_id_solicitacoes' => $create->id
		]);

		Auth::user()->notify(new SolicitacaoContratoCliente($create));  
        $this->email->notify(new SolicitacaoContratoAdmin($create));

		Atividades::create([
			'nome' => 'Nova solicitação de contrato de crédito',
			'descricao' => 'Você efetuou uma solicitação do contrato, '.$create->RelationContratos->num_contrato.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.solicitacoes.credito'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Relatório da solicitação
    public function Relatorio($id){
        $dados = Solicitacoes::find($id);
        return view('credito.solicitacoes.relatorio')->with('requisicao', $dados);
    }

	// Imprimir a solicitação
	public function Remover($id){
		$dados = Solicitacoes::find($id);
		Atividades::create([
			'nome' => 'Exclusão de solicitação de contrato',
			'descricao' => 'Você removeu uma solicitação do contrato de crédito, '.$dados->RelationContratos->num_contrato.'.',
			'icone' => 'mdi-close',
			'url' => route('exibir.solicitacoes.credito'),
			'id_usuario' => Auth::id()
		]);
		SolicitacoesStatus::where('cre_id_solicitacoes', $id)->delete();
		Solicitacoes::find($id)->delete();
		return response()->json(['success' => true]);
	}

	// Alteração de status
	public function Alterar(Request $request){
		Atividades::create([
			'nome' => 'Alteração de estado de solicitação',
			'descricao' => 'Você alterou o status da solicitação de nº '.$request->id.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.setores.administrativo'),
			'id_usuario' => Auth::id()
		]);
		SolicitacoesStatus::create([
			'status' => $request->status,
			'usr_id_usuario_alteracao' => Auth::id(),
			'cre_id_solicitacoes' => $request->id
		]);

		$solicitacao = Solicitacoes::find($request->id);
		$solicitacao->RelationUsuarios->notify(new SolicitacaoContratoCliente($solicitacao));  
		return response()->json(['success' => true]);
	}

	// Retornado detalhes do contrato
	public function DetalhesContrato($id){
		$contrato = Contratos::find($id);
		return $contrato;
	}
}
