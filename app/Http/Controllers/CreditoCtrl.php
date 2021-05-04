<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Notifications\SolicitacaoContratoAdmin;
use App\Notifications\SolicitacaoContratoCliente;
use App\Notifications\Fampe;
use App\Http\Requests\ArmariosRqt;
use App\Http\Requests\ModalidadesRqt;
use App\Http\Requests\ProdutosCredRqt;
use App\Models\Armarios;
use App\Models\Associados;
use App\Models\Contratos;
use App\Models\ContratosAvalistas;
use App\Models\ContratosGarantias;
use App\Models\ContratosModalidades;
use App\Models\ContratosProdutos;
use App\Models\ContratosSolicitacoes;
use App\Models\ContratosSolicitacoesStatus;
use App\Models\Atividades;
use App\Models\Ativos;
use App\Models\Chamados;
use App\Models\Usuarios;
use App\Models\CogEmailsContrato;

class CreditoCtrl extends Controller
{

	public function __construct(){
		$this->email = CogEmailsContrato::first();
		$this->middleware('auth');
	}
	#-------------------------------------------------------------------
	# Dashboard
	#-------------------------------------------------------------------
	public function Dashboard(){
		$ativos = Ativos::all();
		$chamados = Chamados::all();
		$homepage = Chamados::all();
		return view('credito.dashboard')->with('ativos', $ativos)->with('homepage', $homepage)->with('chamados', json_encode($chamados));
	}

