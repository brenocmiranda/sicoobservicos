<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 
use App\Models\Materiais;
use App\Models\MateriaisHistorico;
use App\Models\Status;
use App\Models\Bens;
use App\Models\Documentos;
use App\Models\Ativos;
use App\Models\ChamadosStatus;
use App\Models\Chamados;
use App\Models\Homepage;

class DashboardCtrl extends Controller
{	
	public function __construct(){
		$this->middleware('auth');
	}
	
	// Dashboard do ativo
	public function DashAdministrativo(){
		$materiais = Materiais::all();
		$materiaisCategoria = Materiais::join('adm_materiais_categorias', 'id_categoria', 'adm_materiais_categorias.id')->select('id_categoria', 'adm_materiais_categorias.nome', \DB::raw('count(id_categoria) as quantidade'))->groupBy('id_categoria')->where('adm_materiais.status', 1)->get();
		$materiaisHistorico = MateriaisHistorico::all();
		$bens = Bens::all();
		$bensBairro = Bens::whereNotNull('bairro')->select('bairro')->groupBy('bairro')->get();
		$bensCidade = Bens::whereNotNull('cidade')->select('cidade')->groupBy('cidade')->get();
		$documentos = Documentos::all();

		return view('administrativo.dashboard')->with('bens', $bens)->with('bensBairro', $bensBairro)->with('bensCidade', $bensCidade)->with('documentos', $documentos)->with('materiais', $materiais)->with('materiaisHistorico', $materiaisHistorico)->with('materiaisCategoria', $materiaisCategoria);
	}
	
	// Dashboard do ativo
	public function DashCredito(){
		$ativos = Ativos::all();
		$chamados = Chamados::all();
		$homepage = Homepage::all();
		return view('credito.dashboard')->with('ativos', $ativos)->with('homepage', $homepage)->with('chamados', json_encode($chamados));
	}

   	// Dashboard do ativo
	public function DashTecnologia(){
		$ativos = Ativos::all();
		$chamados = Chamados::all();
		$homepage = Homepage::all();
		return view('tecnologia.dashboard')->with('ativos', $ativos)->with('homepage', $homepage)->with('chamados', json_encode($chamados));
	}
}
