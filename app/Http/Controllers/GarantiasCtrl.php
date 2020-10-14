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
                return $dados->RelationContrato->RelationAssociados->nome;
            })
            ->editColumn('produto1', function(Garantias $dados){
                return $dados->RelationContrato->RelationProdutos->nome;
            })
            ->editColumn('acoes', function(Garantias $dados){ 
                return "<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>";
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
                return $dados->RelationContrato->RelationAssociados->nome;
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
                return "<button class='btn btn-dark btn-xs btn-rounded' name='editar' id='editar' title='Editar informações do contrato'><i class='mx-0 mdi mdi-settings'></i></button>";
            })->rawColumns(['nome1', 'contrato1', 'produto1', 'avalista', 'acoes'])->make(true);
	}

    // Adicionando novo contrato
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
		}
	}

}
