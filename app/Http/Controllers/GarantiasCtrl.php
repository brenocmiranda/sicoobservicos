<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Contratos;
use App\Models\Associados;
use App\Models\Avalistas;
use App\Models\Garantias;

class GarantiasCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando por status
	public function Exibir(Request $request){
		return view('credito.garantias.listar');
	}
	public function Datatables(Request $request){
		return datatables()->of(Contratos::all())
            ->editColumn('valor_contrato', function(Contratos $dados){ 
                return number_format($dados->valor_contrato, 2, ',', '.');
            })
            ->editColumn('valor_contrato1', function(Contratos $dados){
                return 'R$ '.$dados->valor_contrato;
            })
            ->editColumn('produto1', function(Contratos $dados){
                return $dados->RelationProdutos->nome;
            })
            ->editColumn('nome1', function(Contratos $dados){
                return $dados->RelationAssociados->nome;
            })
            ->editColumn('armario1', function(Contratos $dados){
                return $dados->RelationArmarios->referencia;
            })
            ->editColumn('tipo', function(Contratos $dados){
                return ( !empty($dados->RelationAvalistas->first()) ? '<div class="d-block">Garantias fidejussória</div>' : '').( !empty($dados->RelationGarantias->first()) ? '<div class="d-block">Garantias fiduciária</div>' : 'Não possui nenhuma');
            })
            ->editColumn('acoes', function(Contratos $dados){ 
                return "<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>
			<button class='btn btn-dark btn-xs btn-rounded mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
            })->rawColumns(['valor_contrato', 'valor_contrato1', 'produto', 'modalidade', 'finalidade', 'associado', 'armario', 'tipo', 'acoes'])->make(true);
	}

    // Adicionando novo contrato
	public function Adicionar(Request $request){
		// Retornando dados do associado
		$documento = explode(': ', $request->cli_id_associado);
		$associado = Associados::where('documento', $documento[1])->select('id_associado')->first();
		// Inserindo dados do contrato
		$contrato = Contratos::create(['num_contrato' => $request->num_contrato, 
						   	'data_operacao' => $request->data_operacao, 
							'data_vencimento' => $request->data_vencimento, 
							'nivel_risco' => (isset($request->nivel_risco) ? $request->nivel_risco : NULL), 
							'taxa_operacao' => (isset($request->taxa_operacao) ? str_replace($request->taxa_operacao, ',', '.') : NULL), 
							'taxa_mora' => (isset($request->taxa_mora) ? str_replace($request->taxa_mora, ',', '.') : NULL), 
							'taxa_multa' => (isset($request->taxa_multa) ? str_replace($request->taxa_multa, ',', '.') : NULL), 
							'valor_contrato' => str_replace(',', '.', str_replace ('.', '', $request->valor_contrato)), 
							'produto' => $request->produto,
							'modalidade' => $request->modalidade, 
							'finalidade' => (isset($request->finalidade) ? $request->finalidade : NULL),  
							'quantidade_parcelas' => (isset($request->quantidade_parcelas) ? $request->quantidade_parcelas : NULL), 
							'data_movimento' => date("Y-m-d H:i:s"),
							'cli_id_associado' => $associado->id_associado
							]);
		// Inserindo dados do contrato
		$arquivo = Arquivos::create(['renegociacao' => $request->renegociacao, 
									'observacao' => $request->observacao, 
									'status' => $request->status, 
									'cre_id_contrato' => $contrato->id_contrato, 
									'cre_id_armario' => $request->cre_id_armario]);
		// Inserindo avalistas
		if(isset($request->avalista)){
			for ($i=0; $i < count($request->avalista); $i++){
				$documento = explode(': ', $request->avalista[$i]);
				$associado = Associados::where('documento', $documento[1])->select('id_associado')->first();
				$avalista = Avalistas::create(['cre_id_contrato' => $contrato->id_contrato, 
												'cli_id_associado' => $associado->id_associado, 
												'data_movimento' => date("Y-m-d H:i:s")
											]);
			}
		}
		// Inserindo garantias
		if(isset($request->tipoGarantia)){
			for ($i=0; $i < count($request->tipoGarantia); $i++){
				$garantia = Garantias::create(['cre_id_contrato' => $contrato->id_contrato,
												'tipo' => $request->tipoGarantia[$i], 
												'descricao' => $request->descricaoGarantia[$i],
												'data_movimento' => date("Y-m-d H:i:s")
											]);
			}
		}
		// Retornando contrato inserido
		$dados = Contratos::rightJoin('cli_associados', 'id_associado', 'cli_id_associado')->rightJoin('cre_arquivos', 'cre_arquivos.cre_id_contrato', 'id_contrato')->rightJoin('cre_armarios', 'id_armario', 'cre_id_armario')->where('cre_contratos_credito.id_contrato', $contrato->id_contrato)->select('cli_associados.nome', 'cli_associados.documento', 'cre_armarios.referencia', 'cre_arquivos.*', 'cre_contratos_credito.*')->first();
		$dados->acoes = "<button class='btn btn-dark btn-small btn-rounded px-2' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-pencil'></i></button><button class='btn btn-dark btn-small btn-rounded px-2 mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
		$dados->status1 = '<label class="badge'.($dados->status == "vigentes" ? " badge-success" : ($dados->status == 'liquidados' ? " badge-danger" : " badge-warning" )).'">'.($dados->status == "vigentes" ? "Vigente" : ($dados->status == 'liquidados' ? "Liquidado" : "Prejuízo" )).'</label>';
		$dados->valor_contrato = number_format($dados->valor_contrato, 2, ',', '.');
		$dados->valor_contrato1 = 'R$ '.$dados->valor_contrato;
		$dados->produto1 = ProdutosCred::where('id_produto', $dados->produto)->select('nome')->first();
		$dados->taxa_operacao = number_format($dados->taxa_operacao, 2, ',', '');
		$dados->taxa_mora = number_format($dados->taxa_mora, 2, ',', '');
		$dados->taxa_multa = number_format($dados->taxa_multa, 2, ',', '');
		return response()->json($dados);
		
	}

    // Editando informações do contrato
	public function Editar(Request $request, $id){
		// Retornando dados do associado
		$documento = explode(': ', $request->cli_id_associado);
		$associado = Associados::where('documento', $documento[1])->select('id_associado')->first();
		// Inserindo dados do contrato
		$contrato = Contratos::where('id_contrato', $id)->update([
							'num_contrato' => $request->num_contrato, 
						   	'data_operacao' => $request->data_operacao, 
							'data_vencimento' => $request->data_vencimento, 
							'nivel_risco' => (isset($request->nivel_risco) ? $request->nivel_risco : NULL), 
							'taxa_operacao' => (isset($request->taxa_operacao) ? str_replace(',', '.', $request->taxa_operacao) : NULL), 
							'taxa_mora' => (isset($request->taxa_mora) ? str_replace(',', '.', $request->taxa_mora) : NULL), 
							'taxa_multa' => (isset($request->taxa_multa) ? str_replace(',', '.', $request->taxa_multa) : NULL), 
							'valor_contrato' => str_replace(',', '.', str_replace ('.', '', $request->valor_contrato)), 
							'produto' => $request->produto,
							'modalidade' => $request->modalidade, 
							'finalidade' => (isset($request->finalidade) ? $request->finalidade : NULL),  
							'quantidade_parcelas' => (isset($request->quantidade_parcelas) ? $request->quantidade_parcelas : NULL), 
							'data_movimento' => date("Y-m-d H:i:s"),
							'cli_id_associado' => $associado->id_associado
							]);
		// Inserindo dados do contrato
		$arquivo = Arquivos::where('cre_id_contrato', $id)->update([
									'renegociacao' => $request->renegociacao, 
									'observacao' => $request->observacao, 
									'cre_id_armario' => $request->cre_id_armario
								]);
		// Inserindo avalistas
		if(isset($request->avalista)){
			Avalistas::where('cre_id_contrato', $id)->delete();
			for ($i=0; $i < count($request->avalista); $i++){
				// Verifica se tem contéudo nesse array
				if(isset($request->avalista[$i])){
					$documento = explode(': ', $request->avalista[$i]);
					$associado = Associados::where('documento', $documento[1])->select('id_associado')->first();
					$avalista = Avalistas::create(['cre_id_contrato' => $id, 
													'cli_id_associado' => $associado->id_associado, 
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
					$garantia = Garantias::create(['cre_id_contrato' => $request->num_contrato,
												'tipo' => $request->tipoGarantia[$i], 
												'descricao' => $request->descricaoGarantia[$i],
												'data_movimento' => date("Y-m-d H:i:s")
											]);
				}
			}
		}else{
			Garantias::where('cre_id_contrato', $id)->delete();
		}

		// Retornando contrato inserido
		$dados = Contratos::rightJoin('cli_associados', 'id_associado', 'cli_id_associado')->rightJoin('cre_arquivos', 'cre_arquivos.cre_id_contrato', 'id_contrato')->rightJoin('cre_armarios', 'id_armario', 'cre_id_armario')->where('cre_contratos_credito.id_contrato', $id)->select('cli_associados.nome', 'cli_associados.documento', 'cre_armarios.referencia', 'cre_arquivos.*', 'cre_contratos_credito.*')->first();
		$dados->acoes = "<button class='btn btn-dark btn-small btn-rounded px-2' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-pencil'></i></button><button class='btn btn-dark btn-small btn-rounded px-2 mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
		$dados->status1 = '<label class="badge'.($dados->status == "vigentes" ? " badge-success" : ($dados->status == 'liquidados' ? " badge-danger" : " badge-warning" )).'">'.($dados->status == "vigentes" ? "Vigente" : ($dados->status == 'liquidados' ? "Liquidado" : "Prejuízo" )).'</label>';
		$dados->valor_contrato = number_format($dados->valor_contrato, 2, ',', '.');
		$dados->valor_contrato1 = 'R$ '.$dados->valor_contrato;
		$dados->produto1 = ProdutosCred::where('id_produto', $dados->produto)->select('nome')->first();
		$dados->taxa_operacao = number_format($dados->taxa_operacao, 2, ',', '');
		$dados->taxa_mora = number_format($dados->taxa_mora, 2, ',', '');
		$dados->taxa_multa = number_format($dados->taxa_multa, 2, ',', '');
		return response()->json($dados);
	}

	// Alterar o status do contrato
	public function Alterar(Request $request, $id){
		Arquivos::where('cre_id_contrato', $id)->update(['status' => $request->status]);
		// Retornando contrato inserido
		$dados = Contratos::rightJoin('cli_associados', 'id_associado', 'cli_id_associado')->rightJoin('cre_arquivos', 'cre_arquivos.cre_id_contrato', 'id_contrato')->rightJoin('cre_armarios', 'id_armario', 'cre_id_armario')->where('cre_contratos_credito.id_contrato', $id)->select('cli_associados.nome', 'cli_associados.documento', 'cre_armarios.referencia', 'cre_arquivos.*', 'cre_contratos_credito.*')->first();
		$dados->acoes = "<button class='btn btn-dark btn-small btn-rounded px-2' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-pencil'></i></button><button class='btn btn-dark btn-small btn-rounded px-2 mx-1' name='alterar' id='alterar' title='Alterar status do contrato'><i class='mx-0 mdi mdi-swap-horizontal'></i></button>";
		$dados->status1 = '<label class="badge'.($dados->status == "vigentes" ? " badge-success" : ($dados->status == 'liquidados' ? " badge-danger" : " badge-warning" )).'">'.($dados->status == "vigentes" ? "Vigente" : ($dados->status == 'liquidados' ? "Liquidado" : "Prejuízo" )).'</label>';
		$dados->valor_contrato = number_format($dados->valor_contrato, 2, ',', '.');
		$dados->valor_contrato1 = 'R$ '.$dados->valor_contrato;
		$dados->produto1 = ProdutosCred::where('id_produto', $dados->produto)->select('nome')->first();
		$dados->taxa_operacao = number_format($dados->taxa_operacao, 2, ',', '');
		$dados->taxa_mora = number_format($dados->taxa_mora, 2, ',', '');
		$dados->taxa_multa = number_format($dados->taxa_multa, 2, ',', '');
		return response()->json($dados);

	}

	// Retornado as garantias do contrato
	public function Garantias($id){
		$garantias[] = Avalistas::rightJoin('cli_associados', 'cli_id_associado', 'id')->where('cre_id_contrato', $id)->select('nome', 'documento', 'cre_avalistas.id')->get();
		$garantias[] = Garantias::where('cre_id_contrato', $id)->select('tipo', 'descricao', 'cre_garantias.id')->get();
		return $garantias;
	}
}
