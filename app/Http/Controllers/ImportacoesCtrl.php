<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Imports\AssociadosImport;
use App\Imports\EmailsImport;
use App\Imports\TelefonesImport;
use App\Imports\EnderecosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Associados;
use App\Models\Emails;
use App\Models\Telefones;
use App\Models\Enderecos;
use Maatwebsite\Excel\HeadingRowImport;

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

		if (!empty($request->except('_token')[0])){
			return response()->json(['success' => 'true']);
		}else{
			return response()->json(['success' => 'false']);
		}
		return redirect(route('exibir.importacoes'));
	}


	// Importação automática
	public function ImportarAutomatica(){
		$client = Client::account('default');
		$client->connect();
		$folders = $client->getFolders();

		foreach($folders as $folder){
            $messages = $folder->messages()->all()->get();
            foreach($messages as $message){
                if ($message->getSubject() == 'cli_associados'){
                	$attachments = $message->getAttachments(); 
	                foreach($attachments as $attachment){
	                   	$attachment->save(getcwd().'/storage/app/importacoes/'); 
	                   	Excel::import(new AssociadosImport, getcwd().'/storage/app/cli_associados.xlsx');
	                }
            	}
            	if ($message->getSubject() == 'cli_emails'){
                	$attachments = $message->getAttachments(); 
	                foreach($attachments as $attachment){
	                   	$attachment->save(getcwd().'/storage/app/importacoes/'); 
	                   	Excel::import(new AssociadosImport, getcwd().'/storage/app/cli_emails.xlsx');
	                }
            	}
            	if ($message->getSubject() == 'cli_telefones'){
                	$attachments = $message->getAttachments(); 
	                foreach($attachments as $attachment){
	                   	$attachment->save(getcwd().'/storage/app/importacoes/'); 
	                   	Excel::import(new AssociadosImport, getcwd().'/storage/app/cli_telefones.xlsx');
	                }
            	}
            	if ($message->getSubject() == 'cli_enderecos'){
                	$attachments = $message->getAttachments(); 
	                foreach($attachments as $attachment){
	                   	$attachment->save(getcwd().'/storage/app/importacoes/'); 
	                   	Excel::import(new AssociadosImport, getcwd().'/storage/app/cli_enderecos.xlsx');
	                }
            	}
            }
        }
		return response()->json(['success' => 'true']);
	}
}
