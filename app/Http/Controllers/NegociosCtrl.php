<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Associados;
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
		$dados = Associados::join('cca_contacapital', 'cli_id_associado', 'cli_associados.id')->where('sigla', 'PF')->select('cli_associados.id', 'nome', 'documento', 'renda', 'nome_gerente')->orderBy('nome', 'ASC')->get();
		foreach ($dados as $key => $value) {
			$dados[$key]->documento1 = (strlen($dados[$key]->documento) == 11 ? substr($dados[$key]->documento, 0, 3).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'-'.substr($dados[$key]->documento, 9, 2) : substr($dados[$key]->documento, 0, 2).'.'.substr($dados[$key]->documento, 3, 3).'.'.substr($dados[$key]->documento, 6, 3).'/'.substr($dados[$key]->documento, 8, 4).'-'.substr($dados[$key]->documento, 12, 2));
			$dados[$key]->renda1 = 'R$ '.number_format($dados[$key]->renda, 2, ",", ".");
			$dados[$key]->acoes = '<a href="'.route('executar.analise.negocios', $dados[$key]->id).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="analisar" title="Analisar o associado"><i class="mx-0 mdi mdi-clipboard-outline"></i></a>';
		}
		return response()->json($dados);

		/*
		return datatables()->of(Associados::join('cca_contacapital', 'cli_id_associado', 'cli_associados.id')->where('sigla', 'PF')->where('situacao_capital', 'ATIVO')->select('cli_associados.id', 'nome', 'documento', 'renda', 'nome_gerente')->orderBy('nome', 'ASC')->get())
        ->editColumn('renda1', function(Associados $dados){ 
            return 'R$ '.number_format($dados->renda, 2, ",", ".");
        })
        ->editColumn('acoes', function(Associados $dados){ 
            return '<a href="'.route('executar.analise.negocios', $dados->id).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="analisar" title="Analisar o associado"><i class="mx-0 mdi mdi-clipboard-outline"></i></a>';
        })->rawColumns(['renda1', 'acoes'])->make(true);*/
	}
	// Mostrar painel comercial
	public function ExecutarAnalise($id){
		$dados = Associados::find($id);
		$usuarios = Usuarios::where('status', 'Ativo')->orderBy('login', 'ASC')->get();
		return view('negocios.analise.detalhes')->with('dados', $dados)->with('usuarios', $usuarios);
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
