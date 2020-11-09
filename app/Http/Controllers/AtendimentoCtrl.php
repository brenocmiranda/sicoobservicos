<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Associados;
use App\Models\Atividades;

class AtendimentoCtrl extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	// Listando painel
 	public function ExibirPainel(){
	    return view('atendimento.painel.listar');
  	}
}
