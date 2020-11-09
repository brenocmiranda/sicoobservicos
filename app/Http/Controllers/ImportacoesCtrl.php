<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Imports\cli_associados;
use App\Imports\cli_emails;
use App\Imports\cli_telefones;
use App\Imports\cli_enderecos;
use App\Imports\cca_contacapital;
use App\Imports\cco_contacorrente;
use App\Imports\crt_cartaocredito;
use App\Imports\cli_conglomerados;
use App\Imports\cre_contratos;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Associados;
use App\Models\Emails;
use App\Models\Telefones;
use App\Models\Enderecos;
use App\Models\Conglomerados;
use App\Models\ContaCapital;
use App\Models\ContaCorrente;
use App\Models\Contratos;
use App\Models\CartoesCredito;
use App\Models\Logs;

class ImportacoesCtrl extends Controller
{
   	public function __construct(){
		$this->middleware('auth');
	}

    // Exibindo items de importação
	public function Exibir(){
		$cli_associados = Associados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_emails = Emails::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_telefones = Telefones::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_enderecos = Enderecos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cca_contacapital = Conglomerados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cco_contacorrente = ContaCapital::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$crt_cartaocredito = ContaCorrente::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_conglomerados = Contratos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cre_contratos = CartoesCredito::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		return view('configuracoes.importacoes.manual')->with('cli_associados', $cli_associados)->with('cli_emails', $cli_emails)->with('cli_enderecos', $cli_enderecos)->with('cli_telefones', $cli_telefones)->with('cca_contacapital', $cca_contacapital)->with('cco_contacorrente', $cco_contacorrente)->with('crt_cartaocredito', $crt_cartaocredito)->with('cli_conglomerados', $cli_conglomerados)->with('cre_contratos', $cre_contratos);
	}

