<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Models\Atividades; 
use App\Models\Imagens; 

class AjustesCtrl extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	// Listando página
	public function Exibir(){
		$login = Imagens::where('tipo', 'login_principal')->get();
		$homepage = Imagens::where('tipo', 'homepage_principal')->get();
		return view('configuracoes.ajustes.geral')->with('login', $login)->with('homepage', $homepage);
	}

	public function Salvar(Request $request){
		 if($request->hasFile('login_principal') && $request->file('login_principal')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension =  $request->login_principal->extension();
            $nameFile = "{$name}.{$extension}";
            $upload =  $request->login_principal->storeAs('papelparede', $nameFile);
            $imagem = Imagens::create(['tipo' => 'login_principal', 'endereco' => $upload]);
        }  

        if($request->hasFile('homepage_principal') && $request->file('homepage_principal')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension =  $request->homepage_principal->extension();
            $nameFile = "{$name}.{$extension}";
            $upload =  $request->homepage_principal->storeAs('papelparede', $nameFile);
            $imagem = Imagens::create(['tipo' => 'homepage_principal', 'endereco' => $upload]);
        }  

        \Session::flash('alteracao', array(
				'class' => 'success',
				'mensagem' => 'Informações foram alteradas com sucesso.'
			));

        return redirect(route('exibir.ajustes'));
	}

}
