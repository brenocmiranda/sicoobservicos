<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Associados;
use Barryvdh\DomPDF\Facade as PDF;

class AssociadosCtrl extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

  // Listando todas as informações
  public function Listar(Request $request){
    $search = $request->get('term');
    $result = Associados::where('nome', 'LIKE', '%'. $search. '%')->select('nome', 'documento', 'id')->get();
    return response()->json($result);
  }

  #-------------------------------------------------------------------
  # Aniversariantes
  #-------------------------------------------------------------------
  public function ExibirAniversariantes(){
    return view('administrativo.aniversariantes.exibir');
  }

  public function GerarAniversariantes(Request $request){
    if($request->orientacao == 'paisagem'){
      $result = Associados::where('funcionario', 1)->whereMonth('data_nascimento', $request->mes)->where('id', '<>', 1)->select('nome', 'data_nascimento')->get();
      return PDF::loadView('administrativo.aniversariantes.relatorio-paisagem', compact('result'))->stream();
    }else{
      $result = Associados::where('funcionario', 1)->whereMonth('data_nascimento', $request->mes)->where('id', '<>', 1)->select('nome', 'data_nascimento')->get();
      return PDF::loadView('administrativo.aniversariantes.relatorio-retrato', compact('result'))->stream();
    }
  }

}
