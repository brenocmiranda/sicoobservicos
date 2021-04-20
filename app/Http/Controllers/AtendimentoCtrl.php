<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Associados;
use App\Models\AssociadosAtividades;
use App\Models\AssociadosConglomerados;
use App\Models\AssociadosBacen;
use App\Models\AssociadosIAPs;
use App\Models\Atividades;
use App\Models\ContaCapital;
use App\Models\ContaCorrente;
use App\Models\Contratos;
use App\Models\ContratosAvalistas;
use App\Models\ContratosGarantias;
use App\Models\CartaoCredito;
use App\Models\Poupancas;
use App\Models\Aplicacoes;
use App\Models\Cadastro;
use App\Models\CadastroArquivos;
use App\Models\CadastroSocios;
use App\Models\CadastroStatus;
use App\Models\CadastroTelefones;
use App\Models\Arquivos;
use PDF;

class AtendimentoCtrl extends Controller
{
  
  	public function __construct()
	{
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Painel do associado
	#-------------------------------------------------------------------
	// Listando painel
 	public function ExibirPainel(){
    	return view('atendimento.painel.pesquisar');
	}
	// Pesquisando associados por partes do nome
	public function PesquisarPainel(Request $request){
  		$search = $request->get('term');
  		$result = Associados::where('nome', 'LIKE', '%'. $search. '%')->orWhere('nome_fantasia', 'LIKE', '%'. $search. '%')->orWhere('documento', 'LIKE', '%'. $search. '%')->select('nome', 'documento', 'id')->get();
  		return response()->json($result);
	}
	// Retorno de dados completos do associado
	public function MostrarPainel(Request $request){
		if(isset($request->pesquisar)){
			$documento = explode(': ', $request->pesquisar);
	  		$associado = Associados::where('documento', $documento[1])->first();
	  		if($associado->RelationConglomerados){
	  			$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
	  		}else{
	  			$conglomerado = null;
	  		}
	  		$atividades = AssociadosAtividades::where('cli_id_associado', $associado->id)->orderBy('created_at', 'DESC')->paginate(7);
	  		$cli_iap = AssociadosIAPs::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$cli_bacen = AssociadosBacen::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$cre_contratos = Contratos::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$cre_avalistas = ContratosAvalistas::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$cre_garantias = ContratosGarantias::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$cca_contacapital = ContaCapital::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$cco_contacorrente = ContaCorrente::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$crt_cartaocredito = CartaoCredito::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$pop_poupanca = Poupancas::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
			$dep_aplicacoes = Aplicacoes::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();

			Atividades::create([
				'nome' => 'Acesso ao painel do associado',
				'descricao' => 'Você pesquisou informações do associado: '.$associado->nome.'.',
				'icone' => 'mdi-magnify',
				'url' => route('exibir.painel.atendimento'),
				'id_usuario' => Auth::id()
			]);

	  		return view('atendimento.painel.exibir')->with('associado', $associado)->with('conglomerado', $conglomerado)->with('atividades', $atividades)->with('cca_contacapital', $cca_contacapital)->with('cco_contacorrente', $cco_contacorrente)->with('crt_cartaocredito', $crt_cartaocredito)->with('cre_contratos', $cre_contratos)->with('pop_poupanca', $pop_poupanca)->with('dep_aplicacoes', $dep_aplicacoes)->with('cli_iap', $cli_iap)->with('cli_bacen', $cli_bacen)->with('cre_avalistas', $cre_avalistas)->with('cre_garantias', $cre_garantias);
		}else{
			\Session::flash('login', array(
					'class' => 'danger',
					'mensagem' => 'O usuário está bloqueado, contate o administrador.'
				));
			return view('atendimento.painel.pesquisar');
		}
	}
	// Retorno de dados completos do associado pelo Nº do sisbr
	public function MostrarPainelID($id){
  		$associado = Associados::find($id);
  		if($associado->RelationConglomerados){
  			$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
  		}else{
  			$conglomerado = null;
  		}
  		$atividades = AssociadosAtividades::where('cli_id_associado', $associado->id)->orderBy('created_at', 'DESC')->paginate(7);
  		$cli_iap = AssociadosIAPs::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$cli_bacen = AssociadosBacen::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$cre_contratos = Contratos::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$cre_avalistas = ContratosAvalistas::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$cre_garantias = ContratosGarantias::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$cca_contacapital = ContaCapital::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$cco_contacorrente = ContaCorrente::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$crt_cartaocredito = CartaoCredito::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$pop_poupanca = Poupancas::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();
		$dep_aplicacoes = Aplicacoes::select('updated_at', 'data_movimento')->orderBy('updated_at', 'DESC')->first();

		Atividades::create([
			'nome' => 'Acesso ao painel do associado',
			'descricao' => 'Você pesquisou informações do associado: '.$associado->nome.'.',
			'icone' => 'mdi-magnify',
			'url' => route('exibir.painel.atendimento'),
			'id_usuario' => Auth::id()
		]);

  		return view('atendimento.painel.exibir')->with('associado', $associado)->with('conglomerado', $conglomerado)->with('atividades', $atividades)->with('cca_contacapital', $cca_contacapital)->with('cco_contacorrente', $cco_contacorrente)->with('crt_cartaocredito', $crt_cartaocredito)->with('cre_contratos', $cre_contratos)->with('pop_poupanca', $pop_poupanca)->with('dep_aplicacoes', $dep_aplicacoes)->with('cli_iap', $cli_iap)->with('cli_bacen', $cli_bacen)->with('cre_avalistas', $cre_avalistas)->with('cre_garantias', $cre_garantias);
	}
	// Emissão de relatório do painel
	public function RelatorioPainel(Request $request, $id){
	  	$associado = Associados::find($id);
	  	$atividades = AssociadosAtividades::where('cli_id_associado', $id)->orderBy('created_at', 'DESC')->get();
	  	$imprimir = $request->except('_token');
	  	if($associado->RelationConglomerados){
	  		$conglomerado = AssociadosConglomerados::where('codigo', $associado->RelationConglomerados->codigo)->get();
	  	}else{
	  		$conglomerado = null;
	  	}

	  	$pdf = PDF::loadView('atendimento.painel.relatorio', compact('associado', 'conglomerado', 'atividades', 'imprimir'))->setPaper('a4', 'portrait');
	    return $pdf->stream();
	}
	// Cadastrando nova atividade
	public function AtividadesPainel(Request $request){
  		AssociadosAtividades::create([
  			'tipo' => $request->tipo, 
  			'descricao' => $request->descricao, 
  			'contato' => $request->contato, 
  			'cli_id_associado' => $request->cli_id_associado,
  			'usr_id_usuario' => Auth::id(),
  		]);
  		return response()->json(['success' => true]);
	}
	// Editando a atividade
	public function EditandoPainel(Request $request){
  		AssociadosAtividades::find($request->id)->update([
  			'tipo' => $request->tipo, 
  			'descricao' => $request->descricao, 
  			'contato' => $request->contato
  		]);
  		return response()->json(['success' => true]);
	}
	// Detalhes da atividade
	public function DetalhesPainel($id){
  		$atividade = AssociadosAtividades::find($id);
  		return response()->json($atividade);
	}

	#-------------------------------------------------------------------
	# Novo associado
	#-------------------------------------------------------------------
	// Listando todas solicitações
 	public function ExibirAssociado(){
 		$solicitacoes = Cadastro::where('usr_id_usuarios', Auth::id())->get();
    	return view('atendimento.cadastro.listar')->with('solicitacoes', $solicitacoes);
	}
	// Adicionar novo associado
 	public function NovoAssociado(){
    	return view('atendimento.cadastro.adicionar');
	}
	// Verificação de cadastro ja existe
	public function ExisteCadastro($documento){
		$dados = Associados::where('documento', $documento)->first();
		if(isset($dados)){
			return response()->json(['status' => true]);
		}else{
			return response()->json(['status' => false]);
		}
	}
	// Cadastro de pessoa física
	public function CadastroAssociadoPF(Request $request){
		// Criando solicitação
        $create = Cadastro::create([
            'sigla' => $request->sigla, 
            'documento' => $request->documento, 
            'nome' => $request->nome, 
            'sexo' => $request->sexo,     
            'naturalidade' => $request->naturalidade,     
            'estadoCivil' => $request->estadoCivil,     
            'escolaridade' => $request->escolaridade,     
            'profissao' => $request->profissao,
            'email' => $request->email,
            'observacoes' => $request->observacoes,
            'usr_id_usuarios' => Auth::id(), 
        ]);

        // Criando status
        $status = CadastroStatus::create([
            'status' => 'aberto', 
            'descricao' => 'Abertura de solicitação para cadastro de novo associado.',
            'usr_id_usuarios' => Auth::id(),
            'cad_id_novos' => $create->id 
        ]);

        // Criando os telefones
		if($request->tipoTelefone){
			foreach ($request->tipoTelefone as $key => $value) {
				$telefones = CadastroTelefones::create([
		            'tipoTelefone' => $value, 
		            'numero' => $request->numeroTelefone[$key], 
		            'cad_id_novos' => $create->id
		        ]);
			}
		}

		// Upload do documento de identificação
		if($request->documentoIdentificacao[0]){
			foreach($request->file('documentoIdentificacao') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeIdentificacao.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeIdentificacao, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de CPF
		if($request->documentoCPF[0]){
			foreach($request->file('documentoCPF') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeCPF.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeCPF, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de renda
		if($request->documentoRenda[0]){
			foreach($request->file('documentoRenda') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeRenda.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeRenda, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de residência
		if($request->documentoResidencia[0]){
			foreach($request->file('documentoResidencia') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeResidencia.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeResidencia, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de casamento
		if($request->documentoCasamento[0]){
			foreach($request->file('documentoCasamento') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeCasamento.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeCasamento, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de imposto de renda
		if($request->documentoImposto[0]){
			foreach ($request->file('documentoImposto') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeImposto.'0'. $create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	            }
	            $identificacao = CadastroArquivos::create([
		            'nome' => $request->nomeImposto, 
		            'id_arquivo' => $arquivo->id, 
		            'cad_id_novos' => $create->id
		        ]);
            }    
		}
		// Upload do cartão de assinatura
		if($request->hasFile('cartaoAssinatura')){
		 	if ($request->cartaoAssinatura->isValid()) {
				$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($request->cartaoAssinatura->extension(), '', $request->nomeCartao.'0'. $create->id));
                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
               	$extension =  $request->cartaoAssinatura->extension();
               	$nameFile = "{$name}.{$extension}";
                $upload =  $request->cartaoAssinatura->storeAs('cadastro', $nameFile);
                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
                // Salvando referencia
                $identificacao = CadastroArquivos::create([
		            'nome' =>  $request->nomeCartao, 
		            'id_arquivo' => $arquivo->id, 
		            'cad_id_novos' => $create->id
		        ]);
         	}
		}

		//* Verificação de se arquivo existe, depois um upload do arquivo com nome, depois transformar em PDF e salvar na pasta com o nome do associado

		Atividades::create([
            'nome' => 'Solicitação de cadastro',
            'descricao' => 'Você efetuou a solicitação de um novo associado: '.$create->nome.'.',
            'icone' => 'mdi-plus',
            'url' => route('detalhes.cadastro.atendimento', $create->id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('exibir.cadastro.atendimento'));
	}
	// Cadastro de pessoa jurídica
	public function CadastroAssociadoPJ(Request $request){
		
		// Criando solicitação
        $create = Cadastro::create([
            'sigla' => $request->sigla, 
            'documento' => $request->documento, 
            'nome' => $request->nome, 
            'fantasia' => $request->fantasia,
            'sexo' => $request->sexo,     
            'atividade_economica' => $request->atividade_economica,     
            'situacao' => $request->situacao,     
            'porte_cliente' => $request->porte_cliente,     
            'data_abertura' => date('Y-m-d', strtotime($request->data_abertura)),
            'email' => $request->email,
            'observacoes' => $request->observacoes,
            'usr_id_usuarios' => Auth::id(), 
        ]);
        // Criando status
        $status = CadastroStatus::create([
            'status' => 'aberto', 
            'descricao' => 'Abertura de solicitação para cadastro de novo associado.',
            'usr_id_usuarios' => Auth::id(),
            'cad_id_novos' => $create->id 
        ]);
        // Criando os telefones
		if($request->tipoTelefone){
			foreach ($request->tipoTelefone as $key => $value) {
				$telefones = CadastroTelefones::create([
		            'tipoTelefone' => $value, 
		            'numero' => $request->numeroTelefone[$key], 
		            'cad_id_novos' => $create->id
		        ]);
			}
		}
		// Vinculando os socios a empresa
		if($request->socios){
			foreach ($request->socios as $key => $value) {
				$documento = explode(': ', $value);
	  			$associado = Associados::where('documento', $documento[1])->first();
				$socios = CadastroSocios::create([
		            'cad_id_novos' => $create->id, 
		            'cli_id_associado' => $associado->id
		        ]);
			}
		}
		// Upload do documento de contrato social
		if($request->documentoContrato[0]){
			foreach($request->file('documentoContrato') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeContrato.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeContrato, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de faturamento
		if($request->documentoFaturamento[0]){
			foreach($request->file('documentoFaturamento') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeFaturamento.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeFaturamento, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de endereço comercial
		if($request->documentoEnderecoComercial[0]){
			foreach($request->file('documentoEnderecoComercial') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeEnderecoComercial.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeEnderecoComercial, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de inscrição estadual
		if($request->documentoInscricao[0]){
			foreach($request->file('documentoInscricao') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeInscricao.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeInscricao, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de simples nacional
		if($request->documentoSimples[0]){
			foreach($request->file('documentoSimples') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeSimples.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeSimples, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de alteração contratual
		if($request->documentoAlteracao[0]){
			foreach($request->file('documentoAlteracao') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeAlteracao.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeAlteracao, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de ata de eleição
		if($request->documentoAta[0]){
			foreach($request->file('documentoAta') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeAta.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeAta, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do documento de instrumento de mandato
		if($request->documentoMandato[0]){
			foreach($request->file('documentoMandato') as $key => $value) {
				if($value->isValid()){
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($value->extension(), '', $request->nomeMandato.'0'.$create->id.'0'.$key));
	                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
	               	$extension =  $value->extension();
	               	$nameFile = "{$name}.{$extension}";
	                $upload =  $value->storeAs('cadastro', $nameFile);
	                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
	                // Salvando referencia
	                $identificacao = CadastroArquivos::create([
			            'nome' => $request->nomeMandato, 
			            'id_arquivo' => $arquivo->id, 
			            'cad_id_novos' => $create->id
			        ]);
	            }
            }
		}
		// Upload do cartão de assinatura
		if($request->hasFile('cartaoAssinatura')){
		 	if ($request->cartaoAssinatura->isValid()) {
				$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , str_replace($request->cartaoAssinatura->extension(), '', $request->nomeCartao.'0'. $create->id));
                $name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
               	$extension =  $request->cartaoAssinatura->extension();
               	$nameFile = "{$name}.{$extension}";
                $upload =  $request->cartaoAssinatura->storeAs('cadastro', $nameFile);
                $arquivo = Arquivos::create(['endereco' => $upload, 'tipo' => 'cadastro']);
                // Salvando referencia
                $identificacao = CadastroArquivos::create([
		            'nome' =>  $request->nomeCartao, 
		            'id_arquivo' => $arquivo->id, 
		            'cad_id_novos' => $create->id
		        ]);
         	}
		}

		Atividades::create([
            'nome' => 'Solicitação de cadastro',
            'descricao' => 'Você efetuou a solicitação de um novo associado: '.$create->nome.'.',
            'icone' => 'mdi-plus',
            'url' => route('detalhes.cadastro.atendimento', $create->id),
            'id_usuario' => Auth::id()
        ]);

        return redirect(route('exibir.cadastro.atendimento'));
	}
	// Detalhes da solicitação
	public function DetalhesCadastro($id){
		$dados = Cadastro::find($id);
		return view('atendimento.cadastro.detalhes')->with('dados', $dados);
	}
	
}
