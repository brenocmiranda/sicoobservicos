<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Imports\AssociadosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Associados;
use App\Models\Emails;
use App\Models\Telefones;

class ImportacoesCtrl extends Controller
{
   	public function __construct(){
		$this->middleware('auth');
	}

    // Exibindo items de importação
	public function Exibir(){
		$dBaseAssociado = Associados::select('data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$dBaseEmails = Emails::select('data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$dBaseTelefones = Telefones::select('data_movimento')->orderBy('data_movimento', 'DESC')->first();
		return view('gestao.importacoes')->with('dBaseAssociado', $dBaseAssociado)->with('dBaseEmails', $dBaseEmails)->with('dBaseTelefones', $dBaseTelefones);
	}

	// Importação manual dos arquivos
	public function Importar(Request $request){
		// cli_associados
		if($request->hasFile('cli_associados') && $request->isValid()){
			$nameFile = 'cli_associados-'.uniqid(date('HisYmd')).request()->file('cli_associados')->getClientOriginalName();
			$upload = $request->image->storeAs('importacoes', $nameFile);
				Excel::import(new AssociadosImport, getcwd().'/storage/app/importacoes/'.$nameFile);
		}

		// Demais importações

		\Session::flash('upload', array(
				'class' => 'success',
				'mensagem' => 'Importação dos arquivos executadas com sucesso!'
			));
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
	                }
            	}
            }
        }

		Excel::import(new AssociadosImport, getcwd().'/storage/app/cli_associados.xlsx');
		return response()->json(['success' => 'true']);
	}
}
