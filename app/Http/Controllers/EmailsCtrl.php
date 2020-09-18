<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\CogEmailsMaterial;
use App\Models\CogEmailsContrato;
use App\Models\CogEmailsChamado;

class EmailsCtrl extends Controller
{
  	
  	public function __construct(){
		$this->middleware('auth');
	}

	// Exibindo ajustes
	public function ExibirAjustes(){
		$material = CogEmailsMaterial::find(1);
		$contrato = CogEmailsContrato::find(1);
		$chamado = CogEmailsChamado::find(1);
		return view('gestao.emails.ajustes.exibir')->with('material', $material)->with('contrato', $contrato)->with('chamado', $chamado);
	}
	// Alteranndo informações
	public function SalvarAjustes(Request $request){
		CogEmailsMaterial::find(1)->update([
			'email_material' => $request->email_material,
		]);
		CogEmailsContrato::find(1)->update([
			'email_contrato' => $request->email_contrato,
		]);
		CogEmailsChamado::find(1)->update([
			'email_chamado' => $request->email_chamado,
		]);

		\Session::flash('alteracao', array(
				'class' => 'success',
				'mensagem' => 'Seus dados foram alterados com sucesso.'
			));
		return redirect(route('exibir.ajustes.emails'));
	}


	// Exibindo mensagens
	public function ExibirMensagens(){
		$material = CogEmailsMaterial::find(1);
		$contrato = CogEmailsContrato::find(1);
		$chamado = CogEmailsChamado::find(1);
		return view('gestao.emails.mensagens.exibir')->with('material', $material)->with('contrato', $contrato)->with('chamado', $chamado);
	}
	// Alteranndo informações
	public function SalvarMensagens(Request $request){
		CogEmailsMaterial::find(1)->update([
			'assunto_material' => $request->assunto_material,
			'abertura_solicitacao_material' => $request->abertura_solicitacao_material,
			'fechamento_solicitacao_material' => $request->fechamento_solicitacao_material,
		]);
		CogEmailsContrato::find(1)->update([
			'assunto_contrato' => $request->assunto_contrato,
			'abertura_solicitacao_contrato' => $request->abertura_solicitacao_contrato,
			'fechamento_solicitacao_contrato' => $request->fechamento_solicitacao_contrato,
		]);
		CogEmailsChamado::find(1)->update([
			'assunto_chamado' => $request->assunto_chamado,
			'abertura_chamado' => $request->abertura_chamado,
			'fechamento_chamado' => $request->fechamento_chamado,
		]);

		\Session::flash('alteracao', array(
				'class' => 'success',
				'mensagem' => 'Seus dados foram alterados com sucesso.'
			));
		
		return redirect(route('exibir.mensagens.emails'));
	}

}
