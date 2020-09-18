<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Materiais;
use App\Models\MateriaisHistorico;
use App\Models\Status;
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
		$materiaisHistorico = MateriaisHistorico::all();
		return view('administrativo.dashboard')->with('materiais', $materiais)->with('materiaisHistorico', $materiaisHistorico);
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
