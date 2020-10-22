<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Imports\AssociadosImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportacoesCtrl extends Controller
{
   	public function __construct(){
		$this->middleware('auth');
	}

    // Listando todos os instituições
	public function Exibir(){
		return view('gestao.importacoes');
	}

	// Listando todos os instituições
	public function Importar(Request $request){
		// Recuperando nome
		// return request()->file('cli_associados')->getClientOriginalName();
		// Recuperando a extensão
		// return request()->file('cli_associados')->getClientOriginalExtension();

		Excel::import(new AssociadosImport, request()->file('cli_associados'));
		\Session::flash('upload', array(
				'class' => 'success',
				'mensagem' => 'Importação dos arquivos executadas com sucesso!'
			));
		return redirect(route('exibir.importacoes'));
	}

	// Importação automática
	public function Importar(Request $request){

		$client = Client::account('default');
		$client->connect();
		$folders = $client->getFolders();

		foreach($folders as $folder){
            $messages = $folder->messages()->all()->get();

            foreach($messages as $message){
                if ($message->getSubject() == 'cli_associados'){
                	$attachments = $message->getAttachments(); 
	                foreach($attachments as $attachment){
	                   $attachment->save("C:/wamp64/www/sicoob/backup/"); 
	                }
            	}
            }
        }

		Excel::import(new AssociadosImport, 'C:/wamp64/www/sicoob/backup/cli_associados.xlsx');
		return response()->json(['success' = 'true']);
	}
}
