<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Associados;
use App\Models\Atividades;
use PDF;

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
    if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1 || Auth::user()->RelationFuncao->ver_administrativo == 1){
      return view('administrativo.aniversariantes.exibir');
    }else{
      return redirect(route('403'));
    }
  }

  public function GerarAniversariantes(Request $request){
    if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1 || Auth::user()->RelationFuncao->ver_administrativo == 1){
      if($request->orientacao == 'paisagem'){
        $result = Associados::where('funcionario', 1)->whereMonth('data_nascimento', $request->mes)->where('id', '<>', 1)->select('nome', 'data_nascimento')->orderByRaw('day(data_nascimento) asc')->get();
        Atividades::create([
          'nome' => 'Geração de relatório de aniversariantes',
          'descricao' => 'Você gerou o relatório de aniversariantes do mês '.$request->mes.'.',
          'icone' => 'mdi-file-document',
          'url' => route('exibir.aniversariantes.administrativo'),
          'id_usuario' => Auth::id()
        ]);

        $pdf = PDF::loadView('administrativo.aniversariantes.relatorio-paisagem', compact('result'))->setPaper('a4', 'landscape');
        return $pdf->stream();

      }else{
        $result = Associados::where('funcionario', 1)->whereMonth('data_nascimento', $request->mes)->where('id', '<>', 1)->select('nome', 'data_nascimento')->orderByRaw('day(data_nascimento) asc')->get();
        Atividades::create([
          'nome' => 'Geração de relatório de aniversariantes',
          'descricao' => 'Você gerou o relatório de aniversariantes do mês '.$request->mes.'.',
          'icone' => 'mdi-file-document',
          'url' => route('exibir.aniversariantes.administrativo'),
          'id_usuario' => Auth::id()
        ]);


        $pdf = PDF::loadView('administrativo.aniversariantes.relatorio-retrato', compact('result'))->setPaper('a4', 'portrait');
        return $pdf->stream();

      }
    }else{
      return redirect(route('403'));
    }
  }
}
