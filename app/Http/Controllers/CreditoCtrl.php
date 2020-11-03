<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Armarios;
use App\Models\Associados;
use App\Models\Avalistas;
use App\Models\Contratos;
use App\Models\Finalidades;
use App\Models\Garantias;
use App\Models\Modalidades;
use App\Models\ProdutosCred;
use App\Models\Atividades;

class CreditoCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Contratos em Geral
	#-------------------------------------------------------------------
	// Exibindo status e fazendo a pesquisa
	public function Contratos(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$armarios = Armarios::where('status', 1)->orderBy('referencia', 'ASC')->get(); 
			$produtos = ProdutosCred::where('status', 1)->orderBy('nome', 'ASC')->get(); 
			$modalidades = Modalidades::where('status', 1)->orderBy('nome', 'ASC')->get();
			$finalidades = Finalidades::where('status', 1)->orderBy('nome', 'ASC')->get();  
			return view('credito.contratos.geral')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades)->with('finalidades', $finalidades);
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
			$armarios = Armarios::where('status', 1)->orderBy('referencia', 'ASC')->get(); 
			$produtos = ProdutosCred::where('status', 1)->get(); 
			$modalidades = Modalidades::where('status', 1)->get();
			$finalidades = Finalidades::where('status', 1)->get();  
			return view('credito.contratos.'.$request->segment(4).'.listar')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades)->with('finalidades', $finalidades);
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
					$avalista = Avalistas::create([
						'cre_id_contrato' => $contrato->id, 
						'cli_id_associado' => $associado->id, 
						'data_movimento' => date("Y-m-d H:i:s")
					]);
				}
			}
			// Inserindo garantias
			if(isset($request->tipoGarantia)){
				for ($i=0; $i < count($request->tipoGarantia); $i++){
					$garantia = Garantias::create([
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
						$avalista = Avalistas::create([
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
						$garantia = Garantias::create([
							'cre_id_contrato' => $id,
							'tipo' => $request->tipoGarantia[$i], 
							'descricao' => $request->descricaoGarantia[$i],
							'data_movimento' => date("Y-m-d H:i:s")
						]);
					}
				}
			}else{
				Garantias::where('cre_id_contrato', $id)->delete();
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
	

    #-------------------------------------------------------------------
	# Disposição de arquivos
	#-------------------------------------------------------------------
	public function Disposicao(){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$produtos = ProdutosCred::where('status', 1)->get(); 
			$modalidades = Modalidades::where('status', 1)->get();
			$finalidades = Finalidades::where('status', 1)->get();  
			$armarios = Armarios::where('status', 1)->orderBy('referencia')->get(); 
			return view('credito.disposicao.listar')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades)->with('finalidades', $finalidades);
		}else{
			return redirect(route('403'));
		}
	}

	// Listando os contratos da gaveta
	public function ExibirDisposicao($id){
		if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito == 1){
			$arm = Armarios::find($id); 
			$armarios = Armarios::where('status', 1)->get(); 
			$produtos = ProdutosCred::where('status', 1)->get(); 
			$modalidades = Modalidades::where('status', 1)->get();
			$finalidades = Finalidades::where('status', 1)->get();  
			return view('credito.disposicao.gaveta')->with('armarios', $armarios)->with('produtos', $produtos)->with('modalidades', $modalidades)->with('finalidades', $finalidades)->with('arm', $arm);
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
	# Funções Extras
	#-------------------------------------------------------------------
	// Retornado as garantias do contrato
	public function Garantias($id){
		$garantias[] = Avalistas::rightJoin('cli_associados', 'cli_id_associado', 'cli_associados.id')->where('cre_id_contrato', $id)->select('nome', 'documento', 'cre_avalistas.id')->get();
		$garantias[] = Garantias::where('cre_id_contrato', $id)->select('tipo', 'descricao', 'cre_garantias.id')->get();
		return $garantias;
	}

}
