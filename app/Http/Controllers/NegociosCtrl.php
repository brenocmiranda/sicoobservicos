<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Associados;
use App\Models\ContaCapital;
use App\Models\NegociosCarteira;
use App\Models\NegociosCarteiraStatus;
use App\Models\Contratos;
use App\Models\Usuarios;

class NegociosCtrl extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Dashboard 
	#-------------------------------------------------------------------
	public function Dashboard(){
		return view('negocios.dashboard');
	}

	#-------------------------------------------------------------------
	# Análise 
	#-------------------------------------------------------------------
	// Listar todos os associados possíveis de análise
	public function ExibirAnalise(){
		if(Auth::user()->RelationFuncao->gerenciar_negocios == 1){
			return view('negocios.analise.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesAnalise(){
		if(Auth::user()->RelationFuncao->gerenciar_negocios == 1){
	        $dados = ContaCapital::leftJoin('cli_associados', 'cli_id_associado', 'cli_associados.id')
	        ->where('situacao_capital', '!=', 'DEMITIDO')
	        ->where('situacao_capital', '!=', 'EXCLUÍDO')
	        ->where('sigla', 'PF')
	        ->select('cli_id_associado', 'nome', 'documento', 'renda', 'nome_gerente', 'PA')
	        ->get();  
			foreach ($dados as $key => $value) {
				$carteira = NegociosCarteira::where('cli_id_associado', $value->cli_id_associado)->first();
				if(!isset($carteira) || $carteira->RelationStatus->status == 'aberto'){
					$dados[$key]->documento = (strlen($dados[$key]->documento) == 11 ? substr($dados[$key]->documento, 0, 3).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'-'.substr($dados[$key]->documento, 9, 2) : substr($dados[$key]->documento, 0, 2).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'/'.substr($dados[$key]->documento, 8, 4).'-'.substr($dados[$key]->documento, 12, 2));
					$dados[$key]->gerente = explode(' ', $dados[$key]->nome_gerente)[0];
					$dados[$key]->acoes = (isset($carteira) ? 
						'<a href="'.route('executar.analise.negocios', $dados[$key]->cli_id_associado).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="analisar" title="Analisar o associado"><i class="mx-0 mdi mdi-clipboard-outline"></i></a>
						<a href="javascript:" class="btn btn-dark btn-xs btn-rounded ml-1" id="encaminhar" title="Encaminhar o associado para análise"><i class="mx-0 mdi mdi-subdirectory-arrow-right"></i></a>' : 
						'<a href="'.route('executar.analise.negocios', $dados[$key]->cli_id_associado).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="analisar" title="Analisar o associado"><i class="mx-0 mdi mdi-clipboard-outline"></i></a>');
					$dados[$key]->analise = (isset($carteira) ? '<div class="badge badge-success">Em aberto</div>' : '<div class="badge badge-danger">Não possui</div>');
					$novo[] = $dados[$key];
				}
			}
			if(isset($novo)){
				return response()->json($novo);
			}else{
				return null;
			}
		}else{
			return redirect(route('403'));
		}
	}
	// Mostrar painel de análise
	public function ExecutarAnalise($id){
		if(Auth::user()->RelationFuncao->gerenciar_negocios == 1){
			$associado = Associados::find($id);
			$carteira =	NegociosCarteira::where('cli_id_associado', $id)->first();
			$usuarios = Usuarios::where('status', 'Ativo')->orderBy('login', 'ASC')->where('id','!=', 1)->where('id', '!=', Auth::id())->get();
			// Retornando os emprestimos e financiamentos ativos
			$emprestimos = Contratos::where('cli_id_associado', $id)->where('situacao', 'ENTRADA NORMAL')->get();
			$financiamento = 0;
			$emprestimoGeral = 0; 
			foreach($emprestimos as $emprestimo){
				if($emprestimo->RelationArquivos->RelationProdutos->codigo == 7){	
					if($emprestimo->RelationArquivos->RelationModalidades->codigo == 1018 || $emprestimo->RelationArquivos->RelationModalidades->codigo == 1024){
						 	$financiamento =+ $emprestimo->saldo_devedor;
					}else{
							$emprestimoGeral =+ $emprestimo->saldo_devedor;
					}
				}
			}	
			return view('negocios.analise.detalhes')->with('associado', $associado)->with('carteira', $carteira)->with('usuarios', $usuarios)->with('financiamento', $financiamento)->with('emprestimoGeral', $emprestimoGeral);
		}else{
			return redirect(route('403'));
		}
	}
	// Salvando análise
	public function SalvarAnalise(Request $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_negocios == 1){
			if($request->id_carteira){
				// Alterando dados salvos
				$update = NegociosCarteira::find($request->id_carteira)->update([
					'especial_atual' => str_replace(',', '.', str_replace('.', '', $request->especial_atual)), 
					'cartao_atual' => str_replace(',', '.', str_replace('.', '', $request->cartao_atual)),
					'emp_atual' => str_replace(',', '.', str_replace('.', '', $request->emp_atual)),
					'fin_atual' => str_replace(',', '.', str_replace('.', '', $request->fin_atual)),
					'svida_atual' => str_replace(',', '.', str_replace('.', '', $request->svida_atual)),
					'sgeral_atual' => str_replace(',', '.', str_replace('.', '', $request->sgeral_atual)),
					'consorcio_atual' => str_replace(',', '.', str_replace('.', '', $request->consorcio_atual)),
					'previdencia_atual' => str_replace(',', '.', str_replace('.', '', $request->previdencia_atual)),
					'especial_sugerido' => str_replace(',', '.', str_replace('.', '', $request->especial_sugerido)),
					'cartao_sugerido' => str_replace(',', '.', str_replace('.', '', $request->cartao_sugerido)),
					'emp_sugerido' => str_replace(',', '.', str_replace('.', '', $request->emp_sugerido)),
					'fin_sugerido' => str_replace(',', '.', str_replace('.', '', $request->fin_sugerido)),
					'svida_sugerido' => str_replace(',', '.', str_replace('.', '', $request->svida_sugerido)),
					'sgeral_sugerido' => str_replace(',', '.', str_replace('.', '', $request->sgeral_sugerido)),
					'consorcio_sugerido' => str_replace(',', '.', str_replace('.', '', $request->consorcio_sugerido)),
					'previdencia_sugerido' => str_replace(',', '.', str_replace('.', '', $request->previdencia_sugerido)),
					'bc_data' => $request->bc_data,
					'bc_consignados' => str_replace(',', '.', str_replace('.', '', $request->bc_consignados)),
					'bc_creditopessoal' => str_replace(',', '.', str_replace('.', '', $request->bc_creditopessoal)),
					'bc_chequeespecial' => str_replace(',', '.', str_replace('.', '', $request->bc_chequeespecial)),
					'bc_cartao' => str_replace(',', '.', str_replace('.', '', $request->bc_cartao)),
					'bc_financiamento' => str_replace(',', '.', str_replace('.', '', $request->bc_financiamento)),
					'bc_dividavencida' => $request->bc_dividavencida,
					'se_data' => $request->se_data,
					'se_restricao' => $request->se_restricao,
					'se_restricao_data' => implode(';', $request->se_restricao_data),
					'se_restricao_tipo' => implode(';', $request->se_restricao_tipo),
					'se_restricao_valor' => implode(';', $request->se_restricao_valor),
					'se_endereco' => $request->se_endereco,
					'se_telefone' => $request->se_telefone,
				]);
				// Salvando a análise do associado
				if($request->button == "salvar"){
					$status = NegociosCarteiraStatus::where('neg_id_carteira', $request->id_carteira)->where('status', 'aberto')->update([
						'status' => 'aberto', 
						'observacoes' => $request->observacoes,
						'usr_id_usuarios' => $request->usr_id_usuarios,
						'neg_id_carteira' => $request->id_carteira
					]);
				}else{
				// Encaminhando para um dos atendentes
					$status = NegociosCarteiraStatus::create([
						'status' => 'andamento', 
						'observacoes' => $request->observacoes,
						'usr_id_usuarios' => $request->usr_id_usuarios,
						'neg_id_carteira' => $request->id_carteira
					]);
				}	
			}else{
				// Criando carteira do associado
				$create = NegociosCarteira::create([
					'especial_atual' => str_replace(',', '.', str_replace('.', '', $request->especial_atual)), 
					'cartao_atual' => str_replace(',', '.', str_replace('.', '', $request->cartao_atual)),
					'emp_atual' => str_replace(',', '.', str_replace('.', '', $request->emp_atual)),
					'fin_atual' => str_replace(',', '.', str_replace('.', '', $request->fin_atual)),
					'svida_atual' => str_replace(',', '.', str_replace('.', '', $request->svida_atual)),
					'sgeral_atual' => str_replace(',', '.', str_replace('.', '', $request->sgeral_atual)),
					'consorcio_atual' => str_replace(',', '.', str_replace('.', '', $request->consorcio_atual)),
					'previdencia_atual' => str_replace(',', '.', str_replace('.', '', $request->previdencia_atual)),
					'especial_sugerido' => str_replace(',', '.', str_replace('.', '', $request->especial_sugerido)),
					'cartao_sugerido' => str_replace(',', '.', str_replace('.', '', $request->cartao_sugerido)),
					'emp_sugerido' => str_replace(',', '.', str_replace('.', '', $request->emp_sugerido)),
					'fin_sugerido' => str_replace(',', '.', str_replace('.', '', $request->fin_sugerido)),
					'svida_sugerido' => str_replace(',', '.', str_replace('.', '', $request->svida_sugerido)),
					'sgeral_sugerido' => str_replace(',', '.', str_replace('.', '', $request->sgeral_sugerido)),
					'consorcio_sugerido' => str_replace(',', '.', str_replace('.', '', $request->consorcio_sugerido)),
					'previdencia_sugerido' => str_replace(',', '.', str_replace('.', '', $request->previdencia_sugerido)),
					'bc_data' => $request->bc_data,
					'bc_consignados' => str_replace(',', '.', str_replace('.', '', $request->bc_consignados)),
					'bc_creditopessoal' => str_replace(',', '.', str_replace('.', '', $request->bc_creditopessoal)),
					'bc_chequeespecial' => str_replace(',', '.', str_replace('.', '', $request->bc_chequeespecial)),
					'bc_cartao' => str_replace(',', '.', str_replace('.', '', $request->bc_cartao)),
					'bc_financiamento' => str_replace(',', '.', str_replace('.', '', $request->bc_financiamento)),
					'bc_dividavencida' => $request->bc_dividavencida,
					'se_data' => $request->se_data,
					'se_restricao' => $request->se_restricao,
					'se_restricao_data' => implode(';', $request->se_restricao_data),
					'se_restricao_tipo' => implode(';', $request->se_restricao_tipo),
					'se_restricao_valor' => implode(';', $request->se_restricao_valor),
					'se_endereco' => $request->se_endereco,
					'se_telefone' => $request->se_telefone,
					'cli_id_associado' => $id,
				]);

				// Salvando apenas a análise
				if($request->button == "salvar"){
					$status = NegociosCarteiraStatus::create([
						'status' => 'aberto', 
						'observacoes' => $request->observacoes,
						'usr_id_usuarios' => $request->usr_id_usuarios,
						'neg_id_carteira' => $create->id
					]);
				}else{
				// Salvando e encaminhando a análise
					$status = NegociosCarteiraStatus::create([
						'status' => 'aberto', 
						'observacoes' => $request->observacoes,
						'usr_id_usuarios' => Auth::id(),
						'neg_id_carteira' => $create->id
					]);
					$status = NegociosCarteiraStatus::create([
						'status' => 'andamento', 
						'observacoes' => $request->observacoes,
						'usr_id_usuarios' => $request->usr_id_usuarios,
						'neg_id_carteira' => $create->id
					]);
				}	
			}
			return redirect(route('exibir.analise.negocios'));
		}else{
			return redirect(route('403'));
		}
	}
	// Encaminhando para tratamento
	public function EncaminharAnalise($id){
		if(Auth::user()->RelationFuncao->gerenciar_negocios == 1){
			$dados = NegociosCarteira::where('cli_id_associado', $id)->first();
				// Encaminhando registro
			if($dados->RelationStatus->status == "aberto"){
				NegociosCarteiraStatus::create([
					'status' => 'andamento', 
					'observacoes' => $dados->RelationStatus->observacoes,
					'usr_id_usuarios' => $dados->RelationStatus->usr_id_usuarios,
					'neg_id_carteira' => $dados->id,
				]);
				return response()->json(['success' => true]);
			}else{
				return response()->json(['success' => false]);
			}
		}else{
			return redirect(route('403'));
		}
	}

	#-------------------------------------------------------------------
	# Carteira dos colaboradores 
	#-------------------------------------------------------------------
	// Listando associados da carteira
	public function ExibirCarteira(){
		return view('negocios.carteira.listar');
	}
	public function DatatablesCarteira(){
		$dados = NegociosCarteira::all();
		foreach ($dados as $key => $value) {
			if($dados[$key]->RelationStatus->status == "andamento" && $dados[$key]->RelationStatus->usr_id_usuarios == Auth::id()){
				$dados[$key]->documento1 = (strlen($dados[$key]->RelationAssociado->documento) == 11 ? substr($dados[$key]->RelationAssociado->documento, 0, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 3, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 6, 3).'-'.substr($dados[$key]->RelationAssociado->documento, 9, 2) : substr($dados[$key]->RelationAssociado->documento, 0, 2).'.'.substr($dados[$key]->RelationAssociado->documento, 3, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 6, 3).'/'.substr($dados[$key]->RelationAssociado->documento, 8, 4).'-'.substr($dados[$key]->RelationAssociado->documento, 12, 2));
				$dados[$key]->nome = $dados[$key]->RelationAssociado->nome;
				$dados[$key]->nome_gerente = $dados[$key]->RelationAssociado->nome_gerente;
				$dados[$key]->PA = $dados[$key]->RelationAssociado->PA;
				$dados[$key]->acoes = '<a href="'.route('executar.carteira.negocios', $dados[$key]->cli_id_associado).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="analisar" title="Tratar o associado"><i class="mx-0 mdi mdi-headset"></i></a><a href="javascript:" class="btn btn-dark btn-xs btn-rounded ml-1" id="devolver" title="Devolver associado para análise"><i class="mx-0 mdi mdi-subdirectory-arrow-left"></i></a>';
				$dados[$key]->status1 = '<div class="badge badge-info">Em andamento</div>';
				$novo[] = $dados[$key];
			}
		}
		if(isset($novo)){
			return response()->json($novo);
		}else{
			return null;
		}
	}
	// Exibindo painel de tratamento 
	public function ExecutarCarteira($id){
		$associado = Associados::find($id);
		$carteira =	NegociosCarteira::where('cli_id_associado', $id)->first();
		if($carteira->RelationStatus->status == "andamento"){
			return view('negocios.carteira.detalhes')->with('associado', $associado)->with('carteira', $carteira);
		}else{
			return redirect(route('exibir.carteira.negocios'));
		}
	}
		// Salvando análise
	public function SalvarCarteira(Request $request){
		$dados = NegociosCarteira::find($request->id_carteira);
		if($dados->RelationStatus->status == "andamento"){
			$status = NegociosCarteiraStatus::create([
				'status' => 'finalizado', 
				'observacoes' => $request->observacoes,
				'usr_id_usuarios' => Auth::id(),
				'neg_id_carteira' => $request->id_carteira
			]);
			return redirect(route('exibir.carteira.negocios'));
		}else{
			\Session::flash('error', array(
				'class' => 'danger',
				'mensagem' => 'Opsss! O estado desse associado já foi alterado.'
			));
			return redirect(route('exibir.carteira.negocios'));
		}
	}
	// Encaminhando para tratamento
	public function DevolverCarteira($id){
		$dados = NegociosCarteira::where('cli_id_associado', $id)->first();
		// Encaminhando registro
		if($dados->RelationStatus->status == "andamento"){
			NegociosCarteiraStatus::create([
				'status' => 'aberto', 
				'observacoes' => $dados->RelationStatus->observacoes,
				'usr_id_usuarios' => Auth::id(),
				'neg_id_carteira' => $dados->id,
			]);
			return response()->json(['success' => true]);
		}else{
			return response()->json(['success' => false]);
		}
	}

	#-------------------------------------------------------------------
	# Acompanhamento 
	#-------------------------------------------------------------------
	public function ExibirAcompanhamento(){
		return view('negocios.acompanhamento.listar');
	}
	public function DatatablesAcompanhamento(){
		$dados = NegociosCarteira::all();
		foreach ($dados as $key => $value) {
			$dados[$key]->documento1 = (strlen($dados[$key]->RelationAssociado->documento) == 11 ? substr($dados[$key]->RelationAssociado->documento, 0, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 3, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 6, 3).'-'.substr($dados[$key]->RelationAssociado->documento, 9, 2) : substr($dados[$key]->RelationAssociado->documento, 0, 2).'.'.substr($dados[$key]->RelationAssociado->documento, 3, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 6, 3).'/'.substr($dados[$key]->RelationAssociado->documento, 8, 4).'-'.substr($dados[$key]->RelationAssociado->documento, 12, 2));
			$dados[$key]->nome = $dados[$key]->RelationAssociado->nome;
			$dados[$key]->colaborador = $dados[$key]->RelationStatus->RelationUsuario->RelationAssociado->nome;
			$dados[$key]->data = date('d/m/Y', strtotime($dados[$key]->RelationStatus->created_at));
			$dados[$key]->acoes = '<a href="#" class="btn btn-dark btn-xs btn-rounded mx-1" id="detalhes" title="Detalhes do associado"><i class="mx-0 mdi mdi-headset"></i></a>
			<a href="javascript:" class="btn btn-dark btn-xs btn-rounded ml-1" id="devolver" title="Devolver associado para análise"><i class="mx-0 mdi mdi-subdirectory-arrow-left"></i></a>';
			$dados[$key]->status1 = ($dados[$key]->RelationStatus->status == 'aberto' ? '<div class="badge badge-success">Em aberto</div>' : ($dados[$key]->RelationStatus->status == 'andamento' ? '<div class="badge badge-info">Em andamento</div>' : '<div class="badge badge-danger">Finalizado</div>'));
		}
		return response()->json($dados);
	}

	#-------------------------------------------------------------------
	# Relatórios 
	#-------------------------------------------------------------------
	public function ExibirRelatorios(){
		return view('negocios.analise.listar');
	}

}
