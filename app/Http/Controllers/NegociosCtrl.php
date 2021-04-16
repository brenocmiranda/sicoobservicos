<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Associados;
use App\Models\AssociadosConglomerados;
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
	        $dados = DB::select("SELECT (SELECT status FROM neg_carteira_status where neg_id_carteira = neg_carteira.id ORDER BY neg_carteira_status.created_at DESC LIMIT 1) as statusCarteira, cca_contacapital.cli_id_associado, nome, documento, renda, nome_gerente, PA FROM cca_contacapital LEFT JOIN cli_associados ON cca_contacapital.cli_id_associado = cli_associados.id LEFT JOIN neg_carteira ON cca_contacapital.cli_id_associado = neg_carteira.cli_id_associado WHERE situacao_capital != 'DEMITIDO' AND situacao_capital != 'EXCLUÍDO' AND sigla = 'PF'");
			foreach ($dados as $key => $value) {
				if(!isset($dados[$key]->statusCarteira) || $dados[$key]->statusCarteira == 'aberto'){
					$dados[$key]->documento = (strlen($dados[$key]->documento) == 11 ? substr($dados[$key]->documento, 0, 3).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'-'.substr($dados[$key]->documento, 9, 2) : substr($dados[$key]->documento, 0, 2).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'/'.substr($dados[$key]->documento, 8, 4).'-'.substr($dados[$key]->documento, 12, 2));
					$dados[$key]->gerente = explode(' ', $dados[$key]->nome_gerente)[0];
					$dados[$key]->acoes = (isset($dados[$key]->statusCarteira) ? 
						'<a href="'.route('executar.analise.negocios', $dados[$key]->cli_id_associado).'" class="btn btn-dark btn-xs btn-rounded m-1" id="analisar" title="Analisar o associado"><i class="mx-0 mdi mdi-clipboard-outline"></i></a>
						<a href="javascript:" class="btn btn-dark btn-xs btn-rounded m-1" id="remover" title="Remover o associado da análise"><i class="mx-0 mdi mdi-account-remove"></i></a>
						<a href="javascript:" class="btn btn-dark btn-xs btn-rounded m-1" id="encaminhar" title="Encaminhar o associado para análise"><i class="mx-0 mdi mdi-subdirectory-arrow-right"></i></a>' : 
						'<a href="'.route('executar.analise.negocios', $dados[$key]->cli_id_associado).'" class="btn btn-dark btn-xs btn-rounded m-1" id="analisar" title="Analisar o associado"><i class="mx-0 mdi mdi-clipboard-outline"></i></a>
						<a href="javascript:" class="btn btn-dark btn-xs btn-rounded m-1" id="remover" title="Remover o associado da análise"><i class="mx-0 mdi mdi-account-remove"></i></a>');
					$dados[$key]->status = (isset($dados[$key]->statusCarteira) ? '<div class="badge badge-success">Em aberto</div>' : '<div class="badge badge-danger">Não possui</div>');
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
						 	$financiamento =+ $emprestimo->valor_devido;
					}else{
							$emprestimoGeral =+ $emprestimo->valor_devido;
					}
				}
			}	
			if($associado->RelationConglomerados){
  				$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
	  		}else{
	  			$conglomerado = null;
	  		}
			return view('negocios.analise.detalhes')->with('associado', $associado)->with('carteira', $carteira)->with('usuarios', $usuarios)->with('financiamento', $financiamento)->with('emprestimoGeral', $emprestimoGeral)->with('conglomerado', $conglomerado);
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
					'se_restricao_data' => (isset($request->se_restricao_data) ? implode(';', $request->se_restricao_data) : null),
					'se_restricao_tipo' => (isset($request->se_restricao_tipo) ? implode(';', $request->se_restricao_tipo) : null),
					'se_restricao_valor' => (isset($request->se_restricao_valor) ? implode(';', $request->se_restricao_valor) : null),
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
					$associado = Associados::find($id);
					Atividades::create([
						'nome' => 'Você executou uma análise',
						'descricao' => 'Você realizou o cadastrado de uma análise do associado: '.$associado->nome.'.',
						'icone' => 'mdi-clipboard-outline',
						'url' => 'javascript:',
						'id_usuario' => Auth::id()
					]);
				}else{
					// Encaminhando para um dos atendentes
					$status = NegociosCarteiraStatus::create([
						'status' => 'andamento', 
						'observacoes' => $request->observacoes,
						'usr_id_usuarios' => $request->usr_id_usuarios,
						'neg_id_carteira' => $request->id_carteira
					]);
					$associado = Associados::find($id);
					Atividades::create([
						'nome' => 'Você encaminhou a análise para tratamento',
						'descricao' => 'Você encaminhou a análise de '.$associado->nome.' para tratamento.',
						'icone' => 'mdi-subdirectory-arrow-right',
						'url' => 'javascript:',
						'id_usuario' => Auth::id()
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
					'se_restricao_data' => (isset($request->se_restricao_data) ? implode(';', $request->se_restricao_data) : null),
					'se_restricao_tipo' => (isset($request->se_restricao_tipo) ? implode(';', $request->se_restricao_tipo) : null),
					'se_restricao_valor' => (isset($request->se_restricao_valor) ? implode(';', $request->se_restricao_valor) : null),
					'se_endereco' => $request->se_endereco,
					'se_telefone' => $request->se_telefone,
					'cli_id_associado' => $id,
				]);

				if($request->button == "salvar"){
					// Salvando apenas a análise
					$status = NegociosCarteiraStatus::create([
						'status' => 'aberto', 
						'observacoes' => $request->observacoes,
						'usr_id_usuarios' => $request->usr_id_usuarios,
						'neg_id_carteira' => $create->id
					]);
					$associado = Associados::find($id);
					Atividades::create([
						'nome' => 'Você executou uma análise',
						'descricao' => 'Você realizou o cadastrado de uma análise do associado: '.$associado->nome.'.',
						'icone' => 'mdi-clipboard-outline',
						'url' => 'javascript:',
						'id_usuario' => Auth::id()
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
						'observacoes' => '',
						'usr_id_usuarios' => $request->usr_id_usuarios,
						'neg_id_carteira' => $create->id,
						'created_at' => now()->addSeconds(20)
					]);
					$associado = Associados::find($id);
					Atividades::create([
						'nome' => 'Você executou uma análise',
						'descricao' => 'Você realizou o cadastrado de uma análise do associado: '.$associado->nome.'.',
						'icone' => 'mdi-clipboard-outline',
						'url' => 'javascript:',
						'id_usuario' => Auth::id()
					]);
					Atividades::create([
						'nome' => 'Você encaminhou a análise para tratamento',
						'descricao' => 'Você encaminhou a análise de '.$associado->nome.' para tratamento.',
						'icone' => 'mdi-subdirectory-arrow-right',
						'url' => 'javascript:',
						'id_usuario' => Auth::id()
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
					'observacoes' => '',
					'usr_id_usuarios' => $dados->RelationStatus->usr_id_usuarios,
					'neg_id_carteira' => $dados->id,
				]);
				$associado = Associados::find($dados->cli_id_associado);
				Atividades::create([
					'nome' => 'Você encaminhou a análise para tratamento',
					'descricao' => 'Você encaminhou a análise de '.$associado->nome.' para tratamento.',
					'icone' => 'mdi-subdirectory-arrow-right',
					'url' => 'javascript:',
					'id_usuario' => Auth::id()
				]);
				return response()->json(['success' => true]);
			}else{
				return response()->json(['success' => false]);
			}
		}else{
			return redirect(route('403'));
		}
	}
	// Não executar contato
	public function RemoverAnalise(Request $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_negocios == 1){
			// Criando portfólio 
			$create = NegociosCarteira::create([
				'especial_atual' => '0.00', 
				'cartao_atual' =>  '0.00',
				'emp_atual' =>  '0.00',
				'fin_atual' =>  '0.00',
				'svida_atual' =>  '0.00',
				'sgeral_atual' =>  '0.00',
				'consorcio_atual' =>  '0.00',
				'previdencia_atual' =>  '0.00',
				'especial_sugerido' =>  '0.00',
				'cartao_sugerido' =>  '0.00',
				'emp_sugerido' =>  '0.00',
				'fin_sugerido' => '0.00',
				'svida_sugerido' =>'0.00',
				'sgeral_sugerido' => '0.00',
				'consorcio_sugerido' => '0.00',
				'previdencia_sugerido' => '0.00',
				'bc_data' => null,
				'bc_consignados' => '0.00',
				'bc_creditopessoal' => '0.00',
				'bc_chequeespecial' => '0.00',
				'bc_cartao' => '0.00',
				'bc_financiamento' => '0.00',
				'bc_dividavencida' => null,
				'se_data' => null,
				'se_restricao' => null,
				'se_restricao_data' => null,
				'se_restricao_tipo' => null,
				'se_restricao_valor' => null,
				'se_endereco' => null,
				'se_telefone' => null,
				'cli_id_associado' => $id,
			]);
			// Encaminhando registro
			NegociosCarteiraStatus::create([
				'status' => 'excecao', 
				'observacoes' => $request->observacoes,
				'usr_id_usuarios' => Auth::id(),
				'neg_id_carteira' => $create->id,
			]);
			$associado = Associados::find($id);
			Atividades::create([
				'nome' => 'Você excluir um associado da análise',
				'descricao' => 'Você removeu o associado '.$associado->nome.' do processo de análise.',
				'icone' => 'mdi-account-remove',
				'url' => 'javascript:',
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
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
				$dados[$key]->nome_gerente = explode(' ', $dados[$key]->RelationAssociado->nome_gerente)[0];
				$dados[$key]->data = date('d/m/Y', strtotime($dados[$key]->RelationStatus->created_at));
				$dados[$key]->acoes = '<a href="'.route('executar.carteira.negocios', $dados[$key]->cli_id_associado).'" class="btn btn-dark btn-xs btn-rounded m-1" id="analisar" title="Tratar o associado"><i class="mx-0 mdi mdi-headset"></i></a><a href="javascript:" class="btn btn-dark btn-xs btn-rounded m-1" id="devolver" title="Devolver associado para análise"><i class="mx-0 mdi mdi-subdirectory-arrow-left"></i></a>';
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
		if($associado->RelationConglomerados){
				$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
  		}else{
  			$conglomerado = null;
  		}
		if($carteira->RelationStatus->status == "andamento"){
			return view('negocios.carteira.detalhes')->with('associado', $associado)->with('carteira', $carteira)->with('conglomerado', $conglomerado);
		}else{
			return redirect(route('exibir.carteira.negocios'));
		}
	}
	// Salvando tratamento efetuado
	public function SalvarCarteira(Request $request){
		$dados = NegociosCarteira::find($request->id_carteira);
		if($dados->RelationStatus->status == "andamento"){
			$status = NegociosCarteiraStatus::create([
				'status' => 'finalizado', 
				'observacoes' => $request->observacoes,
				'usr_id_usuarios' => Auth::id(),
				'neg_id_carteira' => $request->id_carteira
			]);
			$associado = Associados::find($dados->cli_id_associado);
			Atividades::create([
				'nome' => 'Você executou um tratamento',
				'descricao' => 'Você tratou a análise do associado: '.$associado->nome.'.',
				'icone' => 'mdi-headset',
				'url' => 'javascript:',
				'id_usuario' => Auth::id()
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
				'neg_id_carteira' => $dados->id
			]);
			$associado = Associados::find($dados->cli_id_associado);
			Atividades::create([
				'nome' => 'Você devolveu a análise para correções',
				'descricao' => 'Você devolveu a análise de '.$associado->nome.' para alterações.',
				'icone' => 'mdi-subdirectory-arrow-right',
				'url' => 'javascript:',
				'id_usuario' => Auth::id()
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
		$dados = NegociosCarteira::orderBy('updated_at', 'DESC')->get();
		foreach ($dados as $key => $value) {
			$dados[$key]->documento1 = (strlen($dados[$key]->RelationAssociado->documento) == 11 ? substr($dados[$key]->RelationAssociado->documento, 0, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 3, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 6, 3).'-'.substr($dados[$key]->RelationAssociado->documento, 9, 2) : substr($dados[$key]->RelationAssociado->documento, 0, 2).'.'.substr($dados[$key]->RelationAssociado->documento, 3, 3).'.'.substr($dados[$key]->RelationAssociado->documento, 6, 3).'/'.substr($dados[$key]->RelationAssociado->documento, 8, 4).'-'.substr($dados[$key]->RelationAssociado->documento, 12, 2));
			$dados[$key]->nome = $dados[$key]->RelationAssociado->nome;
			$dados[$key]->colaborador = explode(' ', $dados[$key]->RelationStatus->RelationUsuario->RelationAssociado->nome)[0];
			$dados[$key]->data = date('d/m/Y H:i', strtotime($dados[$key]->RelationStatus->created_at));
			$dados[$key]->acoes = '<a href="'.route('executar.acompanhamento.negocios', $dados[$key]->RelationAssociado->id).'" class="btn btn-dark btn-xs btn-rounded m-1" id="detalhes" title="Detalhes da análise"><i class="mx-0 mdi mdi-account-outline"></i></a>
			<a href="javascript:" class="btn btn-dark btn-xs btn-rounded mr-1" id="alterar" title="Alterar estado do registro"><i class="mx-0 mdi mdi-autorenew"></i></a><a href="javascript:" class="btn btn-dark btn-xs btn-rounded m-1" id="alterar" title="Imprimir relatório da análise estado do registro"><i class="mx-0 mdi mdi-printer"></i></a>';
			$dados[$key]->status1 = ($dados[$key]->RelationStatus->status == 'aberto' ? '<div class="badge badge-success">Em aberto</div>' : ($dados[$key]->RelationStatus->status == 'andamento' ? '<div class="badge badge-info">Em andamento</div>' : ($dados[$key]->RelationStatus->status == 'excecao' ? '<div class="badge badge-warning">Não contatar</div>' : '<div class="badge badge-danger">Finalizado</div>')));
		}
		return response()->json($dados);
	}
	// Exibindo painel de acompanhamento 
	public function ExecutarAcompanhamento($id){
		$associado = Associados::find($id);
		$carteira =	NegociosCarteira::where('cli_id_associado', $id)->first();
		if($associado->RelationConglomerados){
				$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
  		}else{
  			$conglomerado = null;
  		}
		return view('negocios.acompanhamento.detalhes')->with('associado', $associado)->with('carteira', $carteira)->with('conglomerado', $conglomerado);
	}
	// Alterar estado do acompanhamento
	public function AlterarAcompanhamento(Request $request, $id){
		$status = NegociosCarteiraStatus::where('neg_id_carteira', $id)->where('status', $request->status)->get();
		if(isset($status[0])){
			NegociosCarteiraStatus::where('neg_id_carteira', $id)->where('status', $request->status)->update(['created_at' => now()]);
		}else{
			NegociosCarteiraStatus::create([
				'status' => $request->status, 
				'observacoes' => null,
				'usr_id_usuarios' => Auth::id(),
				'neg_id_carteira' => $id
			]);
		}	
		return response()->json(['success' => true]);
	}
	// Exibindo painel de acompanhamento 
	public function RelatorioAcompanhamento($id){
		$associado = Associados::find($id);
		$carteira =	NegociosCarteira::where('cli_id_associado', $id)->first();
		if($associado->RelationConglomerados){
				$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
  		}else{
  			$conglomerado = null;
  		}
		return view('negocios.acompanhamento.detalhes')->with('associado', $associado)->with('carteira', $carteira)->with('conglomerado', $conglomerado);
	}

	#-------------------------------------------------------------------
	# Relatórios 
	#-------------------------------------------------------------------
	public function ExibirRelatorios(){
		return view('negocios.analise.listar');
	}

}
