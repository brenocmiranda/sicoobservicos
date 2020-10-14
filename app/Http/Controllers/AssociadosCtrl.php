<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Associados;

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

}
