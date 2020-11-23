@section('title')
Painel do associado
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<h4 class="page-title">{{$associado->nome}}</h4> 
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Atendimento</a></li>
        <li><a href="{{route('exibir.painel.atendimento')}}">Painel do associado</a></li>
        <li><a class="active">Detalhes</a></li>
      </ol>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row mx-auto mb-4"> 
    <div class="mr-auto">
      <a href="{{route('exibir.painel.atendimento')}}" class="mx-2"><i class="mdi mdi-arrow-left pr-2"></i>Voltar</a>
    </div>
    <div class="ml-auto">
      <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-adicionar" class="mx-2"><i class="mdi mdi-plus pr-2"></i>Cadastro de atividade</a>
      <a href="javascript:void(0)" class="mx-2"><i class="mdi mdi-printer pr-2"></i>Imprimir</a>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs customtab2 p-4 row justify-content-center" role="tablist" style="background: #38565a;border-radius: 10px;">
      <li role="presentation"  class="active"> <a href="#atividades" aria-controls="iap" role="tab" data-toggle="tab" aria-expanded="true"> <span>Atividades</span> </a> </li> 
      <li role="presentation"> <a href="#cadastro" aria-controls="dadoscadastrais" role="tab" data-toggle="tab" aria-expanded="true"> <span>Cadastro</span> </a> </li> 
      <li role="presentation"> <a href="#bacen" aria-controls="dadoscadastrais" role="tab" data-toggle="tab" aria-expanded="true"> <span>BACEN</span> </a> </li> 
      <li role="presentation"> <a href="#contacapital" aria-controls="contacapital" role="tab" data-toggle="tab" aria-expanded="true"> <span>Conta capital</span> </a> </li> 
      <li role="presentation"> <a href="#contacorrente" aria-controls="contacorrente" role="tab" data-toggle="tab" aria-expanded="true"> <span>Conta corrente</span> </a> </li> 
      <li role="presentation"> <a href="#cartaocredito" aria-controls="cartaocredito" role="tab" data-toggle="tab" aria-expanded="true"> <span>Conta cartão</span> </a> </li> 
      <li role="presentation"> <a href="#carteiracredito" aria-controls="carteiracredito" role="tab" data-toggle="tab" aria-expanded="true"> <span>Emprestimos</span> </a> </li>
      <li role="presentation"> <a href="#poupanca" aria-controls="poupanca" role="tab" data-toggle="tab" aria-expanded="true"> <span>Poupança</span> </a> </li> 
      <li role="presentation"> <a href="#aplicacoes" aria-controls="aplicacoes" role="tab" data-toggle="tab" aria-expanded="true"> <span>Aplicações</span> </a> </li> 
      <li role="presentation"> <a href="#iap" aria-controls="iap" role="tab" data-toggle="tab" aria-expanded="true"> <span>IAP</span> </a> </li>  
      <li role="presentation"> <a href="#inadimplencia" aria-controls="dadoscadastrais" role="tab" data-toggle="tab" aria-expanded="true"> <span>Inadimplência</span> </a> </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content white-box mt-0">
      <div role="tabpanel" class="tab-pane fade  active in" id="atividades">
        <div class="col-12">
          <div class="row">
            @if(isset($atividades[0]))
            @foreach($atividades as $atividade)
            <div class="col-12">
              <h5 class="text-capitalize">{{$atividade->tipo}}</h5>
              <h6 class="font-weight-normal">Contato por: <b class="text-capitalize">{{$atividade->contato}}</b></h6>
              <label class="d-block">{{$atividade->descricao}}</label>
              <div class="row col-12">
                <small class="text-capitalize mr-auto"><b>{{$atividade->RelationUsuarios->RelationAssociado->nome}}</b> - {{date('d/m/Y H:i:s', strtotime($atividade->created_at))}}</small>
                @if(Auth::id() == $atividade->usr_id_usuario)
                <small class="ml-auto">
                  <a href="javascript:" class="editarAtividade" data="{{route('detalhes.atividade.associado.atendimento', $atividade->id)}}"><i class="ti-pencil pr-2"></i>Editar</a>
                </small>
                @endif
              </div>
              <hr>
            </div>
            @endforeach
            @else
            <div class="mx-auto">
              <h5>Ops! Nenhuma informação encontrada.</h5>
            </div>
            @endif
          </div>
        </div>
        <div class="row justify-content-center">
         {!! (isset($atividades) ? $atividades->links() : '') !!}
        </div>
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="cadastro">
        <div class="col-12"> 
          <div class="row">
            <div class="col-6">
              <h6 class="mt-0">Nome</h6>
              <label>{{$associado->nome}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">CPF/CNPJ</h6>
              <label>{{(strlen($associado->documento) == 11 ? substr($associado->documento, 0, 3).'.'.substr($associado->documento, 3, 3).'.'.substr($associado->documento, 6, 3).'-'.substr($associado->documento, 9, 2) : substr($associado->documento, 0, 2).'.'.substr($associado->documento, 3, 3).'.'.substr($associado->documento, 6, 3).'/'.substr($associado->documento, 8, 4).'-'.substr($associado->documento, 12, 2))}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">{{($associado->descricao_identidade != 'NÃO SE APLICA' ? ucfirst(strtolower($associado->descricao_identidade)) : 'Documento de identificação')}}</h6>
              <label>{{($associado->numero_identidade != '-1' ? $associado->numero_identidade : '-')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Razão social</h6>
              <label>{{$associado->nome_fantasia}}</label>
            </div>
            <div class="col-3">
              <h6>Atividade econônmica</h6>
              <label>{{$associado->atividade_economica}}</label>
            </div>
            <div class="col-3">
              <h6>Escolaridade</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->escolaridade : '-')}}</label>
            </div>
            <div class="col-3">
              <h6>Profissão</h6>
              <label>{{$associado->profissao}}</label>
            </div> 
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Porte do cliente</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->porte_cliente : '-')}}</label>
            </div>
            <div class="col-3">
              <h6>Data de Nascimento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
            </div>
            <div class="col-3">
              <h6>Estado Cívil</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->estado_civil : '-')}}</label>
            </div>
            <div class="col-3">
              <h6>Sexo</h6>
              <label>{{($associado->sexo == 'M' ? 'Masculino' : ($associado->sexo == 'F' ? 'Feminino' : 'Não classificado'))}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Nível CRL <small class="text-dark">(Vigência até: {{(isset($associado->RelationConsolidado) ? (date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) != date('d/m/Y', strtotime('1899-12-31')) ? date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) : '-') : '-')}})</small></h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->nivel_risco_crl : '-')}}</label>
            </div>
            <div class="col-3">
              <h6>Nível de risco</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->nivel_risco : '-')}}</label>
            </div>
            <div class="col-3">
              <h6>Data de relacionamento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
            </div>
            <div class="col-3">
              <h6>Data de renovação</h6>
              <label class="{{( strtotime(date('Y-m-d', strtotime($associado->data_renovacao.'+ 1 year'))) < strtotime(date('Y-m-d')) ? 'bg-danger px-3 py-1 rounded text-white' : '')}}">
                {{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
            </div>
          </div>
          <div class="row">
              <div class="col-3">
                <h6>Gerente</h6>
                <label>{{$associado->nome_gerente}}</label>
              </div>
              <div class="col-3">
                <h6>CNAE</h6>
                <label>{{$associado->cod_cnae}}</label>
              </div>
              <div class="col-3">
                <h6>PA</h6>
                <label>{{$associado->PA}}</label>
              </div> 
          </div>
        </div>
        <div class="mt-5">
          <h5>Avaliação financeira</h5>
          <hr class="mt-2">
          <div class="col-12">
            <div class="row">
              <div class="col-3">
                <h6>Tipo de renda</h6>
                <label>{{$associado->tipo_renda}}</label>
              </div>
              <div class="col-3">
                <h6>Renda/Faturamento <small class="text-dark">(Mensal bruto)</small></h6>
                <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
              </div>
              <div class="col-3">
                <h6>Valor bens móveis <small class="text-dark">(Total)</small></h6>
                <label>R$ {{(isset($associado->RelationConsolidado) ? number_format(@$associado->RelationConsolidado->valor_movel, 2, ',', '.') : '-')}}</label>
              </div>
              <div class="col-3">
                <h6>Valor bens imóveis <small class="text-dark">(Total)</small></h6>
                <label>R$ {{(isset($associado->RelationConsolidado) ? number_format(@$associado->RelationConsolidado->valor_imovel, 2, ',', '.') : '-')}}</label>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-5">
          <h5>Conglomerado</h5>
          <hr class="mt-2">
          <div class="col-12">
            <div class="row">
              <div class="col-3">
                <h6>Participa de conglomerado?</h6>
                <label>{{(isset($associado->RelationConglomerados) ? 'Sim' : 'Não')}}</label>
              </div>
              <div class="col-9">
                <h6>Nome</h6>
                <label>{{(isset($associado->RelationConglomerados) ? $associado->RelationConglomerados->descricao : '-')}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <h6>Participantes</h6>
                @if(isset($conglomerado))
                @foreach($conglomerado as $participante)
                <label class="d-block">{{$participante->RelationAssociado->nome}}</label>
                @endforeach
                @else
                <label>-</label>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="mt-5">
          <h5>Produtor Rural</h5>
          <hr class="mt-2">
          <div class="col-12">
            <div class="row">
              <div class="col-3">
                <h6>Indicador de Produtor</h6>
                <label>{{(isset($associado->RelationConsolidado) ? ($associado->RelationConsolidado->indicador_rural == 1 ? 'Sim' : 'Não') : '-')}}</label>
              </div>
              <div class="col-6">
                <h6>Categoria de Produtor</h6>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->categoria_rural : '-')}}</label>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-5">
          <h5>Endereço</h5>
          <hr class="mt-2">
          <div class="col-12">
            <div class="row">
              <div class="col-3">
                <h6>Lagadouro</h6>
                <label>{{$associado->RelationEnderecos->rua}}</label>
              </div>
              <div class="col-3">
                <h6>Bairro</h6>
                <label>{{$associado->RelationEnderecos->bairro}}</label>
              </div>
              <div class="col-3">
                <h6>Número</h6>
                <label>{{$associado->RelationEnderecos->numero}}</label>
              </div>
              <div class="col-3">
                <h6>Complemento</h6>
                <label>{{$associado->RelationEnderecos->complemento}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h6>Cidade</h6>
                <label>{{$associado->RelationEnderecos->cidade}}</label>
              </div>
              <div class="col-3">
                <h6>Estado</h6>
                <label>{{$associado->RelationEnderecos->estado}}</label>
              </div>
              <div class="col-3">
                <h6>País</h6>
                <label>{{$associado->RelationEnderecos->pais}}</label>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-5">
          <h5>Contatos</h5>
          <hr class="mt-2">
          <div class="col-12">
            <div class="row">
              <div class="col-3">
                <h6>Telefone celular</h6>
                <label>{{($associado->RelationTelefones->numero_celular != '-2' ? $associado->RelationTelefones->numero_celular : '-')}}</label>
              </div>
              <div class="col-3">
                <h6>Telefone comercial</h6>
                <label>{{($associado->RelationTelefones->numero_comercial != '-2' ? $associado->RelationTelefones->numero_comercial : '-')}}</label>
              </div>
              <div class="col-3">
                <h6>Telefone residencial</h6>
                <label>{{($associado->RelationTelefones->numero_residencial != '-2' ? $associado->RelationTelefones->numero_residencial : '-')}}</label>
              </div>
              <div class="col-3">
                <h6>Telefone recado</h6>
                <label>{{($associado->RelationTelefones->numero_recado != '-2' ? $associado->RelationTelefones->numero_recado : '-')}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <h6>Email</h6>
                <label>{{(isset($associado->RelationEmails->email) ? $associado->RelationEmails->email : '-')}}</label>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="contacapital">
        <div class="row mx-auto bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($associado->RelationCapital->data_movimento))}}</label>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-3">
              <h6 class="mt-0">Nº matrícula</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->num_capital : '-')}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Situação</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->situacao_capital : '-')}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Data da matrícula</h6>
              <label>{{(isset($associado->RelationCapital) ? date('d/m/Y', strtotime($associado->RelationCapital->data_matricula)) : '-')}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Data de saída da matrícula</h6>
              <label>{{(isset($associado->RelationCapital) ? (date('d/m/Y', strtotime($associado->RelationCapital->saida_matricula)) != '31/12/9999' ? date('d/m/Y', strtotime($associado->RelationCapital->saida_matricula)) : '-')  : '-')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Tem direito ao voto?</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->direito_voto : '-')}}</label>
            </div>
            <div class="col-3">
              <h6>Tem direito ao rateio?</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->direito_rateio : '-')}}</label>
            </div>
            <div class="col-3">
              <h6>Valor integralizado</h6>
              <label>R$ {{(isset($associado->RelationCapital) ? number_format($associado->RelationCapital->valor_integralizado, 2, ',', '.') : '-')}}</label>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="contacorrente">
        @if(isset($associado->RelationContaCorrente[0]))
          <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
            <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($associado->RelationContaCorrente[0]->data_movimento))}}</label>
          </div>
          @foreach($associado->RelationContaCorrente->sortByDesc('data_abertura') as $conta)
          <div class="col-12"> 
            <div class="mb-5">
              <h5 class="font-weight-normal"><b>{{$conta->num_contrato}}</b> <small>({{$conta->situacao}})</small></h5>
              <hr class="mt-2">
              <div class="row">
                <div class="col-3">
                  <h6 class="mt-0">Modalidade</h6>
                  <label>{{$conta->modalidade_conta}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Tipo de conta</h6>
                  <label>{{$conta->tipo_conta}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Categoria</h6>
                  <label>{{$conta->categoria_conta}}</label>
                </div>
                <div class="col-3">
                  <h6>Utilizando o limite</h6>
                  <label>{{$conta->utilizacao_limite}} dias</label>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <h6>Taxa de limite</h6>
                  <label>{{number_format($conta->taxa_limite, 2, ',', '.')}} %</label>
                </div>
                <div class="col-3">
                  <h6>Valor contratado</h6>
                  <label>R$ {{number_format($conta->valor_contratado, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor utilizado</h6>
                  <label>R$ {{number_format($conta->valor_utilizado, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor pacote tarifário</h6>
                  <label>R$ {{number_format($conta->valor_pacote, 2, ',', '.')}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <h6>Saldo atual em conta</h6>
                  <label>R$ {{number_format($conta->valor_saldo, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Última movimentação</h6>
                  <label>{{date('d/m/Y', strtotime($conta->ultima_movimentacao))}} <small>({{$conta->sem_movimentacao}} dias)</small></label>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
        <div class="text-center">
          <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
          <h5>Nenhuma informação encontrada.</h5>
        </div>
        @endif
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="cartaocredito">
        @if(isset($associado->RelationCartaoCredito[0]))
          <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
            <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($associado->RelationCartaoCredito[0]->data_movimento))}}</label>
          </div>
          @foreach($associado->RelationCartaoCredito->sortByDesc('situacao') as $cartao)
          <div class="col-12"> 
            <div class="mb-5">
              <h5 class="font-weight-normal"><b>{{$cartao->num_contrato}}</b> <small>({{$cartao->situacao}})</small></h5>
              <hr class="mt-2">
              <div class="row">
                <div class="col-3">
                  <h6 class="mt-0">Produto</h6>
                  <label>{{$cartao->produto_cartao}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Função do cartão</h6>
                  <label>{{$cartao->funcao_cartao}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Bandeira</h6>
                  <label>{{$cartao->bandeira_cartao}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Fatura</h6>
                  <label>{{$cartao->fatura}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <h6>Data de implantação</h6>
                  <label>{{(date('d/m/Y', strtotime($cartao->data_limite)) != '01/01/1900' ? date('d/m/Y', strtotime($cartao->data_limite)) : '-')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor contratado</h6>
                  <label>R$ {{number_format($cartao->valor_atribuido, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor utilizado</h6>
                  <label>R$ {{number_format($cartao->valor_utilizado, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor disponivel</h6>
                  <label>R$ {{number_format($cartao->valor_disponivel, 2, ',', '.')}}</label>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div class="text-center">
            <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
            <h5>Nenhuma informação encontrada.</h5>
          </div>
        @endif
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="carteiracredito">
        @if(isset($associado->RelationCarteiraCredito[0]))
          <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
            <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($associado->RelationCarteiraCredito[0]->data_movimento))}}</label>
          </div>
          @foreach($associado->RelationCarteiraCredito->sortByDesc('data_operacao') as $carteira)
          <div class="col-12"> 
            <div class="mb-5">
              <h5 class="font-weight-normal"><b>{{$carteira->num_contrato}}</b> <small>({{$carteira->situacao}})</small></h5>
              <hr class="mt-2">
              <div class="row">
                <div class="col-3">
                  <h6 class="mt-0">Produto</h6>
                  <label>{{$carteira->RelationArquivos->RelationProdutos->nome}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Modalidade</h6>
                  <label>{{$carteira->RelationArquivos->RelationModalidades->nome}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Data da operação</h6>
                  <label>{{date('d/m/Y', strtotime($carteira->data_operacao))}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Data da vencimento</h6>
                  <label>{{date('d/m/Y', strtotime($carteira->data_vencimento))}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <h6>Nível de risco</h6>
                  <label>{{$carteira->nivel_risco}}</label>
                </div>
                <div class="col-3">
                  <h6>Taxa da operação</h6>
                  <label>{{number_format($carteira->taxa_operacao, 2, ',', '')}} %</label>
                </div>
                <div class="col-3">
                  <h6>Taxa de mora</h6>
                  <label>{{number_format($carteira->taxa_mora, 2, ',', '')}} %</label>
                </div>
                <div class="col-3">
                  <h6>Taxa de multa</h6>
                  <label>{{number_format($carteira->taxa_multa, 2, ',', '')}} %</label>
                </div>
              </div>
              <div class="row">               
                <div class="col-3">
                  <h6>Qtd de parcelas</h6>
                  <label>{{$carteira->qtd_parcelas}}</label>
                </div>
                <div class="col-3">
                  <h6>Qtd de parcelas pagas</h6>
                  <label>{{$carteira->qtd_parcelas_pagas}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor contratado</h6>
                  <label>R$ {{number_format($carteira->valor_contrato, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor devido*</h6>
                  <label>R$ {{number_format($carteira->valor_devido, 2, ',', '.')}}</label>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div class="text-center">
            <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
            <h5>Nenhuma informação encontrada.</h5>
          </div>
        @endif
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="poupanca">
        @if(isset($associado->RelationPoupancas[0]))
          <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
            <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($associado->RelationPoupancas[0]->data_movimento))}}</label>
          </div>
          @foreach($associado->RelationPoupancas->sortByDesc('data_abertura') as $poupanca)
          <div class="col-12"> 
            <div class="mb-5">
              <h5 class="font-weight-normal"><b>{{$poupanca->num_conta}}</b> <small>({{$poupanca->situacao}})</small></h5>
              <hr class="mt-2">
              <div class="row">
                <div class="col-3">
                  <h6 class="mt-0">Tipo de conta</h6>
                  <label>{{$poupanca->tipo_conta}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Tipo de poupança</h6>
                  <label>{{$poupanca->tipo_poupanca}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Data de abertura</h6>
                  <label>{{date('d/m/Y', strtotime($poupanca->data_abertura))}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Valor saldo</h6>
                  <label>R$ {{number_format($poupanca->valor_saldo, 2, ',', '.')}}</label>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div class="text-center">
            <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
            <h5>Nenhuma informação encontrada.</h5>
          </div>
        @endif
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="aplicacoes">
        @if(isset($associado->RelationAplicacoes[0]))
          <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
            <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($associado->RelationAplicacoes[0]->data_movimento))}}({{$aplicacao->tipo}})</label>
          </div>
          @foreach($associado->RelationAplicacoes->sortByDesc('data_abertura') as $aplicacao)
          <div class="col-12"> 
            <div class="mb-5">
              <h5 class="font-weight-normal"><b>{{$aplicacao->num_conta}}</b></h5>
              <hr class="mt-2">
              <div class="row">
                <div class="col-3">
                  <h6 class="mt-0">Conta corrente</h6>
                  <label>{{$aplicacao->RelationContaCorrente->num_contrato}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Modalidade</h6>
                  <label>{{$aplicacao->modalidade}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Tipo</h6>
                  <label>{{$aplicacao->tipo}}</label>
                </div>
                <div class="col-3">
                  <h6 class="mt-0">Valor inicial</h6>
                  <label>R$ {{number_format($aplicacao->valor_inicial, 2, ',', '.')}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <h6>Valor da correção monetária</h6>
                  <label>R$ {{number_format($aplicacao->valor_correcao, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor saldo</h6>
                  <label>R$ {{number_format($aplicacao->valor_saldo, 2, ',', '.')}}</label>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div class="text-center">
            <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
            <h5>Nenhuma informação encontrada.</h5>
          </div>
        @endif
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="iap">
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('m/Y', strtotime($associado->RelationIAP->data_movimento))}}</label>
        </div>
        <div class="col-12"> 
          <h5 class="font-weight-normal"><b>Associado possui {{($associado->sigla == 'PF' ? $associado->RelationIAP->produtos_pf : $associado->RelationIAP->produtos_pj)}} produtos</b></h5>
          <hr class="mt-2">
          <div class="row mx-auto mb-5">
            <div class="col-3">
              @if($associado->RelationIAP->indicador_conta_limite)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Cheque especial  </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Cheque especial  </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_cobranca)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Cobrança </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Cobrança  </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_consorcio)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Consórcio </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Consórcio  </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_consorcio_auto)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Consórcio de auto. </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Consórcio de auto.  </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_consorcio_imovel)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Consórcio de imóvel </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Consórcio de imóvel  </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_consorcio_servicos)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Consórcio de serviços </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Consórcio de serviços  </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_consorcio_moto)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Consórcio de moto. </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Consórcio de moto.  </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_conta_capital)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Conta capital </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Conta capital </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_credito_rural)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Crédito rural </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Crédito rural </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_cartao_credito)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Cartão de crédito </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Cartão de crédito </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_sipag)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> SIPAG </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> SIPAG </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_previdencia)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Previdência </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Previdência </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_pacotes_tarifa)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Pacote de tarifas </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Pacote de tarifas </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_emprestimo)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Emprestimos </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Emprestimos </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_financiamento)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Financiamentos </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Financiamentos </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_poupanca)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Poupança </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Poupança </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_titulo_descontado)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Títulos descontados </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Títulos descontados </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_rdc)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> RDC </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> RDC </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_lca)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> LCA </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> LCA </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_seguro_auto)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Seguro de auto. </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Seguro de auto. </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_seguro_massificados)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Seguro empresarial/residêncial </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Seguro empresarial/residêncial </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_seguro_rural)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Seguro rural </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Seguro rural </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_seguro_vida)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Seguro de vida </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Seguro de vida </label>
              </div>
              @endif
            </div>
            <div class="col-3">
              @if($associado->RelationIAP->indicador_prestamista)
              <div class="radio radio-success">
                <input type="radio" checked>
                <label> Seguro prestamista </label>
              </div>
              @else
              <div class="radio radio-danger">
                <input type="radio" checked>
                <label> Seguro prestamista </label>
              </div>
              @endif
            </div>   
          </div>
        </div>
        <div class="clearfix"></div>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="bacen">
        <div class="col-12 text-center mb-5">
          <i class="ti-hummer" style="font-size: 30px"></i>
          <h4>Página em desenvolvimento!</h4>
        </div>
        <div class="row">
          <div class="col-3">
            <h6>Total a vencer</h6>
            <label>R$ 0,00</label>
          </div>
          <div class="col-3">
            <h6>Total vencido</h6>
            <label>R$ 0,00</label>
          </div>
          <div class="col-3">
            <h6>Prejuízo</h6>
            <label>R$ 0,00</label>
          </div>
          <div class="col-3">
            <h6>Respon. Total</h6>
            <label>R$ 0,00</label>
          </div> 
        </div>
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="inadimplencia">
        <div class="col-12 text-center">
          <i class="ti-hummer" style="font-size: 30px"></i>
          <h4>Página em desenvolvimento!</h4>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  @endsection

  @section('modal')
  @include('atendimento.painel.adicionarAtividade')
  @include('atendimento.painel.editarAtividade')
  @endsection

  @section('suporte')
  <script type="text/javascript">
    $(document).ready( function (){
      // Adicionando novas atividades
      $('#modal-adicionar #formAdicionar').on('submit', function(e){
        e.preventDefault();
        $.ajax({
          url: '{{ route("atividade.associado.atendimento") }}',
          type: 'POST',
          data: $('#modal-adicionar #formAdicionar').serialize(),
          beforeSend: function(){
            $('.modal-body, .modal-footer').addClass('d-none');
            $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
            $('#modal-adicionar #err').html('');
          },
          success: function(data){
            $('.modal-body, .modal-footer').addClass('d-none');
            $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
            setTimeout(function(){
              location.reload();
            }, 2000);
          }, error: function (data) {
            setTimeout(function(){
              $('.modal-body, .modal-footer').removeClass('d-none');
              $('.carregamento').html('');
              if(!data.responseJSON){
                console.log(data.responseText);
                $('#modal-adicionar #err').html(data.responseText);
              }else{
                $('#modal-adicionar #err').html('');
                $('input').removeClass('border-bottom border-danger');
                $.each(data.responseJSON.errors, function(key, value){
                  $('#modal-adicionar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
                  $('input[name="'+key+'"]').addClass('border-bottom border-danger');
                });
              }
            }, 2000);
          }
        });
      });

      // Retornando dados da atividade
      $('.editarAtividade').on('click', function(){
        url = $(this).attr('data');
        $.get(url, function(data){
          $('#modal-editar #identificador').val(data.id);
          $('#modal-editar .tipo').val(data.tipo);
          $('#modal-editar .descricao').html(data.descricao);
          $('#modal-editar .contato').val(data.contato);
        });
        $('#modal-editar').modal('show');
      });

      // Editando atividade
      $('#modal-editar #formEditar').on('submit', function(e){
        e.preventDefault();
        $.ajax({
          url: '{{ route("editando.atividade.associado.atendimento") }}',
          type: 'POST',
          data: $('#modal-editar #formEditar').serialize(),
          beforeSend: function(){
            $('.modal-body, .modal-footer').addClass('d-none');
            $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
            $('#modal-editar #err').html('');
          },
          success: function(data){
            $('.modal-body, .modal-footer').addClass('d-none');
            $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
            setTimeout(function(){
              location.reload();
            }, 2000);
          }, error: function (data) {
            setTimeout(function(){
              $('.modal-body, .modal-footer').removeClass('d-none');
              $('.carregamento').html('');
              if(!data.responseJSON){
                console.log(data.responseText);
                $('#modal-editar #err').html(data.responseText);
              }else{
                $('#modal-editar #err').html('');
                $('input').removeClass('border-bottom border-danger');
                $.each(data.responseJSON.errors, function(key, value){
                  $('#modal-editar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
                  $('input[name="'+key+'"]').addClass('border-bottom border-danger');
                });
              }
            }, 2000);
          }
        });
      });

    });
  </script>
  @endsection

