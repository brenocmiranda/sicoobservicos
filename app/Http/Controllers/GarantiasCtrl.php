<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Contratos;
use App\Models\Associados;
use App\Models\Avalistas;
use App\Models\Garantias;
use App\Models\Atividades;

class GarantiasCtrl extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	// Listando garantias fidunciárias
	public function ExibirFiduciaria(Request $request){
		$contratos = Contratos::all();
		return view('credito.garantias.fiduciarias.listar')->with('contratos', $contratos);
	}
	public function DatatablesFiduciaria(Request $request){
		return datatables()->of(Garantias::all())
			->editColumn('contrato1', function(Garantias $dados){
                return $dados->RelationContrato->num_contrato;
            })
            ->editColumn('nome1', function(Garantias $dados){
            	return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationContrato->RelationAssociados->nome.'</a>';                
            })
            ->editColumn('produto1', function(Garantias $dados){
                return $dados->RelationContrato->RelationProdutos->nome;
            })
            ->editColumn('acoes', function(Garantias $dados){ 
                return "<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações da garantia'><i class='mx-0 mdi mdi-settings'></i></button>
                	<button class='btn btn-dark btn-xs btn-rounded' name='alterar' id='alterar' title='Remover garantia'><i class='mx-0 mdi mdi-close'></i></button>";
            })->rawColumns(['nome1', 'contrato1', 'produto1', 'acoes'])->make(true);
	}

	// Listando garantias fidejussórias
	public function ExibirFidejussoria(Request $request){
		$contratos = Contratos::all();
		return view('credito.garantias.fidejussorias.listar')->with('contratos', $contratos);
	}
	public function DatatablesFidejussoria(Request $request){
		return datatables()->of(Avalistas::all())
			->editColumn('nome1', function(Avalistas $dados){
            	return '<a href="javascript:void(0)" id="detalhes">'.$dados->RelationContrato->RelationAssociados->nome.'</a>';                
            })
            ->editColumn('contrato1', function(Avalistas $dados){
                return $dados->RelationContrato->num_contrato;
            })
            ->editColumn('produto1', function(Avalistas $dados){
                return $dados->RelationContrato->RelationProdutos->nome;
            })
            ->editColumn('avalista', function(Avalistas $dados){
                return $dados->RelationAssociados->nome;
            })
            ->editColumn('acoes', function(Avalistas $dados){ 
                return "<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações da garantia'><i class='mx-0 mdi mdi-settings'></i></button>
                	<button class='btn btn-dark btn-xs btn-rounded' name='alterar' id='alterar' title='Remover garantia'><i class='mx-0 mdi mdi-close'></i></button>";
            })->rawColumns(['nome1', 'contrato1', 'produto1', 'avalista', 'acoes'])->make(true);
	}

    // Adicionando nova garantia
	public function Adicionar(Request $request){
		// Inserindo avalistas
		if(isset($request->avalista)){
			for ($i=0; $i < count($request->avalista); $i++){
				$documento = explode(': ', $request->avalista[$i]);
				$associado = Associados::where('documento', $documento[1])->select('id')->first();
				$avalista = Avalistas::create([
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
				$garantia = Garantias::create([
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
	}

	 // Editando garantia do contrato
	public function Editar(Request $request, $avalista, $id){
		// Inserindo avalistas
		if($avalista == 'fidejussoria'){
			$documento = explode(': ', $request->avalista);
			$associado = Associados::where('documento', $documento[1])->select('id')->first();
			$avalista = Avalistas::find($id)->update([
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
			$garantia = Garantias::find($id)->update([
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
	}

	// Removendo a garantia
	public function Alterar($avalista, $id){
		if($avalista == 'fidejussoria'){
			$avalista = Garantias::find($id);
			Atividades::create([
				'nome' => 'Exclusão de garantia fidejussórias',
				'descricao' => 'Você removeu uma das garantias do contrato, '.$avalista->RelationContrato->num_contrato.'.',
				'icone' => 'mdi-close',
				'url' => route('exibir.garantias.fidejussoria.credito'),
				'id_usuario' => Auth::id()
			]);
			Avalistas::find($id)->delete();
			return response()->json(['success' => true]);
		}else{
			$garantia = Garantias::find($id);
			Atividades::create([
				'nome' => 'Exclusão de garantia fidunciárias',
				'descricao' => 'Você removeu uma das garantias do contrato, '.$garantia->RelationContrato->num_contrato.'.',
				'icone' => 'mdi-close',
				'url' => route('exibir.garantias.fiduciaria.credito'),
				'id_usuario' => Auth::id()
			]);	
			Garantias::find($id)->delete();
			return response()->json(['success' => true]);
		}
	}

	// Detalhes da garantia
	public function Detalhes($id){
		$garantias[] = Avalistas::join('cli_associados', 'cli_id_associado', 'cli_associados.id')->where('cre_avalistas.id', $id)->select('nome', 'documento', 'cre_avalistas.id')->get();
		$garantias[] = Garantias::where('cre_id_contrato', $id)->select('tipo', 'descricao', 'cre_garantias.id')->get();
		return $garantias;
	}

}