	#-------------------------------------------------------------------
	# Disposição
	#-------------------------------------------------------------------
	// Exibindo a disposição atual
	public function Disposicao(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$produtos = ContratosProdutos::where('status', 1)->get(); 
			$modalidades = ContratosModalidades::where('status', 1)->get(); 
			$armarios = ContratosArmarios::where('status', 1)->orderBy('referencia')->get(); 
			return view('credito.disposicao.listar')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades);
		}else{
			return redirect(route('403'));
		}
	}
	// Listando os contratos da gaveta
	public function ExibirDisposicao($id){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$arm = ContratosArmarios::find($id); 
			$armarios = ContratosArmarios::where('status', 1)->get(); 
			$produtos = ContratosProdutos::where('status', 1)->get(); 
			$modalidades = ContratosModalidades::where('status', 1)->get();
			return view('credito.disposicao.gaveta')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades)->with('arm', $arm);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesDisposicao(Request $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$dados = Contratos::where('cre_id_armarios', $id)->get();
			foreach ($dados as $key => $value) {
				$dados[$key]->acoes = "
				<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>
				<button class='btn btn-dark btn-xs btn-rounded mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
				$dados[$key]->status1 = '<label class="badge'.($dados[$key]->status == "vigente" ? " badge-success" : ($dados[$key]->status == 'quitado' ? " badge-danger" : " badge-warning" )).'">'.($dados[$key]->status == "vigente" ? "Vigente" : ($dados[$key]->status == 'quitado' ? "Quitado" : "Prejuízo" )).'</label>';
				$dados[$key]->valor_contrato = number_format($dados[$key]->valor_contrato, 2, ',', '.');
				$dados[$key]->valor_contrato1 = 'R$ '.$dados[$key]->valor_contrato;
				$dados[$key]->produto = $dados[$key]->RelationProdutos;
				$dados[$key]->modalidade = $dados[$key]->RelationModalidades;
				$dados[$key]->finalidade = $dados[$key]->RelationFinalidades;
				$dados[$key]->associado = $dados[$key]->RelationAssociados;
				$dados[$key]->armario = $dados[$key]->RelationArmarios;
				$dados[$key]->taxa_operacao = number_format($dados[$key]->taxa_operacao, 2, ',', '');
				$dados[$key]->taxa_mora = number_format($dados[$key]->taxa_mora, 2, ',', '');
				$dados[$key]->taxa_multa = number_format($dados[$key]->taxa_multa, 2, ',', '');
			}
			return response()->json($dados);
		}else{
			$dados = Contratos::where('cre_id_armarios', $id)->get();
			foreach ($dados as $key => $value) {
				$dados[$key]->acoes = '';
				$dados[$key]->status1 = '<label class="badge'.($dados[$key]->status == "vigente" ? " badge-success" : ($dados[$key]->status == 'quitado' ? " badge-danger" : " badge-warning" )).'">'.($dados[$key]->status == "vigente" ? "Vigente" : ($dados[$key]->status == 'quitado' ? "Quitado" : "Prejuízo" )).'</label>';
				$dados[$key]->valor_contrato = number_format($dados[$key]->valor_contrato, 2, ',', '.');
				$dados[$key]->valor_contrato1 = 'R$ '.$dados[$key]->valor_contrato;
				$dados[$key]->produto = $dados[$key]->RelationProdutos;
				$dados[$key]->modalidade = $dados[$key]->RelationModalidades;
				$dados[$key]->finalidade = $dados[$key]->RelationFinalidades;
				$dados[$key]->associado = $dados[$key]->RelationAssociados;
				$dados[$key]->armario = $dados[$key]->RelationArmarios;
				$dados[$key]->taxa_operacao = number_format($dados[$key]->taxa_operacao, 2, ',', '');
				$dados[$key]->taxa_mora = number_format($dados[$key]->taxa_mora, 2, ',', '');
				$dados[$key]->taxa_multa = number_format($dados[$key]->taxa_multa, 2, ',', '');
			}
			return response()->json($dados);
		}
	}

	#-------------------------------------------------------------------
	# Contratos
	#-------------------------------------------------------------------
	// Exibindo status e fazendo a pesquisa
	public function Contratos(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$armarios = ContratosArmarios::where('status', 1)->orderBy('referencia', 'ASC')->get(); 
			$produtos = ContratosProdutosCred::where('status', 1)->orderBy('nome', 'ASC')->get(); 
			$modalidades = ContratosModalidades::where('status', 1)->orderBy('nome', 'ASC')->get();
			return view('credito.contratos.geral')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades);
		}else{
			return redirect(route('403'));
		}
	}
	public function Pesquisar(Request $request){
		$dados = Contratos::leftjoin('cli_associados', 'cli_id_associado', 'cli_associados.id')->leftJoin('cre_modalidades', 'cre_id_modalidades', 'cre_modalidades.id')->where('cli_associados.nome', 'LIKE', '%'.$request->pesquisar.'%')->orWhere('num_contrato', 'LIKE', '%'.$request->pesquisar.'%')->orWhere('cre_modalidades.nome', 'LIKE', '%'.$request->pesquisar.'%')->orWhere('cre_contratos.status', 'LIKE', '%'.$request->pesquisar.'%')->select('cre_contratos.*')->get();

		foreach ($dados as $key => $value){
			if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
				$dados[$key]->acoes =  "<div class='row mx-auto'>
				<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>
				<button class='btn btn-dark btn-xs btn-rounded mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button></div>";
			}else{
				$dados[$key]->acoes =  "";
			}
			$dados[$key]->status1 = '<label class="badge'.($dados[$key]->status == 'vigente' ? " badge-success" : ($dados[$key]->status == 'quitado' ? " badge-danger" : " badge-warning" )).'">'.($dados[$key]->status == 'vigente' ? "Vigente" : ($dados[$key]->status == 'quitado' ? "Quitado" : "Prejuízo" )).'</label>';
			$dados[$key]->valor_contrato = number_format($dados[$key]->valor_contrato, 2, ',', '.');
			$dados[$key]->valor_contrato1 = 'R$ '.$dados[$key]->valor_contrato;
			$dados[$key]->produto = $dados[$key]->RelationProdutos;
			$dados[$key]->modalidade = $dados[$key]->RelationModalidades;
			$dados[$key]->finalidade = $dados[$key]->RelationFinalidades;
			$dados[$key]->associado = $dados[$key]->RelationAssociados;
			$dados[$key]->armario = $dados[$key]->RelationArmarios;
			$dados[$key]->taxa_operacao = number_format($dados[$key]->taxa_operacao, 2, ',', '');
			$dados[$key]->taxa_mora = number_format($dados[$key]->taxa_mora, 2, ',', '');
			$dados[$key]->taxa_multa = number_format($dados[$key]->taxa_multa, 2, ',', '');
		}
		return response()->json($dados);
	}
	// Listando por status
	public function Exibir(Request $request){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$armarios = ContratosArmarios::where('status', 1)->orderBy('referencia', 'ASC')->get(); 
			$produtos = ContratosProdutos::where('status', 1)->get(); 
			$modalidades = ContratosModalidades::where('status', 1)->get();  
			return view('credito.contratos.'.$request->segment(4).'.listar')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades);
		}else{
			return redirect(route('403'));
		}
	}
	public function Datatables(Request $request){
		$dados = Contratos::where('cre_contratos.status', $request->segment(4))->get();
		foreach ($dados as $key => $value) {
			if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
				$dados[$key]->acoes = "
				<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>
				<button class='btn btn-dark btn-xs btn-rounded mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
			}else{
				$dados[$key]->acoes =  "";
			}
			$dados[$key]->valor_contrato = number_format($dados[$key]->valor_contrato, 2, ',', '.');
			$dados[$key]->valor_contrato1 = 'R$ '.$dados[$key]->valor_contrato;
			$dados[$key]->produto = $dados[$key]->RelationProdutos;
			$dados[$key]->modalidade = $dados[$key]->RelationModalidades;
			$dados[$key]->finalidade = $dados[$key]->RelationFinalidades;
			$dados[$key]->associado = $dados[$key]->RelationAssociados;
			$dados[$key]->armario = $dados[$key]->RelationArmarios;
			$dados[$key]->taxa_operacao = number_format($dados[$key]->taxa_operacao, 2, ',', '');
			$dados[$key]->taxa_mora = number_format($dados[$key]->taxa_mora, 2, ',', '');
			$dados[$key]->taxa_multa = number_format($dados[$key]->taxa_multa, 2, ',', '');
		}
		return response()->json($dados);
	}
	// Adicionando novo contrato
	public function Adicionar(Request $request){
		// Retornando dados do associado
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$documento = explode(': ', $request->cli_id_associado);
			$associado = Associados::where('documento', $documento[1])->select('id')->first();
			// Inserindo dados do contrato
			$contrato = Contratos::create([
				'num_contrato' => $request->num_contrato, 
				'status' => $request->status, 
				'data_operacao' => $request->data_operacao, 
				'data_vencimento' => $request->data_vencimento, 
				'valor_contrato' => str_replace(',', '.', str_replace('.', '', $request->valor_contrato)),
				'renegociacao' => (isset($request->renegociacao) ? 1 : 0),
				'renegociacao_contrato' => (isset($request->renegociacao_contrato) ? $request->renegociacao_contrato : NULL), 
				'observacoes' => (isset($request->observacoes) ? $request->observacoes : NULL), 
				'cli_id_associado' => $associado->id,
				'cre_id_modalidades' => $request->cre_id_modalidades, 
				'cre_id_finalidades' => (isset($request->cre_id_finalidades) ? $request->cre_id_finalidades : NULL),
				'cre_id_produtos' => $request->cre_id_produtos,
				'cre_id_armarios' => $request->cre_id_armarios,
				'data_movimento' => date("Y-m-d H:i:s"),
				'nivel_risco' => (isset($request->nivel_risco) ? $request->nivel_risco : NULL), 
				'taxa_operacao' => (isset($request->taxa_operacao) ? str_replace($request->taxa_operacao, ',', '.') : NULL), 
				'taxa_mora' => (isset($request->taxa_mora) ? str_replace($request->taxa_mora, ',', '.') : NULL), 
				'taxa_multa' => (isset($request->taxa_multa) ? str_replace($request->taxa_multa, ',', '.') : NULL),
				'valor_devido' => (isset($request->valor_devido) ? str_replace(',', '.', str_replace('.', '', $request->valor_devido)) : NULL),
				'qtd_parcelas' => (isset($request->qtd_parcelas) ? $request->qtd_parcelas : NULL),  	
				'qtd_parcelas_pagas' => (isset($request->qtd_parcelas_pagas) ? $request->qtd_parcelas_pagas : NULL)	
			]);
			// Inserindo avalistas
			if(isset($request->avalista)){
				for ($i=0; $i < count($request->avalista); $i++){
					$documento = explode(': ', $request->avalista[$i]);
					$associado = Associados::where('documento', $documento[1])->select('id')->first();
					$avalista = ContratosAvalistas::create([
						'cre_id_contrato' => $contrato->id, 
						'cli_id_associado' => $associado->id, 
						'data_movimento' => date("Y-m-d H:i:s")
					]);
				}
			}
			// Inserindo garantias
			if(isset($request->tipoGarantia)){
				for ($i=0; $i < count($request->tipoGarantia); $i++){
					$garantia = ContratosGarantias::create([
						'cre_id_contrato' => $contrato->id,
						'tipo' => $request->tipoGarantia[$i], 
						'descricao' => $request->descricaoGarantia[$i],
						'data_movimento' => date("Y-m-d H:i:s")
					]);
				}
			}
			Atividades::create([
				'nome' => 'Cadastro de um novo contrato de crédito',
				'descricao' => 'Você cadastrou um novo contrato de crédito, '.$contrato->num_contrato.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.contratos.credito'),
				'id_usuario' => Auth::id()
			]);

			// Retornando contrato inserido
			$dados = Contratos::find($contrato->id);
			if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
				$dados->acoes =  "
				<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>
				<button class='btn btn-dark btn-xs btn-rounded mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
			}else{
				$dados->acoes =  "";
			}
			$dados->status1 = '<label class="badge'.($dados->status == "vigente" ? " badge-success" : ($dados->status == 'quitado' ? " badge-danger" : " badge-warning" )).'">'.($dados->status == "vigente" ? "Vigente" : ($dados->status == 'quitado' ? "Quitado" : "Prejuízo" )).'</label>';
			$dados->valor_contrato = number_format($dados->valor_contrato, 2, ',', '.');
			$dados->valor_contrato1 = 'R$ '.$dados->valor_contrato;
			$dados->produto = $dados->RelationProdutos;
			$dados->modalidade = $dados->RelationModalidades;
			$dados->finalidade = $dados->RelationFinalidades;
			$dados->associado = $dados->RelationAssociados;
			$dados->armario = $dados->RelationArmarios;
			$dados->taxa_operacao = number_format($dados->taxa_operacao, 2, ',', '');
			$dados->taxa_mora = number_format($dados->taxa_mora, 2, ',', '');
			$dados->taxa_multa = number_format($dados->taxa_multa, 2, ',', '');
			return response()->json($dados);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do contrato
	public function Editar(Request $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			// Retornando dados do associado
			$documento = explode(': ', $request->cli_id_associado);
			$associado = Associados::where('documento', $documento[1])->select('id')->first();
			// Inserindo dados do contrato
			$contrato = Contratos::find($id)->update([
				'num_contrato' => $request->num_contrato, 
				'status' => $request->status, 
				'data_operacao' => $request->data_operacao, 
				'data_vencimento' => $request->data_vencimento, 
				'valor_contrato' => str_replace(',', '.', str_replace('.', '', $request->valor_contrato)),
				'renegociacao' => (isset($request->renegociacao) ? 1 : 0),
				'renegociacao_contrato' => (isset($request->renegociacao_contrato) ? $request->renegociacao_contrato : NULL), 
				'observacoes' => (isset($request->observacoes) ? $request->observacoes : NULL), 
				'cli_id_associado' => $associado->id,
				'cre_id_modalidades' => $request->cre_id_modalidades, 
				'cre_id_finalidades' => (isset($request->cre_id_finalidades) ? $request->cre_id_finalidades : NULL),
				'cre_id_produtos' => $request->cre_id_produtos,
				'cre_id_armarios' => $request->cre_id_armarios,
				'data_movimento' => date("Y-m-d H:i:s"),
				'nivel_risco' => (isset($request->nivel_risco) ? $request->nivel_risco : NULL), 
				'taxa_operacao' => (empty($request->taxa_operacao) ? str_replace($request->taxa_operacao, ',', '.') : NULL), 
				'taxa_mora' => (empty($request->taxa_mora) ? str_replace($request->taxa_mora, ',', '.') : NULL), 
				'taxa_multa' => (empty($request->taxa_multa) ? str_replace($request->taxa_multa, ',', '.') : NULL),
				'valor_devido' => (isset($request->valor_devido) ? str_replace(',', '.', str_replace('.', '', $request->valor_devido)) : NULL),
				'qtd_parcelas' => (isset($request->qtd_parcelas) ? $request->qtd_parcelas : NULL),  	
				'qtd_parcelas_pagas' => (isset($request->qtd_parcelas_pagas) ? $request->qtd_parcelas_pagas : NULL)	
			]);
			// Inserindo avalistas
			if(isset($request->avalista)){
				Avalistas::where('cre_id_contrato', $id)->delete();
				for ($i=0; $i < count($request->avalista); $i++){
						// Verifica se tem contéudo nesse array
					if(isset($request->avalista[$i])){
						$documento = explode(': ', $request->avalista[$i]);
						$associado = Associados::where('documento', $documento[1])->select('id')->first();
						$avalista = ContratosAvalistas::create([
							'cre_id_contrato' => $id, 
							'cli_id_associado' => $associado->id, 
							'data_movimento' => date("Y-m-d H:i:s")
						]);
					}
				}
			}else{
				Avalistas::where('cre_id_contrato', $id)->delete();
			}
			// Inserindo garantias
			if(isset($request->tipoGarantia)){
				Garantias::where('cre_id_contrato', $id)->delete();
				for ($i=0; $i < count($request->tipoGarantia); $i++){
						// Verifica se tem contéudo nesse array
					if(isset($request->avalista[$i])){
						$garantia = ContratosGarantias::create([
							'cre_id_contrato' => $id,
							'tipo' => $request->tipoGarantia[$i], 
							'descricao' => $request->descricaoGarantia[$i],
							'data_movimento' => date("Y-m-d H:i:s")
						]);
					}
				}
			}else{
				ContratosGarantias::where('cre_id_contrato', $id)->delete();
			}

			$dados = Contratos::find($id);
			Atividades::create([
				'nome' => 'Edição de informações do contrato',
				'descricao' => 'Você modificou as informações do contrato de crédito '.$dados->num_contrato.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.contratos.credito'),
				'id_usuario' => Auth::id()
			]);

			// Retornando contrato inserido
			if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
				$dados->acoes = "
				<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>
				<button class='btn btn-dark btn-xs btn-rounded mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
			}else{
				$dados->acoes =  "";
			}
			$dados->status1 = '<label class="badge'.($dados->status == "vigente" ? " badge-success" : ($dados->status == 'quitado' ? " badge-danger" : " badge-warning" )).'">'.($dados->status == "vigente" ? "Vigente" : ($dados->status == 'quitado' ? "Quitado" : "Prejuízo" )).'</label>';
			$dados->valor_contrato = number_format($dados->valor_contrato, 2, ',', '.');
			$dados->valor_contrato1 = 'R$ '.$dados->valor_contrato;
			$dados->produto = $dados->RelationProdutos;
			$dados->modalidade = $dados->RelationModalidades;
			$dados->finalidade = $dados->RelationFinalidades;
			$dados->associado = $dados->RelationAssociados;
			$dados->armario = $dados->RelationArmarios;
			$dados->taxa_operacao = number_format($dados->taxa_operacao, 2, ',', '');
			$dados->taxa_mora = number_format($dados->taxa_mora, 2, ',', '');
			$dados->taxa_multa = number_format($dados->taxa_multa, 2, ',', '');
			return response()->json($dados);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status do contrato
	public function Alterar(Request $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			Contratos::find($id)->update(['status' => $request->status]);
			// Retornando contrato inserido
			$dados = Contratos::find($id);
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status do contrato de crédito '.$dados->num_contrato.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.contratos.credito'),
				'id_usuario' => Auth::id()
			]);
			if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
				$dados->acoes =  "
				<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>
				<button class='btn btn-dark btn-xs btn-rounded mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
			}else{
				$dados->acoes =  "";
			}
			$dados->status1 = '<label class="badge'.($dados->status == "vigente" ? " badge-success" : ($dados->status == 'quitado' ? " badge-danger" : " badge-warning" )).'">'.($dados->status == "vigente" ? "Vigente" : ($dados->status == 'quitado' ? "Quitado" : "Prejuízo" )).'</label>';
			$dados->valor_contrato = number_format($dados->valor_contrato, 2, ',', '.');
			$dados->valor_contrato1 = 'R$ '.$dados->valor_contrato;
			$dados->produto = $dados->RelationProdutos;
			$dados->modalidade = $dados->RelationModalidades;
			$dados->finalidade = $dados->RelationFinalidades;
			$dados->associado = $dados->RelationAssociados;
			$dados->armario = $dados->RelationArmarios;
			$dados->taxa_operacao = number_format($dados->taxa_operacao, 2, ',', '');
			$dados->taxa_mora = number_format($dados->taxa_mora, 2, ',', '');
			$dados->taxa_multa = number_format($dados->taxa_multa, 2, ',', '');
			return response()->json($dados);
		}else{
			return redirect(route('403'));
		}
	}
	// Retornado as garantias do contrato
	public function Garantias($id){
		$garantias[] = ContratosAvalistas::rightJoin('cli_associados', 'cli_id_associado', 'cli_associados.id')->where('cre_id_contrato', $id)->select('nome', 'documento', 'cre_avalistas.id')->get();
		$garantias[] = ContratosGarantias::where('cre_id_contrato', $id)->select('tipo', 'descricao', 'cre_garantias.id')->get();
		return $garantias;
	}
	

	#-------------------------------------------------------------------
	# Configurações (Armários)
	#-------------------------------------------------------------------
	// Listando todos os armários
	public function ExibirArmarios(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return view('credito.configuracoes.armarios.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesArmarios(){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return datatables()->of(ContratosArmarios::all())
			->editColumn('nome1', function(ContratosArmarios $dados){ 
				return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
			})
			->editColumn('referencia', function(ContratosArmarios $dados){
				return $dados->referencia;
			})
			->editColumn('status1', function(ContratosArmarios $dados){
				return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
			})
			->editColumn('acoes', function(ContratosArmarios $dados){ 
				return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
			})->rawColumns(['nome1', 'referencia', 'status1','acoes'])->make(true);
		}else{
			return datatables()->of(ContratosArmarios::all())
			->editColumn('nome1', function(Armarios $dados){ 
				return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
			})
			->editColumn('referencia', function(ContratosArmarios $dados){
				return $dados->referencia;
			})
			->editColumn('status1', function(ContratosArmarios $dados){
				return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
			})
			->editColumn('acoes', function(ContratosArmarios $dados){ 
				return '';
			})->rawColumns(['nome1', 'referencia', 'status1','acoes'])->make(true);
		}
	}
	// Adicionando novo armário
	public function AdicionarArmarios(ArmariosRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$create = ContratosArmarios::create([
				'nome' => $request->nome, 
				'referencia' => $request->referencia,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo armário de crédito',
				'descricao' => 'Você cadastrou um novo armário de crédito, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.armarios.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do armário
	public function EditarArmarios(ArmariosRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			ContratosArmarios::find($id)->update([
				'nome' => $request->nome, 
				'referencia' => $request->referencia,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = ContratosArmarios::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do armário de crédito '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.armarios.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarArmarios($id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$tipos = ContratosArmarios::find($id);
			if($tipos->status == 1){
				ContratosArmarios::find($id)->update(['status' => 0]);
			}else{
				ContratosArmarios::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status do armário de crédito '.$create->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.armarios.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do armário
	public function DetalhesArmarios($id){
		$dados = Armarios::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Configurações (Modalidades)
	#-------------------------------------------------------------------
	// Listando todas as modalidades
	public function ExibirModalidades(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return view('credito.configuracoes.modalidades.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesModalidades(){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return datatables()->of(ContratosModalidades::all())
	            ->editColumn('nome1', function(ContratosModalidades $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('sigla', function(ContratosModalidades $dados){
	                return $dados->sigla;
	            })
	            ->editColumn('status1', function(ContratosModalidades $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(ContratosModalidades $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'sigla', 'status1','acoes'])->make(true);
	   	}else{
	   		return datatables()->of(ContratosModalidades::all())
	            ->editColumn('nome1', function(ContratosModalidades $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('sigla', function(ContratosModalidades $dados){
	                return $dados->sigla;
	            })
	            ->editColumn('status1', function(ContratosModalidades $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(ContratosModalidades $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'sigla', 'status1','acoes'])->make(true);
	   	}
	}
	// Adicionando nova modalidade
	public function AdicionarModalidades(ModalidadesRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$create = ContratosModalidades::create([
				'nome' => $request->nome, 
				'codigo' => $request->codigo,
				'sigla' => $request->sigla,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova modalidade de crédito',
				'descricao' => 'Você cadastrou um nova modalidade de crédito, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.modalidades.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações da modalidade
	public function EditarModalidades(ModalidadesRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			ContratosModalidades::find($id)->update([
				'nome' => $request->nome, 
				'codigo' => $request->codigo,
				'sigla' => $request->sigla,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create	= ContratosModalidades::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações da modalidade de crédito '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.modalidades.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarModalidades($id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$modalidades = ContratosModalidades::find($id);
			if($modalidades->status == 1){
				ContratosModalidades::find($id)->update(['status' => 0]);
			}else{
				ContratosModalidades::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da modalidade de crédito '.$modalidades->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.modalidades.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes da modalidade
	public function DetalhesModalidades($id){
		$dados = ContratosModalidades::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Configurações (Produtos)
	#-------------------------------------------------------------------
	// Listando todos os produtos
	public function ExibirProdutos(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return view('credito.configuracoes.produtos.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesProdutos(){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return datatables()->of(ContratosProdutos::all())
	            ->editColumn('nome1', function(ContratosProdutos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('codigo', function(ContratosProdutos $dados){
	                return $dados->codigo;
	            })
	            ->editColumn('status1', function(ContratosProdutos $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(ContratosProdutos $dados){ 
	                return ($dados->status == 1 ? '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'codigo', 'status1','acoes'])->make(true);
	    }else{
	    	return datatables()->of(ContratosProdutos::all())
	            ->editColumn('nome1', function(ContratosProdutos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('codigo', function(ContratosProdutos $dados){
	                return $dados->codigo;
	            })
	            ->editColumn('status1', function(ContratosProdutos $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(ContratosProdutos $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'codigo', 'status1','acoes'])->make(true);
	    }
	}
	// Adicionando novo produto
	public function AdicionarProdutos(ProdutosCredRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$create = ContratosProdutos::create([
				'nome' => $request->nome, 
				'codigo' => $request->codigo,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de novo produto de crédito',
				'descricao' => 'Você cadastrou um novo produto de crédito, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.produtos.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do produto
	public function EditarProdutos(ProdutosCredRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			ContratosProdutos::find($id)->update([
				'nome' => $request->nome, 
				'codigo' => $request->codigo,
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = ContratosProdutos::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do produto de crédito '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.produtos.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarProdutos($id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$produtos = ContratosProdutos::find($id);
			if($produtos->status == 1){
				ContratosProdutos::find($id)->update(['status' => 0]);
			}else{
				ContratosProdutos::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status do produto de crédito '.$produtos->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.produtos.credito'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do produto
	public function DetalhesProdutos($id){
		$dados = ContratosProdutos::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Garantias
	#-------------------------------------------------------------------
	// Listando garantias fidunciárias
	public function ExibirFiduciaria(Request $request){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$contratos = Contratos::all();
			return view('credito.garantias.fiduciarias.listar')->with('contratos', $contratos);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesFiduciaria(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return datatables()->of(ContratosGarantias::all())
				->editColumn('contrato1', function(ContratosGarantias $dados){
	                return $dados->RelationContrato->num_contrato;
	            })
	            ->editColumn('nome1', function(ContratosGarantias $dados){
	            	return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationContrato->RelationAssociados->nome.'</a>';                
	            })
	            ->editColumn('produto1', function(ContratosGarantias $dados){
	                return $dados->RelationContrato->RelationProdutos->nome;
	            })
	            ->editColumn('acoes', function(ContratosGarantias $dados){ 
	                return "<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações da garantia'><i class='mx-0 mdi mdi-settings'></i></button>
	                	<button class='btn btn-dark btn-xs btn-rounded' name='alterar' id='alterar' title='Remover garantia'><i class='mx-0 mdi mdi-close'></i></button>";
	            })->rawColumns(['nome1', 'contrato1', 'produto1', 'acoes'])->make(true);
	    }else{
	        return datatables()->of(ContratosGarantias::all())
				->editColumn('contrato1', function(ContratosGarantias $dados){
	                return $dados->RelationContrato->num_contrato;
	            })
	            ->editColumn('nome1', function(ContratosGarantias $dados){
	            	return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationContrato->RelationAssociados->nome.'</a>';                
	            })
	            ->editColumn('produto1', function(ContratosGarantias $dados){
	                return $dados->RelationContrato->RelationProdutos->nome;
	            })
	            ->editColumn('acoes', function(ContratosGarantias $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'contrato1', 'produto1', 'acoes'])->make(true);
	   	}
	}
	// Listando garantias fidejussórias
	public function ExibirFidejussoria(Request $request){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$contratos = Contratos::all();
			return view('credito.garantias.fidejussorias.listar')->with('contratos', $contratos);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesFidejussoria(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			return datatables()->of(ContratosAvalistas::all())
				->editColumn('nome1', function(ContratosAvalistas $dados){
	            	return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationContrato->RelationAssociados->nome.'</a>';                
	            })
	            ->editColumn('contrato1', function(ContratosAvalistas $dados){
	                return $dados->RelationContrato->num_contrato;
	            })
	            ->editColumn('produto1', function(ContratosAvalistas $dados){
	                return $dados->RelationContrato->RelationProdutos->nome;
	            })
	            ->editColumn('avalista', function(ContratosAvalistas $dados){
	                return $dados->RelationAssociados->nome;
	            })
	            ->editColumn('acoes', function(ContratosAvalistas $dados){ 
	                return "<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações da garantia'><i class='mx-0 mdi mdi-settings'></i></button>
	                	<button class='btn btn-dark btn-xs btn-rounded' name='alterar' id='alterar' title='Remover garantia'><i class='mx-0 mdi mdi-close'></i></button>";
	            })->rawColumns(['nome1', 'contrato1', 'produto1', 'avalista', 'acoes'])->make(true);
        }else{
        	return datatables()->of(ContratosAvalistas::all())
				->editColumn('nome1', function(ContratosAvalistas $dados){
	            	return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationContrato->RelationAssociados->nome.'</a>';                
	            })
	            ->editColumn('contrato1', function(ContratosAvalistas $dados){
	                return $dados->RelationContrato->num_contrato;
	            })
	            ->editColumn('produto1', function(ContratosAvalistas $dados){
	                return $dados->RelationContrato->RelationProdutos->nome;
	            })
	            ->editColumn('avalista', function(ContratosAvalistas $dados){
	                return $dados->RelationAssociados->nome;
	            })
	            ->editColumn('acoes', function(ContratosAvalistas $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'contrato1', 'produto1', 'avalista', 'acoes'])->make(true);
        }
	}
    // Adicionando nova garantia
	public function AdicionarGarantias(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			// Inserindo avalistas
			if(isset($request->avalista)){
				for ($i=0; $i < count($request->avalista); $i++){
					$documento = explode(': ', $request->avalista[$i]);
					$associado = Associados::where('documento', $documento[1])->select('id')->first();
					$avalista = ContratosAvalistas::create([
						'cre_id_contrato' => $request->contrato, 
						'cli_id_associado' => $associado->id, 
						'data_movimento' => date("Y-m-d H:i:s")
					]);
				}
				Atividades::create([
					'nome' => 'Cadastro de nova garantia fidejussórias',
					'descricao' => 'Você cadastrou uma nova garantia de crédito no contrato, '.$avalista->RelationContrato->num_contrato.'.',
					'icone' => 'mdi-plus',
					'url' => route('exibir.garantias.fidejussoria.credito'),
					'id_usuario' => Auth::id()
				]);
			}
			// Inserindo garantias
			if(isset($request->tipoGarantia)){
				for ($i=0; $i < count($request->tipoGarantia); $i++){
					$garantia = ContratosGarantias::create([
						'cre_id_contrato' => $request->contrato,
						'tipo' => $request->tipoGarantia[$i], 
						'descricao' => $request->descricaoGarantia[$i],
						'data_movimento' => date("Y-m-d H:i:s")
					]);
				}
				Atividades::create([
					'nome' => 'Cadastro de nova garantia fidunciárias',
					'descricao' => 'Você cadastrou uma nova garantia de crédito no contrato, '.$garantia->RelationContrato->num_contrato.'.',
					'icone' => 'mdi-plus',
					'url' => route('exibir.garantias.fiduciaria.credito'),
					'id_usuario' => Auth::id()
				]);	
			}
		}else{
			return redirect(route('403'));
		}
	}
	// Editando garantia do contrato
	public function EditarGarantias(Request $request, $avalista, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			// Inserindo avalistas
			if($avalista == 'fidejussoria'){
				$documento = explode(': ', $request->avalista);
				$associado = Associados::where('documento', $documento[1])->select('id')->first();
				$avalista = ContratosAvalistas::find($id)->update([
					'cli_id_associado' => $associado->id, 
					'data_movimento' => date("Y-m-d H:i:s")
				]);
				Atividades::create([
					'nome' => 'Edição de informações da garantia fidejussórias',
					'descricao' => 'Você editou as informações da garantia do contrato, '.$avalista->RelationContrato->num_contrato.'.',
					'icone' => 'mdi-auto-fix',
					'url' => route('exibir.garantias.fidejussoria.credito'),
					'id_usuario' => Auth::id()
				]);
				return response()->json(['success' => true]);
			}else{
				$garantia = ContratosGarantias::find($id)->update([
					'tipo' => $request->tipoGarantia, 
					'descricao' => $request->descricaoGarantia,
					'data_movimento' => date("Y-m-d H:i:s")
				]);
				Atividades::create([
					'nome' => 'Edição de informações da garantia fidunciárias',
					'descricao' => 'Você editou as informações da garantia do contrato, '.$garantia->RelationContrato->num_contrato.'.',
					'icone' => 'mdi-auto-fix',
					'url' => route('exibir.garantias.fiduciaria.credito'),
					'id_usuario' => Auth::id()
				]);	
				return response()->json(['success' => true]);
			}
		}else{
			return redirect(route('403'));
		}
	}
	// Removendo a garantia
	public function AlterarGarantias($avalista, $id){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			if($avalista == 'fidejussoria'){
				$avalista = ContratosGarantias::find($id);
				Atividades::create([
					'nome' => 'Exclusão de garantia fidejussórias',
					'descricao' => 'Você removeu uma das garantias do contrato, '.$avalista->RelationContrato->num_contrato.'.',
					'icone' => 'mdi-close',
					'url' => route('exibir.garantias.fidejussoria.credito'),
					'id_usuario' => Auth::id()
				]);
				ContratosAvalistas::find($id)->delete();
				return response()->json(['success' => true]);
			}else{
				$garantia = ContratosGarantias::find($id);
				Atividades::create([
					'nome' => 'Exclusão de garantia fidunciárias',
					'descricao' => 'Você removeu uma das garantias do contrato, '.$garantia->RelationContrato->num_contrato.'.',
					'icone' => 'mdi-close',
					'url' => route('exibir.garantias.fiduciaria.credito'),
					'id_usuario' => Auth::id()
				]);	
				ContratosGarantias::find($id)->delete();
				return response()->json(['success' => true]);
			}
		}else{
			return redirect(route('403'));
		}
	}
	// Detalhes da garantia
	public function DetalhesGarantias($id){
		$garantias[] = ContratosAvalistas::join('cli_associados', 'cli_id_associado', 'cli_associados.id')->where('cre_avalistas.id', $id)->select('nome', 'documento', 'cre_avalistas.id')->get();
		$garantias[] = ContratosGarantias::where('cre_id_contrato', $id)->select('tipo', 'descricao', 'cre_garantias.id')->get();
		return $garantias;
	}

	#-------------------------------------------------------------------
	# Solicitações
	#-------------------------------------------------------------------
	// Listando todos produtos
	public function ExibirSolicitacoes(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$contratos = Contratos::all();
			$dados = ContratosSolicitacoes::orderBy('created_at', 'DESC')->get();
			$produtos = ContratosProdutos::where('status', 1)->orderBy('nome', 'ASC')->get(); 
			$modalidades = ContratosModalidades::where('status', 1)->orderBy('nome', 'ASC')->get();
			return view('credito.solicitacoes.exibir')->with('dados', $dados)->with('contratos', $contratos)->with('produtos', $produtos)->with('modalidades', $modalidades);
		}else{
			return redirect(route('403'));
		}
	}
	// Efetuando a solicitação
	public function SolicitarSolicitacoes(Request $request){
		$create = ContratosSolicitacoes::create([
			'usr_id_usuario' => Auth::id(),
			'cre_id_contratos' => $request->contrato,
			'observacoes' => $request->observacoes
		]);
		ContratosSolicitacoes::create([
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
    public function RelatorioSolicitacoes($id){
        $dados = ContratosSolicitacoes::find($id);
        return view('credito.solicitacoes.relatorio')->with('requisicao', $dados);
    }
	// Remover a solicitação
	public function RemoverSolicitacoes($id){
		$dados = ContratosSolicitacoes::find($id);
		Atividades::create([
			'nome' => 'Exclusão de solicitação de contrato',
			'descricao' => 'Você removeu uma solicitação do contrato de crédito, '.$dados->RelationContratos->num_contrato.'.',
			'icone' => 'mdi-close',
			'url' => route('exibir.solicitacoes.credito'),
			'id_usuario' => Auth::id()
		]);
		ContratosSolicitacoesStatus::where('cre_id_solicitacoes', $id)->delete();
		ContratosSolicitacoes::find($id)->delete();
		return response()->json(['success' => true]);
	}
	// Alteração de status
	public function AlterarSolicitacoes(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_credito == 1){
			Atividades::create([
				'nome' => 'Alteração de estado de solicitação',
				'descricao' => 'Você alterou o status da solicitação de nº '.$request->id.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.setores.administrativo'),
				'id_usuario' => Auth::id()
			]);
			ContratosSolicitacoesStatus::create([
				'status' => $request->status,
				'usr_id_usuario_alteracao' => Auth::id(),
				'cre_id_solicitacoes' => $request->id
			]);
			$solicitacao = Solicitacoes::find($request->id);
			$solicitacao->RelationUsuarios->notify(new SolicitacaoContratoCliente($solicitacao));  
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Retornado detalhes do contrato
	public function DetalhesContratoSolicitacoes($id){
		$contrato = Contratos::find($id);
		return $contrato;
	}
	

	#-------------------------------------------------------------------
	# Envio de informações para o SEBRAE
	#-------------------------------------------------------------------
	public function Fampe(){
		$operacoes = Contratos::where('cod_linha', '86156')->orWhere('cod_linha', '86158')->orWhere('cod_linha', '86160')->orWhere('cod_linha', '86161')->orWhere('cod_linha', '86162')->orWhere('cod_linha', '86163')->orWhere('cod_linha', '86164')->orderBy('data_operacao', 'DESC')->get();
		
		$usuario = Usuarios::find(1);
		$usuario->notify(new Fampe($operacoes));  

		return true;
	}

}
