<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class CadastroCtrl extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

    // Listando todas solicitações
 	public function ExibirSolicitacoes(){
    	return view('cadastro.solicitacoes.listar');
	}

	// Adicionar novo associado
 	public function DetalhesSolicitacoes(){
    	return view('atendimento.cadastro.adicionar');
	}
}
