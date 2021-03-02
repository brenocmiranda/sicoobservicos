<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Associados;

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
	public function ExibirAnalise(){
		return view('negocios.analise.listar');
	}
	public function DatatablesAnalise(){
		return datatables()->of(Associados::join('cca_contacapital', 'cli_id_associado', 'cli_associados.id')->where('sigla', 'PF')->Where('situacao_capital', 'ATIVO')->select('cli_associados.id', 'nome', 'documento', 'renda', 'nome_gerente')->orderBy('nome', 'ASC')->get())
        ->editColumn('renda1', function(Associados $dados){ 
            return 'R$ '.number_format($dados->renda, 2, ",", ".");
        })
        ->editColumn('acoes', function(Associados $dados){ 
            return '<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
				<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>';
        })->rawColumns(['renda1', 'acoes'])->make(true);
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