	// Importação manual dos arquivos
	public function Importar(Request $request){

		return (new HeadingRowImport)->toArray($request->cre_contratos);

		if ($request->hasFile('cli_associados') || $request->hasFile('cli_emails') || $request->hasFile('cli_telefones') || $request->hasFile('cli_enderecos')){
			Logs::create(['mensagem' => 'Importação manual executada.']);
			// cli_associados
			if($request->hasFile('cli_associados') && $request->file('cli_associados')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_associados.xlsx.']);
				$nameFile = 'cli_associados-'.date('dmYHis').'.'.request()->file('cli_associados')->getClientOriginalExtension();
				$upload = $request->cli_associados->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_associados.xlsx...']);
				Excel::import(new cli_associados, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_associados.xlsx efetuada com sucesso!</span>']);
			}
			// cli_emails
			if($request->hasFile('cli_emails') && $request->file('cli_emails')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_emails.xlsx.']);
				$nameFile = 'cli_emails-'.date('dmYHis').'.'.request()->file('cli_emails')->getClientOriginalExtension();
				$upload = $request->cli_emails->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_emails.xlsx...']);
				Excel::import(new cli_emails, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_emails.xlsx efetuada com sucesso!</span>']);
			}
			// cli_telefones
			if($request->hasFile('cli_telefones') && $request->file('cli_telefones')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_telefones.xlsx.']);
				$nameFile = 'cli_telefones-'.date('dmYHis').'.'.request()->file('cli_telefones')->getClientOriginalExtension();
				$upload = $request->cli_telefones->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_telefones.xlsx...']);
				Excel::import(new cli_telefones, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_telefones.xlsx efetuada com sucesso!</span>']);
			}
			// cli_conglomerados
			if($request->hasFile('cli_conglomerados') && $request->file('cli_conglomerados')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_conglomerados.xlsx.']);
				$nameFile = 'cli_conglomerados-'.date('dmYHis').'.'.request()->file('cli_conglomerados')->getClientOriginalExtension();
				$upload = $request->cli_conglomerados->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_conglomerados.xlsx...']);
				Excel::import(new cli_conglomerados, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_conglomerados.xlsx efetuada com sucesso!</span>']);
			}
			// cca_contacapital
			if($request->hasFile('cca_contacapital') && $request->file('cca_contacapital')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cca_contacapital.xlsx.']);
				$nameFile = 'cca_contacapital-'.date('dmYHis').'.'.request()->file('cca_contacapital')->getClientOriginalExtension();
				$upload = $request->cca_contacapital->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cca_contacapital.xlsx...']);
				Excel::import(new cca_contacapital, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_enderecos.xlsx efetuada com sucesso!</span>']);
			}
			// cco_contacorrente
			if($request->hasFile('cco_contacorrente') && $request->file('cco_contacorrente')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cco_contacorrente.xlsx.']);
				$nameFile = 'cco_contacorrente-'.date('dmYHis').'.'.request()->file('cco_contacorrente')->getClientOriginalExtension();
				$upload = $request->cco_contacorrente->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cco_contacorrente.xlsx...']);
				Excel::import(new cco_contacorrente, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cco_contacorrente.xlsx efetuada com sucesso!</span>']);
			}
			// cre_contratos
			if($request->hasFile('cre_contratos') && $request->file('cre_contratos')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cre_contratos.xlsx.']);
				$nameFile = 'cre_contratos-'.date('dmYHis').'.'.request()->file('cre_contratos')->getClientOriginalExtension();
				$upload = $request->cre_contratos->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cre_contratos.xlsx...']);
				Excel::import(new cre_contratos, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_contratos.xlsx efetuada com sucesso!</span>']);
			}
			// crt_cartaocredito
			if($request->hasFile('crt_cartaocredito') && $request->file('crt_cartaocredito')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo crt_cartaocredito.xlsx.']);
				$nameFile = 'crt_cartaocredito-'.date('dmYHis').'.'.request()->file('crt_cartaocredito')->getClientOriginalExtension();
				$upload = $request->crt_cartaocredito->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo crt_cartaocredito.xlsx...']);
				Excel::import(new crt_cartaocredito, getcwd().'/storage/app/importacoes/'.$nameFile);
				Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de crt_cartaocredito.xlsx efetuada com sucesso!</span>']);
			}
			return response()->json(true);
		}else{
			return response()->json(false);
		}
	}

	// Importação automática
	public function ImportarAutomatica(){
		$path = "//SICOOB_SERVICE/outlook";
		$diretorio = dir($path);

		// Copiando os arquivos para pasta de importação e removendo os existentes do outlook
		while($arquivo = $diretorio->read()){
			// Criando pasta de importação ou verificando se existe
			if(!(getcwd().'/storage/app/importacoes')){
				mkdir(getcwd().'/storage/app/importacoes', 0755);
			}
			// cli_associados
			if($arquivo == 'cli_associados.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cli_associados.xlsx.']);
	            $nameFile = 'cli_associados'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_associados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_associados.xlsx');
	            Logs::create(['mensagem' => 'Processando o arquivo cli_associados.xlsx...']);
	            Excel::import(new cli_associados, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_associados.xlsx efetuada com sucesso!</span>']);
			}
			// cli_emails
			if($arquivo == 'cli_emails.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cli_emails.xlsx.']);
	            $nameFile = 'cli_emails'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_emails.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_emails.xlsx');
	            Logs::create(['mensagem' => 'Processando o arquivo cli_emails.xlsx...']);
	            Excel::import(new cli_emails, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_emails.xlsx efetuada com sucesso!</span>']);
			}
			// cli_telefones
			if($arquivo == 'cli_telefones.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cli_telefones.xlsx.']);
	            $nameFile = 'cli_telefones'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_telefones.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_telefones.xlsx');
	            Logs::create(['mensagem' => 'Processando o arquivo cli_telefones.xlsx...']);
	            Excel::import(new cli_telefones, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_telefones.xlsx efetuada com sucesso!</span>']);
			}
			// cli_enderecos
			if($arquivo == 'cli_enderecos.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cli_enderecos.xlsx.']);
	            $nameFile = 'cli_enderecos'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_enderecos.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_enderecos.xlsx');
	           	Logs::create(['mensagem' => 'Processando o arquivo cli_enderecos.xlsx...']);
	            Excel::import(new cli_enderecos, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_enderecos.xlsx efetuada com sucesso!</span>']);
			}
			// cli_conglomerados
			if($arquivo == 'cli_conglomerados.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cli_conglomerados.xlsx.']);
	            $nameFile = 'cli_conglomerados'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cli_conglomerados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cli_conglomerados.xlsx');
	           	Logs::create(['mensagem' => 'Processando o arquivo cli_conglomerados.xlsx...']);
	            Excel::import(new cli_conglomerados, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_conglomerados.xlsx efetuada com sucesso!</span>']);
			}// cca_contacapital
			if($arquivo == 'cca_contacapital.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cca_contacapital.xlsx.']);
	            $nameFile = 'cca_contacapital'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cca_contacapital.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cca_contacapital.xlsx');
	           	Logs::create(['mensagem' => 'Processando o arquivo cca_contacapital.xlsx...']);
	            Excel::import(new cca_contacapital, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cca_contacapital.xlsx efetuada com sucesso!</span>']);
			}
			// cco_contacorrente
			if($arquivo == 'cco_contacorrente.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cco_contacorrente.xlsx.']);
	            $nameFile = 'cco_contacorrente'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cco_contacorrente.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cco_contacorrente.xlsx');
	           	Logs::create(['mensagem' => 'Processando o arquivo cco_contacorrente.xlsx...']);
	            Excel::import(new cco_contacorrente, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cco_contacorrente.xlsx efetuada com sucesso!</span>']);
			}
			// cre_contratos
			if($arquivo == 'cre_contratos.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo cre_contratos.xlsx.']);
	            $nameFile = 'cre_contratos'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/cre_contratos.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/cre_contratos.xlsx');
	           	Logs::create(['mensagem' => 'Processando o arquivo cre_contratos.xlsx...']);
	            Excel::import(new cre_contratos, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_contratos.xlsx efetuada com sucesso!</span>']);
			}
			// crt_cartaocredito
			if($arquivo == 'crt_cartaocredito.xlsx'){
				Logs::create(['mensagem' => 'Importação automática executada.']);
				Logs::create(['mensagem' => 'Localizado arquivo crt_cartaocredito.xlsx.']);
	            $nameFile = 'crt_cartaocredito'.date('dmY-His').'.xlsx';
	            copy('//SICOOB_SERVICE/outlook/crt_cartaocredito.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
	            unlink('//SICOOB_SERVICE/outlook/crt_cartaocredito.xlsx');
	           	Logs::create(['mensagem' => 'Processando o arquivo crt_cartaocredito.xlsx...']);
	            Excel::import(new crt_cartaocredito, getcwd().'/storage/app/importacoes/'.$nameFile);
	            Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de crt_cartaocredito.xlsx efetuada com sucesso!</span>']);
			}
		}
		$diretorio->close();
	}

	// Exibindo os logs de impotação
	public function ExibirLogs(){
		$logs = Logs::orderBy('id', 'DESC')->paginate(20);
		return view('configuracoes.importacoes.logs')->with('logs', $logs);
	}
}
