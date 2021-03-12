<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Associados;
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
		return view('negocios.analise.listar');
	}
	public function DatatablesAnalise(){
		$dados = Associados::rightjoin('cca_contacapital', 'cli_associados.id', 'cli_id_associado')->where('sigla', 'PF')->where('situacao_capital', '!=', 'DEMITIDO')->where('situacao_capital', '!=', 'EXCLUÍDO')->select('cli_associados.id', 'nome', 'documento', 'renda', 'nome_gerente', 'PA')->orderBy('nome', 'ASC')->get();
		foreach ($dados as $key => $value) {
			$dados[$key]->analise = (isset($dados[$key]->RelationCarteiraNegocios) ? '<i class="mdi mdi-check text-success"></i>' : '<i class="mdi mdi-close text-danger"></i>');
			$dados[$key]->documento1 = (strlen($dados[$key]->documento) == 11 ? substr($dados[$key]->documento, 0, 3).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'-'.substr($dados[$key]->documento, 9, 2) : substr($dados[$key]->documento, 0, 2).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'/'.substr($dados[$key]->documento, 8, 4).'-'.substr($dados[$key]->documento, 12, 2));
			$dados[$key]->acoes = '<a href="'.route('executar.analise.negocios', $dados[$key]->id).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="analisar" title="Analisar o associado"><i class="mx-0 mdi mdi-clipboard-outline"></i></a>';
		}
		return response()->json($dados);
	}
	// Mostrar painel de análise
	public function ExecutarAnalise($id){
		$dados = Associados::find($id);
		$usuarios = Usuarios::where('status', 'Ativo')->orderBy('login', 'ASC')->get();
		// Retornando os emprestimos e financiamentos ativos
		$emprestimos = Contratos::where('cli_id_associado', $id)->where('situacao', 'ENTRADA NORMAL')->get();
		$financiamento = 0;
		$emprestimoGeral = 0; 
		foreach($emprestimos as $emprestimo){
			if($emprestimo->RelationArquivos->RelationProdutos->codigo == 7){	
				if($emprestimo->RelationArquivos->RelationModalidades->codigo == 1018 || $emprestimo->RelationArquivos->RelationModalidades->codigo == 1024){
					 	$financiamento =+ $emprestimo->valor_contrato;
				}else{
						$emprestimoGeral =+ $emprestimo->valor_contrato;
				}
			}
		}	
		return view('negocios.analise.detalhes')->with('dados', $dados)->with('usuarios', $usuarios)->with('financiamento', $financiamento)->with('emprestimoGeral', $emprestimoGeral);
	}
	// Salvando análise
	public function SalvarAnalise(Request $request, $id){
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
			'se_endereco' => $request->se_endereco,
			'se_telefone' => $request->se_telefone,
			'cli_id_associado' => $id,
		]);

		if($request->button == "salvar"){
			$status = NegociosCarteiraStatus::create([
				'status' => 'aberto', 
				'observacoes' => $request->observacoes,
				'usr_id_usuarios' => Auth::id(),
				'neg_id_carteira' => $create->id
			]);
		}else{
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

		return redirect(route('exibir.analise.negocios'));
	}
	

	#-------------------------------------------------------------------
	# Carteira dos colaboradores 
	#-------------------------------------------------------------------
	public function ExibirCarteira(){
		return view('negocios.analise.exibir');
	}

	#-------------------------------------------------------------------
	# Acompanhamento 
	#-------------------------------------------------------------------
	public function ExibirAcompanhamento(){
		return view('negocios.analise.exibir');
	}

	#-------------------------------------------------------------------
	# Relatórios 
	#-------------------------------------------------------------------
	public function ExibirRelatorios(){
		return view('negocios.analise.exibir');
	}

}
