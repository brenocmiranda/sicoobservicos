<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Imports\cli_associados;
use App\Imports\cli_consolidado;
use App\Imports\cli_emails;
use App\Imports\cli_telefones;
use App\Imports\cli_enderecos;
use App\Imports\cli_conglomerados;
use App\Imports\cli_bacen;
use App\Imports\cli_iap;
use App\Imports\cca_contacapital;
use App\Imports\cco_contacorrente;
use App\Imports\crt_cartaocredito;
use App\Imports\pop_poupanca;
use App\Imports\dep_aplicacoes;
use App\Imports\cre_contratos;
use App\Imports\cre_avalistas;
use App\Imports\cre_garantias;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Associados;
use App\Models\AssociadosConsolidado;
use App\Models\AssociadosBacen;
use App\Models\AssociadosIAPs;
use App\Models\AssociadosEmails;
use App\Models\AssociadosTelefones;
use App\Models\AssociadosEnderecos;
use App\Models\AssociadosConglomerados;
use App\Models\ContaCapital;
use App\Models\ContaCorrente;
use App\Models\Contratos;
use App\Models\Avalistas;
use App\Models\Garantias;
use App\Models\CartaoCredito;
use App\Models\Poupancas;
use App\Models\Aplicacoes;
use App\Models\Logs;

class ImportacoesCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    // Exibindo items de importação
	public function Exibir(){
		$cli_associados = Associados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_consolidado = AssociadosConsolidado::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_emails = AssociadosEmails::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_telefones = AssociadosTelefones::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_enderecos = AssociadosEnderecos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_conglomerados = AssociadosConglomerados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cca_contacapital = ContaCapital::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cco_contacorrente = ContaCorrente::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cre_contratos = Contratos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$crt_cartaocredito = CartaoCredito::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$pop_poupanca = Poupancas::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$dep_aplicacoes = Aplicacoes::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_iap = AssociadosIAPs::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_bacen = AssociadosBacen::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cre_avalistas = Avalistas::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cre_garantias = Garantias::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		return view('configuracoes.importacoes.manual')->with('cli_associados', $cli_associados)->with('cli_consolidado', $cli_consolidado)->with('cli_emails', $cli_emails)->with('cli_enderecos', $cli_enderecos)->with('cli_telefones', $cli_telefones)->with('cca_contacapital', $cca_contacapital)->with('cco_contacorrente', $cco_contacorrente)->with('crt_cartaocredito', $crt_cartaocredito)->with('cli_conglomerados', $cli_conglomerados)->with('cre_contratos', $cre_contratos)->with('pop_poupanca', $pop_poupanca)->with('dep_aplicacoes', $dep_aplicacoes)->with('cli_iap', $cli_iap)->with('cli_bacen', $cli_bacen)->with('cre_avalistas', $cre_avalistas)->with('cre_garantias', $cre_garantias);
	}

	// Importação manual dos arquivos
	public function Importar(Request $request){

		//return (new HeadingRowImport)->toArray($request->cre_avalistas);

		if ($request->hasFile('cli_associados') || $request->hasFile('cli_consolidado') || $request->hasFile('cli_emails') || $request->hasFile('cli_telefones') || $request->hasFile('cli_enderecos') || $request->hasFile('cli_conglomerados') || $request->hasFile('cca_contacapital') || $request->hasFile('cco_contacorrente') || $request->hasFile('cre_contratos') || $request->hasFile('crt_cartaocredito') || $request->hasFile('pop_poupanca') || $request->hasFile('dep_aplicacoes') || $request->hasFile('cli_iap') || $request->hasFile('cli_bacen') || $request->hasFile('cre_avalistas') || $request->hasFile('cre_garantias')){
			// Criando pasta de importação ou verificando se existe
			if(!(getcwd().'/storage/app/importacoes')){
				mkdir(getcwd().'/storage/app/importacoes', 0755);
			}
			// Criando log de importação
			Logs::create(['mensagem' => 'Importação manual executada.']);
			// cli_associados
			if($request->hasFile('cli_associados') && $request->file('cli_associados')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_associados.xlsx.']);
				$nameFile = 'cli_associados-'.date('dmYHis').'.'.request()->file('cli_associados')->getClientOriginalExtension();
				$upload = $request->cli_associados->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_associados.xlsx...']);
				try{
					Excel::import(new cli_associados, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_associados.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_associados.xlsx!</span>']);
				}
			}
			// cli_consolidado
			if($request->hasFile('cli_consolidado') && $request->file('cli_consolidado')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_consolidado.xlsx.']);
				$nameFile = 'cli_consolidado-'.date('dmYHis').'.'.request()->file('cli_consolidado')->getClientOriginalExtension();
				$upload = $request->cli_consolidado->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_consolidado.xlsx...']);
				try{
					Excel::import(new cli_consolidado, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_consolidado.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_consolidado.xlsx!</span>']);
				}
			}
			// cli_emails
			if($request->hasFile('cli_emails') && $request->file('cli_emails')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_emails.xlsx.']);
				$nameFile = 'cli_emails-'.date('dmYHis').'.'.request()->file('cli_emails')->getClientOriginalExtension();
				$upload = $request->cli_emails->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_emails.xlsx...']);
				try{
					Excel::import(new cli_emails, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_emails.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_emails.xlsx!</span>']);
				}
			}
			// cli_telefones
			if($request->hasFile('cli_telefones') && $request->file('cli_telefones')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_telefones.xlsx.']);
				$nameFile = 'cli_telefones-'.date('dmYHis').'.'.request()->file('cli_telefones')->getClientOriginalExtension();
				$upload = $request->cli_telefones->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_telefones.xlsx...']);
				try{
					Excel::import(new cli_telefones, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_telefones.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_telefones.xlsx!</span>']);
				}
			}
			// cli_enderecos
			if($request->hasFile('cli_enderecos') && $request->file('cli_enderecos')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_enderecos.xlsx.']);
				$nameFile = 'cli_enderecos-'.date('dmYHis').'.'.request()->file('cli_enderecos')->getClientOriginalExtension();
				$upload = $request->cli_enderecos->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_enderecos.xlsx...']);
				try{
					Excel::import(new cli_enderecos, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_enderecos.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_enderecos.xlsx!</span>']);
					
				}
			}
			// cli_conglomerados
			if($request->hasFile('cli_conglomerados') && $request->file('cli_conglomerados')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_conglomerados.xlsx.']);
				$nameFile = 'cli_conglomerados-'.date('dmYHis').'.'.request()->file('cli_conglomerados')->getClientOriginalExtension();
				$upload = $request->cli_conglomerados->storeAs('importacoes', $nameFile);
				try{
					Logs::create(['mensagem' => 'Processando o arquivo cli_conglomerados.xlsx...']);
					Excel::import(new cli_conglomerados, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_conglomerados.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_conglomerados.xlsx!</span>']);
					
				}
			}
			// cca_contacapital
			if($request->hasFile('cca_contacapital') && $request->file('cca_contacapital')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cca_contacapital.xlsx.']);
				$nameFile = 'cca_contacapital-'.date('dmYHis').'.'.request()->file('cca_contacapital')->getClientOriginalExtension();
				$upload = $request->cca_contacapital->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cca_contacapital.xlsx...']);
				try{
					Excel::import(new cca_contacapital, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cca_contacapital.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cca_contacapital.xlsx!</span>']);
					
				}
			}
			// cco_contacorrente
			if($request->hasFile('cco_contacorrente') && $request->file('cco_contacorrente')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cco_contacorrente.xlsx.']);
				$nameFile = 'cco_contacorrente-'.date('dmYHis').'.'.request()->file('cco_contacorrente')->getClientOriginalExtension();
				$upload = $request->cco_contacorrente->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cco_contacorrente.xlsx...']);
				try{
					Excel::import(new cco_contacorrente, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cco_contacorrente.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cco_contacorrente.xlsx!</span>']);
					
				}
			}
			// cre_contratos
			if($request->hasFile('cre_contratos') && $request->file('cre_contratos')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cre_contratos.xlsx.']);
				$nameFile = 'cre_contratos-'.date('dmYHis').'.'.request()->file('cre_contratos')->getClientOriginalExtension();
				$upload = $request->cre_contratos->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cre_contratos.xlsx...']);
				Excel::import(new cre_contratos, getcwd().'/storage/app/importacoes/'.$nameFile);
				try{
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_contratos.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos.xlsx!</span>']);
					
				}
			}
			// crt_cartaocredito
			if($request->hasFile('crt_cartaocredito') && $request->file('crt_cartaocredito')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo crt_cartaocredito.xlsx.']);
				$nameFile = 'crt_cartaocredito-'.date('dmYHis').'.'.request()->file('crt_cartaocredito')->getClientOriginalExtension();
				$upload = $request->crt_cartaocredito->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo crt_cartaocredito.xlsx...']);
				try{
					Excel::import(new crt_cartaocredito, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de crt_cartaocredito.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo crt_cartaocredito.xlsx!</span>']);
					
				}
			}
			// pop_poupanca
			if($request->hasFile('pop_poupanca') && $request->file('pop_poupanca')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo pop_poupanca.xlsx.']);
				$nameFile = 'pop_poupanca-'.date('dmYHis').'.'.request()->file('pop_poupanca')->getClientOriginalExtension();
				$upload = $request->pop_poupanca->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo pop_poupanca.xlsx...']);
				try{
					Excel::import(new pop_poupanca, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pop_poupanca.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pop_poupanca.xlsx!</span>']);
					
				}
			}
			// dep_aplicacoes
			if($request->hasFile('dep_aplicacoes') && $request->file('dep_aplicacoes')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo dep_aplicacoes.xlsx.']);
				$nameFile = 'dep_aplicacoes-'.date('dmYHis').'.'.request()->file('dep_aplicacoes')->getClientOriginalExtension();
				$upload = $request->dep_aplicacoes->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo dep_aplicacoes.xlsx...']);
				try{
					Excel::import(new dep_aplicacoes, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de dep_aplicacoes.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo dep_aplicacoes.xlsx!</span>']);
					
				}
			}
			// cli_iap
			if($request->hasFile('cli_iap') && $request->file('cli_iap')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_iap.xlsx.']);
				$nameFile = 'cli_iap-'.date('dmYHis').'.'.request()->file('cli_iap')->getClientOriginalExtension();
				$upload = $request->cli_iap->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_iap.xlsx...']);
				try{
					Excel::import(new cli_iap, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_iap.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_iap.xlsx!</span>']);
					
				}
			}
			// cli_bacen
			if($request->hasFile('cli_bacen') && $request->file('cli_bacen')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cli_bacen.xlsx.']);
				$nameFile = 'cli_bacen-'.date('dmYHis').'.'.request()->file('cli_bacen')->getClientOriginalExtension();
				$upload = $request->cli_bacen->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cli_bacen.xlsx...']);
				try{
					Excel::import(new cli_bacen, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_bacen.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_bacen.xlsx!</span>']);
					
				}
			}
			// cre_avalistas
			if($request->hasFile('cre_avalistas') && $request->file('cre_avalistas')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cre_avalistas.xlsx.']);
				$nameFile = 'cre_avalistas-'.date('dmYHis').'.'.request()->file('cre_avalistas')->getClientOriginalExtension();
				$upload = $request->cre_avalistas->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cre_avalistas.xlsx...']);
				try{
					Excel::import(new cre_avalistas, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_avalistas.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_avalistas.xlsx!</span>']);
					
				}
			}
			// cre_garantias
			if($request->hasFile('cre_garantias') && $request->file('cre_garantias')->isValid()){
				Logs::create(['mensagem' => 'Localizado arquivo cre_garantias.xlsx.']);
				$nameFile = 'cre_garantias-'.date('dmYHis').'.'.request()->file('cre_garantias')->getClientOriginalExtension();
				$upload = $request->cre_garantias->storeAs('importacoes', $nameFile);
				Logs::create(['mensagem' => 'Processando o arquivo cre_garantias.xlsx...']);
				try{
					Excel::import(new cre_garantias, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_garantias.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_garantias.xlsx!</span>']);
					
				}
			}
			return response()->json(true);
		}else{
			return response()->json(false);
		}
	}

	// Importação automática
	public function ImportarAutomatica(){
		$path = "outlook";
		$diretorio = dir($path);
		$count = 0;
		// Copiando os arquivos para pasta de importação e removendo os existentes do outlook
		while($arquivo = $diretorio->read()){
			$count++;
			// Criando pasta de importação ou verificando se existe
			if(!(getcwd().'/storage/app/importacoes')){
				mkdir(getcwd().'/storage/app/importacoes', 0755);
			}
			// Criando log de importação
			if($count == 1){
				Logs::create(['mensagem' => 'Importação automática executada.']);
			}
			// cli_associados
			if($arquivo == 'cli_associados.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_associados.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_associados.xlsx...']);
				$nameFile = 'cli_associados'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_associados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_associados.xlsx');
					Excel::import(new cli_associados, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_associados.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_associados.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_associados.xlsx!</span>']);
				}
			}
			// cli_consolidado
			if($arquivo == 'cli_consolidado.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_consolidado.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_consolidado.xlsx...']);
				$nameFile = 'cli_consolidado'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_consolidado.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_consolidado.xlsx');
					Excel::import(new cli_consolidado, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_consolidado.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_consolidado.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_consolidado.xlsx!</span>']);
				}
			}
			// cli_emails
			if($arquivo == 'cli_emails.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_emails.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_emails.xlsx...']);
				$nameFile = 'cli_emails'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_emails.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_emails.xlsx');
					Excel::import(new cli_emails, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_emails.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_emails.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_emails.xlsx!</span>']);
				}
			}
			// cli_telefones
			if($arquivo == 'cli_telefones.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_telefones.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_telefones.xlsx...']);
				$nameFile = 'cli_telefones'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_telefones.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_telefones.xlsx');
					Excel::import(new cli_telefones, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_telefones.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_telefones.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_telefones.xlsx!</span>']);
				}
			}
			// cli_enderecos
			if($arquivo == 'cli_enderecos.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_enderecos.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_enderecos.xlsx...']);
				$nameFile = 'cli_enderecos'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_enderecos.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_enderecos.xlsx');
					Excel::import(new cli_enderecos, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_enderecos.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_enderecos.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_enderecos.xlsx!</span>']);
				}
			}
			// cli_conglomerados
			if($arquivo == 'cli_conglomerados.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_conglomerados.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_conglomerados.xlsx...']);
				$nameFile = 'cli_conglomerados'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_conglomerados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_conglomerados.xlsx');
					Excel::import(new cli_conglomerados, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_conglomerados.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_conglomerados.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_conglomerados.xlsx!</span>']);
				}
			}
			// cli_iap
			if($arquivo == 'cli_iap.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_iap.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_iap.xlsx...']);
				$nameFile = 'cli_iap'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_iap.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_iap.xlsx');
					Excel::import(new cli_iap, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_iap.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_iap.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_iap.xlsx!</span>']);
				}
			}
			// cca_contacapital
			if($arquivo == 'cca_contacapital.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cca_contacapital.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cca_contacapital.xlsx...']);
				$nameFile = 'cca_contacapital'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cca_contacapital.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cca_contacapital.xlsx');
					Excel::import(new cca_contacapital, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cca_contacapital.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cca_contacapital.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cca_contacapital.xlsx!</span>']);
				}
			}
			// cco_contacorrente
			if($arquivo == 'cco_contacorrente.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cco_contacorrente.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cco_contacorrente.xlsx...']);
				$nameFile = 'cco_contacorrente'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cco_contacorrente.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cco_contacorrente.xlsx');
					Excel::import(new cco_contacorrente, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cco_contacorrente.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cco_contacorrente.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cco_contacorrente.xlsx!</span>']);
				}
			}
			// cre_contratos
			if($arquivo == 'cre_contratos.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cre_contratos.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cre_contratos.xlsx...']);
				$nameFile = 'cre_contratos'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cre_contratos.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cre_contratos.xlsx');
					Excel::import(new cre_contratos, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_contratos.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cre_contratos.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos.xlsx!</span>']);
				}
			}
			// crt_cartaocredito
			if($arquivo == 'crt_cartaocredito.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo crt_cartaocredito.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo crt_cartaocredito.xlsx...']);
				$nameFile = 'crt_cartaocredito'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/crt_cartaocredito.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/crt_cartaocredito.xlsx');
					Excel::import(new crt_cartaocredito, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de crt_cartaocredito.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/crt_cartaocredito.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo crt_cartaocredito.xlsx!</span>']);
				}
			}
			// pop_poupanca
			if($arquivo == 'pop_poupanca.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo pop_poupanca.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo pop_poupanca.xlsx...']);
				$nameFile = 'pop_poupanca'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/pop_poupanca.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/pop_poupanca.xlsx');
					Excel::import(new pop_poupanca, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pop_poupanca.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/pop_poupanca.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pop_poupanca.xlsx!</span>']);
				}
			}
			// dep_aplicacoes
			if($arquivo == 'dep_aplicacoes.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo dep_aplicacoes.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo dep_aplicacoes.xlsx...']);
				$nameFile = 'dep_aplicacoes'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/dep_aplicacoes.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/dep_aplicacoes.xlsx');
					Excel::import(new dep_aplicacoes, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de dep_aplicacoes.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/dep_aplicacoes.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo dep_aplicacoes.xlsx!</span>']);
				}
			}
			// cli_bacen
			if($arquivo == 'cli_bacen.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cli_bacen.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cli_bacen.xlsx...']);
				$nameFile = 'cli_bacen'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cli_bacen.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_bacen.xlsx');
					Excel::import(new cli_bacen, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_bacen.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cli_bacen.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_bacen.xlsx!</span>']);
				}
			}
			// cre_avalistas
			if($arquivo == 'cre_avalistas.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cre_avalistas.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cre_avalistas.xlsx...']);
				$nameFile = 'cre_avalistas'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cre_avalistas.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cre_avalistas.xlsx');
					Excel::import(new cre_avalistas, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_avalistas.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cre_avalistas.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_avalistas.xlsx!</span>']);
				}
			}	
			// cre_garantias
			if($arquivo == 'cre_garantias.xlsx'){
				Logs::create(['mensagem' => 'Localizado arquivo cre_garantias.xlsx.']);
				Logs::create(['mensagem' => 'Processando o arquivo cre_garantias.xlsx...']);
				$nameFile = 'cre_garantias'.date('dmY-His').'.xlsx';
				try{
					copy(getcwd().'/outlook/cre_garantias.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cre_garantias.xlsx');
					Excel::import(new cre_garantias, getcwd().'/storage/app/importacoes/'.$nameFile);
					Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_garantias.xlsx efetuada com sucesso!</span>']);
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, 'C:/wamp64/www/sicoob/outlook/cre_garantias.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_garantias.xlsx!</span>']);
				}
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
