<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Imports\AssociadosImport;
use App\Imports\EmailsImport;
use App\Imports\TelefonesImport;
use App\Imports\EnderecosImport;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Associados;
use App\Models\Emails;
use App\Models\Telefones;
use App\Models\Enderecos;

class ImportacoesCtrl extends Controller
{
   	public function __construct(){
		$this->middleware('auth');
	}

    // Exibindo items de importação
	public function Exibir(){
		$dBaseAssociado = Associados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$dBaseEmails = Emails::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$dBaseTelefones = Telefones::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$dBaseEnderecos = Enderecos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		return view('configuracoes.importacoes')->with('dBaseAssociado', $dBaseAssociado)->with('dBaseEmails', $dBaseEmails)->with('dBaseTelefones', $dBaseTelefones)->with('dBaseEnderecos', $dBaseEnderecos);
	}

	// Importação manual dos arquivos
	public function Importar(Request $request){
		if ($request->hasFile('cli_associados') || $request->hasFile('cli_emails') || $request->hasFile('cli_telefones') || $request->hasFile('cli_enderecos')){
			// cli_associados
			if($request->hasFile('cli_associados') && $request->file('cli_associados')->isValid()){
				$nameFile = 'cli_associados-'.date('dmYHis').'.'.request()->file('cli_associados')->getClientOriginalExtension();
				$upload = $request->cli_associados->storeAs('importacoes', $nameFile);
				Excel::import(new AssociadosImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}
			// cli_emails
			if($request->hasFile('cli_emails') && $request->file('cli_emails')->isValid()){
				$nameFile = 'cli_emails-'.date('dmYHis').'.'.request()->file('cli_emails')->getClientOriginalExtension();
				$upload = $request->cli_emails->storeAs('importacoes', $nameFile);
				Excel::import(new EmailsImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}
			// cli_telefones
			if($request->hasFile('cli_telefones') && $request->file('cli_telefones')->isValid()){
				$nameFile = 'cli_telefones-'.date('dmYHis').'.'.request()->file('cli_telefones')->getClientOriginalExtension();
				$upload = $request->cli_telefones->storeAs('importacoes', $nameFile);
				Excel::import(new TelefonesImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}
			// cli_enderecos
			if($request->hasFile('cli_enderecos') && $request->file('cli_enderecos')->isValid()){
				$nameFile = 'cli_enderecos-'.date('dmYHis').'.'.request()->file('cli_enderecos')->getClientOriginalExtension();
				$upload = $request->cli_enderecos->storeAs('importacoes', $nameFile);
				Excel::import(new EnderecosImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}

			// Demais importações

			return response()->json(true);
		}else{
			return response()->json(false);
		}
		return redirect(route('exibir.importacoes'));
	}


	// Importação automática
	public function ImportarAutomatica(){
		$path = "//SICOOB_SERVICE/outlook";
		$diretorio = dir($path);

		// Copiando os arquivos para pasta de importação e removendo os existentes do outlook
		while($arquivo = $diretorio->read()){
			// cli_associados
			if($arquivo == 'cli_associados.xlsx'){
				if(!(getcwd().'/storage/app/importacoes')){
					mkdir(getcwd().'/storage/app/importacoes', 0755);
				}
	            $nameFile = 'cli_associados'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_associados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_associados.xlsx');
	            Excel::import(new AssociadosImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}
			// cli_emails
			if($arquivo == 'cli_emails.xlsx'){
				if(!(getcwd().'/storage/app/importacoes')){
					mkdir(getcwd().'/storage/app/importacoes', 0755);
				}
	            $nameFile = 'cli_emails'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_emails.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_emails.xlsx');
	            Excel::import(new EmailsImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}
			// cli_telefones
			if($arquivo == 'cli_telefones.xlsx'){
				if(!(getcwd().'/storage/app/importacoes')){
					mkdir(getcwd().'/storage/app/importacoes', 0755);
				}
	            $nameFile = 'cli_telefones'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_telefones.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_telefones.xlsx');
	            Excel::import(new TelefonesImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}
			// cli_enderecos
			if($arquivo == 'cli_enderecos.xlsx'){
				if(!(getcwd().'/storage/app/importacoes')){
					mkdir(getcwd().'/storage/app/importacoes', 0755);
				}
	            $nameFile = 'cli_enderecos'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_enderecos.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_enderecos.xlsx');
	            Excel::import(new EnderecosImport, getcwd().'/storage/app/importacoes/'.$nameFile);
			}
		}
		$diretorio->close();
	}
}
