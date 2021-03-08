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
use App\Imports\cre_contratos_historico;
use App\Imports\cre_avalistas;
use App\Imports\cre_garantias;
use App\Imports\pro_seguros;
use App\Imports\pro_consorcios;
use App\Imports\pro_previdencias;
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
use App\Models\ContratosAvalistas;
use App\Models\ContratosGarantias;
use App\Models\CartaoCredito;
use App\Models\Poupancas;
use App\Models\Aplicacoes;
use App\Models\ProSeguros;
use App\Models\ProConsorcios;
use App\Models\ProPrevidencias;
use App\Models\Logs;

class ImportacoesCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Database 
	#-------------------------------------------------------------------
	// Exibindo data base do banco de dados
	public function ExibirData(){
		$cli_associados = Associados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_emails = AssociadosEmails::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_telefones = AssociadosTelefones::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_enderecos = AssociadosEnderecos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_conglomerados = AssociadosConglomerados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_consolidado = AssociadosConsolidado::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$cli_iap = AssociadosIAPs::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$cli_bacen = AssociadosBacen::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$cre_contratos = Contratos::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$cre_avalistas = ContratosAvalistas::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$cre_garantias = ContratosGarantias::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$cca_contacapital = ContaCapital::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$cco_contacorrente = ContaCorrente::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$crt_cartaocredito = CartaoCredito::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$pop_poupanca = Poupancas::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$dep_aplicacoes = Aplicacoes::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$pro_seguros = ProSeguros::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$pro_consorcios = ProConsorcios::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();
		$pro_previdencias = ProPrevidencias::select('updated_at', 'data_movimento')->orderBy('data_movimento', 'DESC')->first();

		return view('configuracoes.importacoes.data')->with('cli_associados', $cli_associados)->with('cli_consolidado', $cli_consolidado)->with('cli_emails', $cli_emails)->with('cli_enderecos', $cli_enderecos)->with('cli_telefones', $cli_telefones)->with('cca_contacapital', $cca_contacapital)->with('cco_contacorrente', $cco_contacorrente)->with('crt_cartaocredito', $crt_cartaocredito)->with('cli_conglomerados', $cli_conglomerados)->with('cre_contratos', $cre_contratos)->with('pop_poupanca', $pop_poupanca)->with('dep_aplicacoes', $dep_aplicacoes)->with('cli_iap', $cli_iap)->with('cli_bacen', $cli_bacen)->with('cre_avalistas', $cre_avalistas)->with('cre_garantias', $cre_garantias)->with('pro_seguros', $pro_seguros)->with('pro_consorcios', $pro_consorcios)->with('pro_previdencias', $pro_previdencias);
	}


	#-------------------------------------------------------------------
	# Importar 
	#-------------------------------------------------------------------
    // Exibindo items de importação
	public function ExibirImportar(){
		$cli_associados = Associados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_consolidado = AssociadosConsolidado::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_emails = AssociadosEmails::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_telefones = AssociadosTelefones::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_enderecos = AssociadosEnderecos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_conglomerados = AssociadosConglomerados::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_iap = AssociadosIAPs::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cli_bacen = AssociadosBacen::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cre_contratos = Contratos::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cre_avalistas = ContratosAvalistas::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cre_garantias = ContratosGarantias::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cca_contacapital = ContaCapital::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$cco_contacorrente = ContaCorrente::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$crt_cartaocredito = CartaoCredito::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$pop_poupanca = Poupancas::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$dep_aplicacoes = Aplicacoes::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$pro_seguros = ProSeguros::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$pro_consorcios = ProConsorcios::select('updated_at')->orderBy('updated_at', 'DESC')->first();
		$pro_previdencias = ProPrevidencias::select('updated_at')->orderBy('updated_at', 'DESC')->first();

		return view('configuracoes.importacoes.manual')->with('cli_associados', $cli_associados)->with('cli_consolidado', $cli_consolidado)->with('cli_emails', $cli_emails)->with('cli_enderecos', $cli_enderecos)->with('cli_telefones', $cli_telefones)->with('cca_contacapital', $cca_contacapital)->with('cco_contacorrente', $cco_contacorrente)->with('crt_cartaocredito', $crt_cartaocredito)->with('cli_conglomerados', $cli_conglomerados)->with('cre_contratos', $cre_contratos)->with('pop_poupanca', $pop_poupanca)->with('dep_aplicacoes', $dep_aplicacoes)->with('cli_iap', $cli_iap)->with('cli_bacen', $cli_bacen)->with('cre_avalistas', $cre_avalistas)->with('cre_garantias', $cre_garantias)->with('pro_seguros', $pro_seguros)->with('pro_consorcios', $pro_consorcios)->with('pro_previdencias', $pro_previdencias);
	}
	// Importação manual (return (new HeadingRowImport)->toArray($request->myData))
	public function ImportarManual(Request $request){

		if ($request->hasFile('myData') && $request->file('myData')->isValid()){
			// Criando pasta de importação ou verificando se existe
			if(!(getcwd().'/storage/app/importacoes')){
				mkdir(getcwd().'/storage/app/importacoes', 0755);
			}
			// cli_associados
			if($request->relatorio == 'cli_associados'){
				try{
					$nameFile = 'cli_associados-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_associados, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('high');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_associados.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cli_consolidado
			if($request->relatorio == 'cli_consolidado'){
				try{
					$nameFile = 'cli_consolidado-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_consolidado, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_consolidado.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cli_emails
			if($request->relatorio == 'cli_emails'){
				try{
					$nameFile = 'cli_emails-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_emails, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_emails.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cli_telefones
			if($request->relatorio == 'cli_telefones'){
				try{
					$nameFile = 'cli_telefones-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_telefones, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_telefones.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cli_enderecos
			if($request->relatorio == 'cli_enderecos'){
				try{
					$nameFile = 'cli_enderecos-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_enderecos, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_enderecos.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cli_conglomerados
			if($request->relatorio == 'cli_conglomerados'){
				try{
					$nameFile = 'cli_conglomerados-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_conglomerados, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_conglomerados.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cca_contacapital
			if($request->relatorio == 'cca_contacapital'){
				try{
					$nameFile = 'cca_contacapital-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cca_contacapital, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cca_contacapital.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cco_contacorrente
			if($request->relatorio == 'cco_contacorrente'){
				try{
					$nameFile = 'cco_contacorrente-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cco_contacorrente, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('high');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cco_contacorrente.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cre_contratos_vigentes
			if($request->relatorio == 'cre_contratos_vigentes'){
				try{
					$nameFile = 'cre_contratos_vigentes-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cre_contratos, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos_vigentes.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cre_contratos_quitados
			if($request->relatorio == 'cre_contratos_quitados'){
				try{
					$nameFile = 'cre_contratos_quitados-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cre_contratos, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos_quitados.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cre_avalistas
			if($request->relatorio == 'cre_avalistas'){
				try{
					$nameFile = 'cre_avalistas-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cre_avalistas, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_avalistas.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cre_garantias
			if($request->relatorio == 'cre_garantias'){
				try{
					$nameFile = 'cre_garantias-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cre_garantias, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_garantias.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// crt_cartaocredito
			if($request->relatorio == 'crt_cartaocredito'){
				try{
					$nameFile = 'crt_cartaocredito-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new crt_cartaocredito, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo crt_cartaocredito.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// dep_aplicacoes
			if($request->relatorio == 'dep_aplicacoes'){
				try{
					$nameFile = 'dep_aplicacoes-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new dep_aplicacoes, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo dep_aplicacoes.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// pop_poupanca
			if($request->relatorio == 'pop_poupanca'){
				try{
					$nameFile = 'pop_poupanca-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new pop_poupanca, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pop_poupanca.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cli_iap
			if($request->relatorio == 'cli_iap'){
				try{
					$nameFile = 'cli_iap-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_iap, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low'); 
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_iap.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cli_bacen
			if($request->relatorio == 'cli_bacen'){
				try{
					$nameFile = 'cli_bacen-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cli_bacen, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_bacen.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// cre_contratos_historico
			if($request->relatorio == 'cre_contratos_historico'){
				try{
					$nameFile = 'cre_contratos_historico-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new cre_contratos_historico, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos_historico.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// pro_seguros
			if($request->relatorio == 'pro_seguros'){
				try{
					$nameFile = 'pro_seguros-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new pro_seguros, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_seguros.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// pro_consorcios
			if($request->relatorio == 'pro_consorcios'){
				try{
					$nameFile = 'pro_consorcios-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new pro_consorcios, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_consorcios.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			// pro_previdencias
			if($request->relatorio == 'pro_previdencias'){
				try{
					$nameFile = 'pro_previdencias-'.date('dmYHis').'.'.request()->file('myData')->getClientOriginalExtension();
					$upload = $request->myData->storeAs('importacoes', $nameFile);
					Excel::queueImport(new pro_previdencias, getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low');
					return response()->json(['status' => true]);
				} catch (\Exception $ex){
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_previdencias.xlsx!</span>']);
					return response()->json(['status' => false, 'error' => $ex]);
				}
			}
			Atividades::create([
				'nome' => 'Importação de arquivos',
				'descricao' => 'Você efetuou a importação de arquivos manualmente.',
				'icone' => 'mdi-upload',
				'url' => route('importManual.importacoes'),
				'id_usuario' => Auth::id()
			]);
		}else{
			return response()->json(['status' => false]);
		}
	}
	// Importação automática
	public function ImportarAutomatica(){
		// Copiando os arquivos para pasta de importação e removendo os existentes do outlook
		if(count(scandir("outlook")) > 2){
			// Criando pasta de importação ou verificando se existe
			if(!(getcwd().'/storage/app/importacoes')){
				mkdir(getcwd().'/storage/app/importacoes', 0755);
			}
			// cli_associados
			if(file_exists(getcwd().'/outlook/cli_associados.xlsx')){
				try{
					$nameFile = 'cli_associados'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_associados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_associados.xlsx');
					(new cli_associados)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('high');
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_associados.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_associados.xlsx!</span>']);
				}
			}
			// cli_consolidado
			if(file_exists(getcwd().'/outlook/cli_consolidado.xlsx')){
				try{
					$nameFile = 'cli_consolidado'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_consolidado.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_consolidado.xlsx');
					(new cli_consolidado)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_consolidado.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_consolidado.xlsx!</span>']);
				}
			}
			// cli_emails
			if(file_exists(getcwd().'/outlook/cli_emails.xlsx')){
				try{
					$nameFile = 'cli_emails'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_emails.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_emails.xlsx');
					(new cli_emails)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_emails.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_emails.xlsx!</span>']);
				}
			}
			// cli_telefones
			if(file_exists(getcwd().'/outlook/cli_telefones.xlsx')){
				try{
					$nameFile = 'cli_telefones'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_telefones.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_telefones.xlsx');
					(new cli_telefones)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_telefones.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_telefones.xlsx!</span>']);
				}
			}
			// cli_enderecos
			if(file_exists(getcwd().'/outlook/cli_enderecos.xlsx')){
				try{
					$nameFile = 'cli_enderecos'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_enderecos.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_enderecos.xlsx');
					(new cli_enderecos)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_enderecos.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_enderecos.xlsx!</span>']);
				}
			}
			// cli_conglomerados
			if(file_exists(getcwd().'/outlook/cli_conglomerados.xlsx')){
				try{
					$nameFile = 'cli_conglomerados'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_conglomerados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_conglomerados.xlsx');
					(new cli_conglomerados)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_conglomerados.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_conglomerados.xlsx!</span>']);
				}
			}
			// cli_iap
			if(file_exists(getcwd().'/outlook/cli_iap.xlsx')){
				try{
					$nameFile = 'cli_iap'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_iap.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_iap.xlsx');
					(new cli_iap)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_iap.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_iap.xlsx!</span>']);
				}
			}
			// cca_contacapital
			if(file_exists(getcwd().'/outlook/cca_contacapital.xlsx')){
				try{
					$nameFile = 'cca_contacapital'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cca_contacapital.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cca_contacapital.xlsx');
					(new cca_contacapital)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cca_contacapital.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cca_contacapital.xlsx!</span>']);
				}
			}
			// cco_contacorrente
			if(file_exists(getcwd().'/outlook/cco_contacorrente.xlsx')){
				try{
					$nameFile = 'cco_contacorrente'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cco_contacorrente.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cco_contacorrente.xlsx');
					(new cco_contacorrente)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('high')->delay(now()->addMinutes(2));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cco_contacorrente.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cco_contacorrente.xlsx!</span>']);
				}
			}
			// cre_contratos_vigentes
			if(file_exists(getcwd().'/outlook/cre_contratos_vigentes.xlsx')){
				try{
					$nameFile = 'cre_contratos_vigentes'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cre_contratos_vigentes.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cre_contratos_vigentes.xlsx');
					(new cre_contratos)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cre_contratos_vigentes.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos_vigentes.xlsx!</span>']);
				}
			}
			// cre_contratos_quitados
			if(file_exists(getcwd().'/outlook/cre_contratos_quitados.xlsx')){
				try{
					$nameFile = 'cre_contratos_quitados'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cre_contratos_quitados.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cre_contratos_quitados.xlsx');
					(new cre_contratos)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cre_contratos_quitados.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos_quitados.xlsx!</span>']);
				}
			}
			// crt_cartaocredito
			if(file_exists(getcwd().'/outlook/crt_cartaocredito.xlsx')){
				try{
					$nameFile = 'crt_cartaocredito'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/crt_cartaocredito.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/crt_cartaocredito.xlsx');
					(new crt_cartaocredito)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/crt_cartaocredito.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo crt_cartaocredito.xlsx!</span>']);
				}
			}
			// pop_poupanca
			if(file_exists(getcwd().'/outlook/pop_poupanca.xlsx')){
				try{
					$nameFile = 'pop_poupanca'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/pop_poupanca.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/pop_poupanca.xlsx');
					(new pop_poupanca)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/pop_poupanca.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pop_poupanca.xlsx!</span>']);
				}
			}
			// dep_aplicacoes
			if(file_exists(getcwd().'/outlook/dep_aplicacoes.xlsx')){
				try{
					$nameFile = 'dep_aplicacoes'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/dep_aplicacoes.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/dep_aplicacoes.xlsx');
					(new dep_aplicacoes)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(5));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/dep_aplicacoes.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo dep_aplicacoes.xlsx!</span>']);
				}
			}
			// cli_bacen
			if(file_exists(getcwd().'/outlook/cli_bacen.xlsx')){
				try{
					$nameFile = 'cli_bacen'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cli_bacen.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cli_bacen.xlsx');
					(new cli_bacen)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(10));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cli_bacen.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_bacen.xlsx!</span>']);
				}
			}
			// cre_avalistas
			if(file_exists(getcwd().'/outlook/cre_avalistas.xlsx')){
				try{
					$nameFile = 'cre_avalistas'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cre_avalistas.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cre_avalistas.xlsx');
					(new cre_avalistas)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(7));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cre_avalistas.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_avalistas.xlsx!</span>']);
				}
			}	
			// cre_garantias
			if(file_exists(getcwd().'/outlook/cre_garantias.xlsx')){
				try{
					$nameFile = 'cre_garantias'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/cre_garantias.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/cre_garantias.xlsx');
					(new cre_garantias)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(7));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/cre_garantias.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_garantias.xlsx!</span>']);
				}
			}
			// pro_seguros
			if(file_exists(getcwd().'/outlook/pro_seguros.xlsx')){
				try{
					$nameFile = 'pro_seguros'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/pro_seguros.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/pro_seguros.xlsx');
					(new pro_seguros)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(7));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/pro_seguros.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_seguros.xlsx!</span>']);
				}
			}
			// pro_consorcios
			if(file_exists(getcwd().'/outlook/pro_consorcios.xlsx')){
				try{
					$nameFile = 'pro_consorcios'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/pro_consorcios.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/pro_consorcios.xlsx');
					(new pro_consorcios)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(7));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/pro_consorcios.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_consorcios.xlsx!</span>']);
				}
			}
			// pro_previdencias
			if(file_exists(getcwd().'/outlook/pro_previdencias.xlsx')){
				try{
					$nameFile = 'pro_previdencias'.date('dmY-His').'.xlsx';
					copy(getcwd().'/outlook/pro_previdencias.xlsx', getcwd().'/storage/app/importacoes/'.$nameFile);
					unlink(getcwd().'/outlook/pro_previdencias.xlsx');
					(new pro_previdencias)->queue(getcwd().'/storage/app/importacoes/'.$nameFile)->onQueue('low')->delay(now()->addMinutes(7));
				} catch (\Exception $ex){
					copy(getcwd().'/storage/app/importacoes/'.$nameFile, getcwd().'/pro_previdencias.xlsx');
					Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_previdencias.xlsx!</span>']);
				}
			}
			return response()->json(['status' => true]);
		}else{
			return response()->json(['status' => false]);
		}
	}


	#-------------------------------------------------------------------
	# Dashboard 
	#-------------------------------------------------------------------
	// Exibindo os logs de impotação
	public function ExibirLogs(){
		$logs = Logs::orderBy('id', 'DESC')->paginate(20);
		return view('configuracoes.importacoes.logs')->with('logs', $logs);
	}
}
