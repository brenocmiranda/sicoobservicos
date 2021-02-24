<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Cadastro;
use App\Models\CadastroArquivos;
use App\Models\CadastroSocios;
use App\Models\CadastroStatus;
use App\Models\CadastroTelefones;

class CadastroCtrl extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Novos associados
	#-------------------------------------------------------------------

    // Listando novos associados
 	public function ExibirNovos(){
 		$solicitacoes = Cadastro::all();
    	return view('cadastro.novos.listar')->with('solicitacoes', $solicitacoes);
	}
	// Adicionar novos associado
 	public function DetalhesNovos(){
    	return view('atendimento.novos.adicionar');
	}
}
