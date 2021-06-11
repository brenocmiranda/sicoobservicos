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
    <!--<a href="javascript:" data-toggle="modal" data-target="#modal-alterar" class="mx-2"><i class="mdi mdi-account-edit pr-2"></i>Alteração cadastral</a>
      <a href="javascript:" data-toggle="modal" data-target="#modal-renovar" class="mx-2"><i class="mdi mdi-account-convert pr-2"></i>Renovação cadastral</a>-->
      <a href="javascript:" data-toggle="modal" data-target="#modal-adicionar" class="mx-2"><i class="mdi mdi-plus pr-2"></i>Cadastro de atividade</a>
      <a href="javascript:" data-toggle="modal" data-target="#modal-impressao" class="mx-2 btn-imprimir"><i class="mdi mdi-printer pr-2"></i>Imprimir</a>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs customtab2 p-4 row justify-content-center" role="tablist" style="background: #38565a;border-radius: 10px;">
      <li role="presentation"  class="active"> <a href="#atividades" aria-controls="iap" role="tab" data-toggle="tab" aria-expanded="true"> <span>Atividades</span> </a> </li> 
      <li role="presentation"> <a href="#cadastro" aria-controls="cadastro" role="tab" data-toggle="tab" aria-expanded="true"> <span>Cadastro</span> </a> </li> 
      <li role="presentation"> <a href="#contacapital" aria-controls="contacapital" role="tab" data-toggle="tab" aria-expanded="true"> <span>Conta capital</span> </a> </li>       
      <li role="presentation"> <a href="#bacen" aria-controls="bacen" role="tab" data-toggle="tab" aria-expanded="true"> <span>BACEN</span> </a> </li> 
      <li role="presentation"> <a href="#contacorrente" aria-controls="contacorrente" role="tab" data-toggle="tab" aria-expanded="true"> <span>Conta corrente</span> </a> </li> 
      <li role="presentation"> <a href="#cartaocredito" aria-controls="cartaocredito" role="tab" data-toggle="tab" aria-expanded="true"> <span>Cartão de crédito</span> </a> </li> 
      <li role="presentation"> <a href="#carteiracredito" aria-controls="carteiracredito" role="tab" data-toggle="tab" aria-expanded="true"> <span>Emprestimos</span> </a> </li>
      <li role="presentation"> <a href="#poupanca" aria-controls="poupanca" role="tab" data-toggle="tab" aria-expanded="true"> <span>Poupança</span> </a> </li> 
      <li role="presentation"> <a href="#aplicacoes" aria-controls="aplicacoes" role="tab" data-toggle="tab" aria-expanded="true"> <span>Aplicações</span> </a> </li> 
      <li role="presentation"> <a href="#iap" aria-controls="iap" role="tab" data-toggle="tab" aria-expanded="true"> <span>IAP</span> </a> </li>  
      <li role="presentation"> <a href="#cobranca" aria-controls="cobranca" role="tab" data-toggle="tab" aria-expanded="true"> <span>Cobrança</span> </a> </li>
      <li role="presentation"> <a href="#consorcios" aria-controls="consorcios" role="tab" data-toggle="tab" aria-expanded="true"> <span>Consórcios</span> </a> </li>
      <li role="presentation"> <a href="#previdencias" aria-controls="previdencias" role="tab" data-toggle="tab" aria-expanded="true"> <span>Previdências</span> </a> </li> 
      <li role="presentation"> <a href="#seguros" aria-controls="seguros" role="tab" data-toggle="tab" aria-expanded="true"> <span>Seguros</span> </a> </li>
      <li role="presentation"> <a href="#sipag" aria-controls="sipag" role="tab" data-toggle="tab" aria-expanded="true"> <span>Sipag</span> </a> </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content white-box mt-0">
      <div role="tabpanel" class="tab-pane fade active in" id="atividades">
        @if(isset($atividades[0]))
        <div class="col-12">
          <div class="row">
            @foreach($atividades as $atividade)
            <div class="col-12">
              <h5 class="text-capitalize">{{$atividade->tipo}}</h5>
              <h6 class="font-weight-normal">Contato por: <b class="text-capitalize">{{$atividade->contato}}</b></h6>
              <label class="d-block">{{$atividade->descricao}}</label>
              <div class="row col-12">
                <small class="text-capitalize mr-auto"><b>{{$atividade->RelationUsuarios->RelationAssociado->nome}}</b> - {{date('d/m/Y H:i:s', strtotime($atividade->created_at))}}</small>
                @if(Auth::id() == $atividade->usr_id_usuario && $atividade->created_at > date('Y-m-d H:i:s', strtotime('-3 hours')))
                <small class="ml-auto">
                  <a href="javascript:" class="editarAtividade" data="{{route('detalhes.atividade.associado.atendimento', $atividade->id)}}"><i class="ti-pencil pr-2"></i>Editar</a>
                </small>
                @endif
              </div>
              <hr>
            </div>
            @endforeach
          </div>
        </div>
        @else
        <div class="text-center">
          <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
          <h5>Nenhuma informação encontrada.</h5>
        </div>
        @endif
        <div class="row justify-content-center">
          {!! (isset($atividades) ? $atividades->links() : '') !!}
        </div>
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="cadastro">
        <div class="col-12"> 
          <div class="row">
            <div class="col-lg-6 col-12">
              <h6 class="mt-lg-0">Nome</h6>
              <label>{{$associado->nome}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6 class="mt-lg-0">CPF/CNPJ</h6>
              <label>{{(strlen($associado->documento) == 11 ? substr($associado->documento, 0, 3).'.'.substr($associado->documento, 3, 3).'.'.substr($associado->documento, 6, 3).'-'.substr($associado->documento, 9, 2) : substr($associado->documento, 0, 2).'.'.substr($associado->documento, 3, 3).'.'.substr($associado->documento, 6, 3).'/'.substr($associado->documento, 8, 4).'-'.substr($associado->documento, 12, 2))}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6 class="mt-lg-0 text-truncate">{{($associado->descricao_identidade != 'NÃO SE APLICA' ? $associado->descricao_identidade : 'Documento de identificação')}}</h6>
              <label>{{($associado->numero_identidade != '-1' ? $associado->numero_identidade : '-')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-12">
              <h6>Razão social</h6>
              <label>{{$associado->nome_fantasia}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Atividade econônmica</h6>
              <label>{{$associado->atividade_economica}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Escolaridade</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->escolaridade : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Profissão</h6>
              <label>{{$associado->profissao}}</label>
            </div> 
          </div>
          <div class="row">
            <div class="col-lg-3 col-12">
              <h6>Porte do cliente</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->porte_cliente : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Data de Nascimento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Estado Cívil</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->estado_civil : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Sexo</h6>
              <label>{{($associado->sexo == 'M' ? 'Masculino' : ($associado->sexo == 'F' ? 'Feminino' : 'Não classificado'))}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-12">
              <h6>Nível CRL <small class="text-dark">(Vigência até: {{(isset($associado->RelationConsolidado) ? (date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) != date('d/m/Y', strtotime('1899-12-31')) ? date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) : '-') : '-')}})</small></h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->nivel_risco_crl : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Nível de risco</h6>
              <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->nivel_risco : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Data de relacionamento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Data de renovação</h6>
              @if(strtotime(date('Y-m-d', strtotime($associado->data_renovacao.'+ 1 year'))) < strtotime(date('Y-m-d')))
              <small class="bg-danger px-3 py-1 text-white rounded" style="border-radius:15px">
                {{date('d/m/Y', strtotime($associado->data_renovacao))}}
              </small>
              @else
              <label>{{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-12">
              <h6>Gerente</h6>
              <label>{{$associado->nome_gerente}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>PA</h6>
              <label>{{$associado->PA}}</label>
            </div> 
            <div class="col-lg-3 col-12">
              <h6>CNAE</h6>
              <label>{{$associado->cod_cnae}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Naturalidade</h6>
              <label>{{$associado->naturalidade}}</label>
            </div> 
            <div class="col-lg-3 col-12">
              <h6>Perfil tarifário</h6>
              <label>{{$associado->perfil_tarifario}}</label>
            </div> 
          </div>
          <div class="mt-5">
            <h5>Avaliação financeira</h5>
            <hr class="mt-2">
            <div class="col-12">
              <div class="row">
                <div class="col-lg-3 col-12">
                  <h6>Tipo de renda</h6>
                  <label>{{$associado->tipo_renda}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Renda/Faturamento <small class="text-dark">(Mensal bruto)</small></h6>
                  <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Valor bens móveis <small class="text-dark">(Total)</small></h6>
                  <label>R$ {{(isset($associado->RelationConsolidado) ? number_format(@$associado->RelationConsolidado->valor_movel, 2, ',', '.') : '-')}}</label>
                </div>
                <div class="col-lg-3 col-12">
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
                <div class="col-lg-3 col-12">
                  <h6>Participa de conglomerado?</h6>
                  <label>{{(isset($associado->RelationConglomerados) ? 'Sim' : 'Não')}}</label>
                </div>
                <div class="col-lg-9 col-12">
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
                <div class="col-lg-3 col-12">
                  <h6>Indicador de Produtor</h6>
                  <label>{{(isset($associado->RelationConsolidado) ? ($associado->RelationConsolidado->indicador_rural == 1 ? 'Sim' : 'Não') : '-')}}</label>
                </div>
                <div class="col-lg-6 col-12">
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
                <div class="col-lg-3 col-12">
                  <h6>Lagadouro</h6>
                  <label>{{@$associado->RelationEnderecos->rua}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Bairro</h6>
                  <label>{{@$associado->RelationEnderecos->bairro}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Número</h6>
                  <label>{{@$associado->RelationEnderecos->numero}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Complemento</h6>
                  <label>{{@$associado->RelationEnderecos->complemento}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-12">
                  <h6>Cidade</h6>
                  <label>{{@$associado->RelationEnderecos->cidade}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Estado</h6>
                  <label>{{@$associado->RelationEnderecos->estado}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>País</h6>
                  <label>{{@$associado->RelationEnderecos->pais}}</label>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-5">
            <h5>Contatos</h5>
            <hr class="mt-2">
            <div class="col-12">
              <div class="row">
                <div class="col-lg-3 col-12">
                  <h6>Telefone celular</h6>
                  <label>{{($associado->RelationTelefones->numero_celular != '-2' ? $associado->RelationTelefones->numero_celular : '-')}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Telefone comercial</h6>
                  <label>{{($associado->RelationTelefones->numero_comercial != '-2' ? $associado->RelationTelefones->numero_comercial : '-')}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Telefone residencial</h6>
                  <label>{{($associado->RelationTelefones->numero_residencial != '-2' ? $associado->RelationTelefones->numero_residencial : '-')}}</label>
                </div>
                <div class="col-lg-3 col-12">
                  <h6>Telefone recado</h6>
                  <label>{{($associado->RelationTelefones->numero_recado != '-2' ? $associado->RelationTelefones->numero_recado : '-')}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-12">
                  <h6>Email</h6>
                  <label>{{(isset($associado->RelationEmails->email) ? $associado->RelationEmails->email : '-')}}</label>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="contacapital">
        @if(isset($associado->RelationCapital))
        <div class="row mx-auto bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($cca_contacapital->data_movimento))}}</label>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-lg-3 col-12">
              <h6 class="mt-lg-0">Nº matrícula</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->num_capital : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6 class="mt-lg-0">Situação</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->situacao_capital : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6 class="mt-lg-0">Data da matrícula</h6>
              <label>{{(isset($associado->RelationCapital) ? date('d/m/Y', strtotime($associado->RelationCapital->data_matricula)) : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6 class="mt-lg-0">Data de saída da matrícula</h6>
              <label>{{(isset($associado->RelationCapital) ? (date('d/m/Y', strtotime($associado->RelationCapital->saida_matricula)) != '31/12/9999' ? date('d/m/Y', strtotime($associado->RelationCapital->saida_matricula)) : '-')  : '-')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-12">
              <h6>Tem direito ao voto?</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->direito_voto : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Tem direito ao rateio?</h6>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->direito_rateio : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Valor a integralizar</h6>
              <label>R$ {{(isset($associado->RelationCapital) ? number_format($associado->RelationCapital->valor_a_integralizar, 2, ',', '.') : '-')}}</label>
            </div>
            <div class="col-lg-3 col-12">
              <h6>Valor integralizado</h6>
              <label>R$ {{(isset($associado->RelationCapital) ? number_format($associado->RelationCapital->valor_integralizado, 2, ',', '.') : '-')}}</label>
            </div>
          </div>
        </div>
        @else
        <div class="text-center">
          <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
          <h5>Nenhuma informação encontrada.</h5>
        </div>
        @endif
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="bacen">
        @if(isset($associado->RelationBacen[0]))
        <div class="row bg-light justify-content-center mt-n4 mb-3 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('m/Y', strtotime($cli_bacen->data_movimento))}}</label>
        </div>
        <div class="col-12 row m-0 p-0">
          <div class="col-lg-3 col-6">
            <h6>Total a vencer</h6>
            <label>R$ {{number_format($associado->RelationBacen->sum('saldo_avencer'), 2, ',', '.')}}</label>
          </div>
          <div class="col-lg-3 col-6">
            <h6>Total vencido</h6>
            <label class="{{(!empty($associado->RelationBacen->sum('saldo_vencido')) ? 'text-danger' : '')}}">R$ {{number_format($associado->RelationBacen->sum('saldo_vencido'), 2, ',', '.')}}</label>
          </div>
          <div class="col-lg-3 col-6">
            <h6>Prejuízo</h6>
            <label class="{{(!empty($associado->RelationBacen->sum('saldo_prejuizo')) ? 'text-danger' : '')}}">R$ {{number_format($associado->RelationBacen->sum('saldo_prejuizo'), 2, ',', '.')}}</label>
          </div>
          <div class="col-lg-3 col-6">
            <h6>Respon. Total</h6>
            <label>R$ {{number_format(($associado->RelationBacen->sum('saldo_prejuizo')+$associado->RelationBacen->sum('saldo_vencido')+$associado->RelationBacen->sum('saldo_avencer')), 2, ',', '.')}}</label>
          </div> 
        </div>
        @foreach($associado->RelationBacen->sortBy('modalidade') as $dados)
        @if(!empty($dados->saldo_avencer) || !empty($dados->saldo_vencido) || !empty($dados->saldo_prejuizo) || !empty($dados->saldo_credito_liberar))
        <div class="col-12 mt-5">
          <h5>{{$dados->modalidade}} &#183 {{$dados->submodalidade}}</h5>
          <hr class="my-2">
          <div>
            <table class="col-12">
              <tbody class="col-12">
                @if(!empty($dados->saldo_avencer_30))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER ATÉ 30 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_30, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_3160))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 31 A 60 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_3160, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_6190))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 61 A 90 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_6190, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_91180))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 91 A 180 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_91180, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_181360))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 181 A 360 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_181360, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_361720))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 361 A 720 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_361720, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_7211080))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 721 A 1080 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_7211080, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_10811440))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 1081 A 1440 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_10811440, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_14411800))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 1441 A 1800 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_14411800, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_18015400))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 1801 A 5400 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_18015400, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_5400))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER ACIMA DE 5401 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_5400, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer_indeterminado))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">A VENCER DE 361 A 720 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_indeterminado, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_avencer))
                <tr class="border-top border-bottom">
                  <td style="width: 300px;"><h6 class="my-1">TOTAL A VENCER</h6></td>
                  <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_avencer), 2, ',', '.')}}</label></td>
                </tr>
                @endif

                <!-- Dados vencidos -->

                @if(!empty($dados->saldo_vencido_1530))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 15 A 30 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_1530, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_3160))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 31 A 60 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_3160, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_6190))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 61 A 90 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_6190, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_91120))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 91 A 120 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_91120, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_121150))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 121 A 150 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_121150, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_151180))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 151 A 180 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_151180, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_181240))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 181 A 240 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_181240, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_241300))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 241 A 300 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_241300, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_301360))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 301 A 360 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_301360, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_361540))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS DE 361 A 540 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_361540, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido_540))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">VENCIDOS ACIMA DE 540 DIAS</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_540, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_vencido))
                <tr class="border-top">
                  <td style="width: 300px;"><h6 class="my-1">TOTAL VENCIDO</h6></td>
                  <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_vencido), 2, ',', '.')}}</label></td>
                </tr>
                @endif

                <!-- Dados de prejuízo -->

                @if(!empty($dados->saldo_prejuizo))
                <tr class="text-danger">
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">CRÉDITOS BAIXADOS PARA PREJUIZO</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_prejuizo, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_prejuizo))
                <tr class="border-top">
                  <td style="width: 300px;"><h6 class="my-1">TOTAL PREJUÍZO</h6></td>
                  <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_prejuizo), 2, ',', '.')}}</label></td>
                </tr>
                @endif

                <!-- Créditos a liberar -->

                @if(!empty($dados->saldo_credito_liberar))
                <tr>
                  <td style="width: 300px;"><h6 class="my-1 font-weight-normal">LIMITE DE CRÉDITO</h6></td>
                  <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_credito_liberar, 2, ',', '.')}}</label></td>
                </tr>
                @endif
                @if(!empty($dados->saldo_credito_liberar))
                <tr class="border-top">
                  <td style="width: 300px;"><h6 class="my-1">TOTAL LIMITE</h6></td>
                  <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_credito_liberar), 2, ',', '.')}}</label></td>
                </tr>
                @endif

              </tbody>
            </table>
          </div>
        </div>
        @endif
        @endforeach
        @else
        <div class="text-center">
          <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
          <h5>Nenhuma informação encontrada.</h5>
        </div>
        @endif
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="contacorrente">
        @if(isset($associado->RelationContaCorrente[0]))
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($cco_contacorrente->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationContaCorrente->sortBy('situacao') as $conta)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$conta->num_contrato}}</b> <small class="{{($conta->situacao == 'ATIVA' ? 'badge badge-success' : ($conta->situacao == 'ENCERRADA' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$conta->situacao}}</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Modalidade</h6>
                <label>{{$conta->modalidade_conta}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Tipo de conta</h6>
                <label>{{$conta->tipo_conta}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Categoria</h6>
                <label>{{$conta->categoria_conta}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Utilizando o limite</h6>
                <label>{{$conta->utilizacao_limite}} dias</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Taxa de limite</h6>
                <label>{{number_format($conta->taxa_limite, 2, ',', '.')}} %</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor contratado</h6>
                <label>R$ {{number_format($conta->valor_contratado, 2, ',', '.')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor utilizado</h6>
                <label>R$ {{number_format($conta->valor_utilizado, 2, ',', '.')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor pacote tarifário</h6>
                <label>R$ {{number_format($conta->valor_pacote, 2, ',', '.')}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Saldo atual em conta</h6>
                <label>R$ {{number_format($conta->valor_saldo, 2, ',', '.')}}</label>
              </div>
              <div class="col-lg-3 col-12">
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
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($crt_cartaocredito->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationCartaoCredito->sortByDesc('situacao') as $cartao)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$cartao->num_contrato}}</b> <small class="{{($cartao->situacao == 'Operativo' ? 'badge badge-success' : ($cartao->situacao == 'Anulada pela entidade' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$cartao->situacao}}</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Produto</h6>
                <label>{{$cartao->produto_cartao}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Função do cartão</h6>
                <label>{{$cartao->funcao_cartao}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Bandeira</h6>
                <label>{{$cartao->bandeira_cartao}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Fatura</h6>
                <label>{{$cartao->fatura}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Data de implantação</h6>
                <label>{{(date('d/m/Y', strtotime($cartao->data_limite)) != '01/01/1900' ? date('d/m/Y', strtotime($cartao->data_limite)) : '-')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor contratado</h6>
                <label>R$ {{number_format($cartao->valor_atribuido, 2, ',', '.')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor utilizado</h6>
                <label>R$ {{number_format($cartao->valor_utilizado, 2, ',', '.')}}</label>
              </div>
              <div class="col-lg-3 col-12">
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
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($cre_contratos->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationCarteiraCredito->sortBy('situacao') as $carteira)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="row mx-auto font-weight-normal">
              <div class="mr-auto"> 
                <b>{{$carteira->num_contrato}}</b> 
                <small class="{{($carteira->situacao == 'ENTRADA NORMAL' ? 'badge badge-success' : ($carteira->situacao == 'QUITADO' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$carteira->situacao}}</small>
                <small class="text-danger font-weight-bold">{!!($carteira->RelationParcelas->max('dias_atraso') > 15 ? '&#183 POSSUI PARCELAS EM ATRASO HÁ '.$carteira->RelationParcelas->max('dias_atraso').' DIAS' : '')!!}</small>
              </div>
             
              <div class="ml-auto">
                @if(isset($carteira->RelationGarantias[0]) || isset($carteira->RelationAvalistas[0]))
                <a href="javascript:" class="pr-3" data-toggle="modal" data-target="#{{$carteira->num_contrato}}-garantias">
                  <i class="mdi mdi-bulletin-board mdi-18px"></i>
                  <small>Garantias da operação</small>
                </a>
                @endif
                @if(isset($carteira->RelationParcelas[0]))
                <a href="javascript:" data-toggle="modal" data-target="#{{$carteira->num_contrato}}-parcelas">
                  <i class="mdi mdi-file-outline mdi-18px"></i>
                  <small>Extrato da operação</small>
                </a>
                @endif
              </div>
              
            </h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Produto</h6>
                <label>{{$carteira->RelationArquivos->RelationProdutos->nome}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Modalidade</h6>
                <label>{{$carteira->modalidade}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6  class="mt-lg-0">Finalidade</h6>
                <label>{{$carteira->finalidade}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6  class="mt-lg-0">Renegociação?</h6>
                <label>{{$carteira->renegociacao}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Nível de risco</h6>
                <label>{{$carteira->nivel_risco}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data da operação</h6>
                <label>{{date('d/m/Y', strtotime($carteira->data_operacao))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data da vencimento</h6>
                <label>{{date('d/m/Y', strtotime($carteira->data_vencimento))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data de quitação</h6>
                <label>{{($carteira->data_quitacao != "1900-01-01" ? date('d/m/Y', strtotime($carteira->data_quitacao)) : '-')}}</label>
              </div>
            </div>
            <div class="row">   
              <div class="col-lg-3 col-12">
                <h6>Taxa da operação</h6>
                <label>{{number_format($carteira->taxa_operacao, 2, ',', '')}} %</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Taxa de mora</h6>
                <label>{{number_format($carteira->taxa_mora, 2, ',', '')}} %</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Taxa de multa</h6>
                <label>{{number_format($carteira->taxa_multa, 2, ',', '')}} %</label>
              </div>            
              <div class="col-lg-3 col-12">
                <h6>Valor contratado</h6>
                <label>R$ {{number_format($carteira->valor_contrato, 2, ',', '.')}}</label>
              </div>
            </div>
            <div class="row">               
              <div class="col-lg-3 col-12">
                <h6>Qtd de parcelas</h6>
                <label>{{$carteira->qtd_parcelas}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Qtd de parcelas pagas</h6>
                <label>{{$carteira->qtd_parcelas_pagas}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor da parcela</h6>
                <label>R$ {{($carteira->RelationParcelas->sortBy('num_parcela')->last()['valor_parcela'] > 0 ? number_format($carteira->RelationParcelas->sortBy('num_parcela')->last()['valor_parcela'], 2, ',', '.') : number_format($carteira->RelationParcelas->sortBy('num_parcela')->last()['valor_devedor_parcela'], 2, ',', '.'))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Saldo devedor</h6>
                <label>R$ {{number_format($carteira->valor_devido, 2, ',', '.')}}</label>
              </div>
            </div>
            @if(isset($carteira->RelationParcelas[0]))
            <!-- Extrato operação de crédito -->
            <div class="modal fade" id="{{$carteira->num_contrato}}-parcelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
              <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header d-block pb-0">
                    <div class="col-12">
                      <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h5 class="modal-title">Extrato da operação de crédito</h5>
                    </div>
                    <div class="col-12 mb-0">
                      <p>Informações do contrato de crédito</p>
                    </div>
                    <div id="err"></div>
                  </div>
                  <div class="carregamento"></div>
                  <div class="modal-body">
                    <div class="col-12 mx-auto">
                      <table class="table text-center color-table inverse-table border">
                        <thead>
                          <th>Nº de parcela</th>
                          <th>Data de vencimento</th>
                          <th>Valor da parcela</th>
                          <th>Dias de atraso</th>
                          <th>Situação</th>
                        </thead>
                        <tbody>
                          @foreach($carteira->RelationParcelas->sortBy('num_parcela') as $parcelas)
                          <tr>
                            <td>{{$parcelas->num_parcela}}</td>
                            <td>{{($parcelas->data_vencimento != "1900-01-01" ? date('d/m/Y', strtotime($parcelas->data_vencimento)) : '-')}}</td>
                            <td>R$ {{($parcelas->valor_parcela > 0 ? number_format($parcelas->valor_parcela, 2, ',', '.') : number_format($parcelas->valor_devedor_parcela, 2, ',', '.'))}}</td>
                            <td>{{$parcelas->dias_atraso}} dias</td>
                            <td>{{$parcelas->situacao}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Extrato operação de crédito -->
            @endif
            @if(isset($carteira->RelationGarantias[0]) || isset($carteira->RelationAvalistas[0]))
            <!-- Garantias da operação de crédito -->
            <div class="modal fade" id="{{$carteira->num_contrato}}-garantias" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
              <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header d-block pb-0">
                    <div class="col-12">
                      <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h5 class="modal-title">Garantias da operação de crédito</h5>
                    </div>
                    <div class="col-12 mb-0">
                      <p>Informações do contrato de crédito</p>
                    </div>
                    <div id="err"></div>
                  </div>
                  <div class="carregamento"></div>
                  <div class="modal-body">
                    <div class="col-12 mx-auto">
                      <div class="card-body pt-0">
                        <div class="row">
                          <h5>Garantias Fidejussórias <small>{{(isset($carteira->RelationAvalistas[0]) ? '('.date('d/m/Y', strtotime($carteira->RelationAvalistas->first()->data_movimento)).')' : '')}}</small></h5>
                          <hr class="w-100 mt-1 mb-3">
                          @if(isset($carteira->RelationAvalistas[0]))
                            @foreach($carteira->RelationAvalistas as $avalistas)
                            <div class="col-lg-12 col-12">
                              <div class="form-group">
                                <label class="col-form-label">Avalista</label>
                                <p>{{$avalistas->RelationAssociados->nome}}</p>
                              </div>
                            </div>
                            @endforeach
                          @else
                          <div class="col-12 text-left">
                            <label>Nenhuma informação encontrada.</label>
                          </div>
                          @endif
                        </div>
                        <br>
                        <div class="row">
                          <h5>Garantias Fidunciária <small>{{(isset($carteira->RelationGarantias[0]) ? '('.date('d/m/Y', strtotime($carteira->RelationGarantias->first()->data_movimento)).')' : '')}}</small></h5>
                          <hr class="w-100 mt-1 mb-3">
                          @if(isset($carteira->RelationGarantias[0]))
                            @foreach($carteira->RelationGarantias as $reais)
                            <div class="col-lg-4 col-12">
                              <div class="form-group">
                                <label class="col-form-label">Tipo</label>
                                <p>{{$reais->tipo}}</p>
                              </div>
                            </div>
                            <div class="col-lg-8 col-12">
                              <div class="form-group">
                                <label class="col-form-label">Descrição</label>
                                <p>{{$reais->descricao}}</p>
                              </div>
                            </div>
                            @endforeach
                          @else
                          <div class="col-12 text-left">
                            <label>Nenhuma informação encontrada.</label>
                          </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Garantias da operação de crédito -->
            @endif
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
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($pop_poupanca->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationPoupancas->sortByDesc('data_abertura') as $poupanca)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$poupanca->num_conta}}</b> <small class="{{($poupanca->situacao == 'ATIVA' ? 'badge badge-success' : ($poupanca->situacao == 'ENCERRADA' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$poupanca->situacao}}</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Tipo de conta</h6>
                <label>{{$poupanca->tipo_conta}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Tipo de poupança</h6>
                <label>{{$poupanca->tipo_poupanca}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Data de abertura</h6>
                <label>{{date('d/m/Y', strtotime($poupanca->data_abertura))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Valor saldo</h6>
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
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($dep_aplicacoes->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationAplicacoes->sortByDesc('data_abertura') as $aplicacao)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$aplicacao->num_conta}}</b> <small>({{$aplicacao->tipo}})</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Conta corrente</h6>
                <label>{{$aplicacao->RelationContaCorrente->num_contrato}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Modalidade</h6>
                <label>{{$aplicacao->modalidade}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Tipo</h6>
                <label>{{$aplicacao->tipo}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Valor inicial</h6>
                <label>R$ {{number_format($aplicacao->valor_inicial, 2, ',', '.')}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Valor da correção monetária</h6>
                <label>R$ {{number_format($aplicacao->valor_correcao, 2, ',', '.')}}</label>
              </div>
              <div class="col-lg-3 col-12">
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
        <?php $count = 0; ?>
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime('-3 days'))}} </label>
        </div>
        <div class="col-12 px-0 px-lg-4"> 
          <h5 class="font-weight-normal"><b>Associado possui <span class="IAP">{{($associado->sigla == 'PF' ? @$associado->RelationIAP->produtos_pf : @$associado->RelationIAP->produtos_pj)}}</span> produtos/serviços</b></h5>
          <hr class="mt-2">
          <div class="row mx-auto mb-5">
            <div class="col-lg-3 col-6">
              @if($associado->RelationCartaoCredito->sum('valor_atribuido') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#cartaocredito]').click();">  
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Cartão de crédito </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Cartão de crédito </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationContaCorrente->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#contacorrente]').click();">  
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Cheque especial  </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Cheque especial  </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationCobrancas->where('situacao', 'ATIVO')->count() > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#cobranca]').click();">  
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Cobrança </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Cobrança  </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'VEICULOS AUTOMOTORES NAO INCLUIDOS NO SEGMENTO ANTERIOR, EXCETO MOTOCICLETAS E MOTONETAS')->sum('valor_contratado') > 0 || $associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'TRATORES,EQUIP. RODOVIARIOS,MAQ. E EQUIP. AGRICOLAS,EMBARCACOES,AERONAVES,VEICULOS AUTOMOTORES DESTINADOS TRANSP. CARGAS CAPACIDADE SUPERIOR A 1.500 KG. E VEICULOS AUTOMOTORES DESTINADOS TRANSP. COLETIVO CAPACIDADE PARA 20 (VINTE) PASSAGEIROS OU MAIS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#consorcios]').click();">  
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Consórcio de auto. </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Consórcio de auto.  </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'IMÓVEIS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#consorcios]').click();">  
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Consórcio de imóvel </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">   
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Consórcio de imóvel  </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'SERVICOS TURISTICOS (BILHETES DE PASSAGEM AEREA E/OU PACOTES TURISTICOS)')->sum('valor_contratado') > 0 || $associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'OUTROS BENS MOVEIS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#consorcios]').click();">   
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Consórcio de serviços </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">   
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Consórcio de serviços  </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'MOTOCICLETAS E MOTONETAS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#consorcios]').click();">   
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Consórcio de moto. </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">    
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Consórcio de moto.  </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10006')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10052')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10053')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10054')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10055')->count() > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#carteiracredito]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Crédito rural </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Crédito rural </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if(@$associado->RelationIAP->indicador_debito)
              <?php $count++; ?>
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Debito automático </label>
                </div>
              @else
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Debito automático </label>
                </div>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '!=', '10006')->where('codigo_modalidade', '!=', '10052')->where('codigo_modalidade', '!=', '10053')->where('codigo_modalidade', '!=', '10054')->where('codigo_modalidade', '!=', '10055')->where('codigo_modalidade', '!=', '1018')->where('codigo_modalidade', '!=', '1024')->count() > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#carteiracredito]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Emprestimos </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Emprestimos </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '1018')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '1024')->count() > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#carteiracredito]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Financiamentos </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Financiamentos </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationPoupancas->sum('valor_saldo') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#poupanca]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Poupança </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Poupança </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationPrevidencias->sum('valor_proposta') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#previdencias]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Previdência </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Previdência </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationAplicacoes->where('tipo', 'RDC')->sum('valor_saldo') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#aplicacoes]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> RDC </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> RDC </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationAplicacoes->where('tipo', 'LCA')->sum('valor_saldo') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#aplicacoes]').click();"> 
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> LCA </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> LCA </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationSeguros->where('familia', 'AUTOMÓVEL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'CONSÓRCIO AUTO')->sum('premio_bruto') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#seguros]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Seguro de auto. </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Seguro de auto. </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if(@$associado->RelationIAP->indicador_prestamista)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#seguros]').click();"> 
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Seguro prestamista </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Seguro prestamista </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationSeguros->where('familia', 'PRESTAMISTA')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'RESIDENCIAL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'EMPRESARIAL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'DEMAIS')->sum('premio_bruto') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#seguros]').click();"> 
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Seguro massificado </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Seguro massificado </label>
                </div>
              </a>
              @endif
            </div>  
            <div class="col-lg-3 col-6">
              @if(@$associado->RelationIAP->indicador_seguro_rural)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#seguros]').click();"> 
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Seguro rural </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Seguro rural </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationSeguros->where('familia', 'VIDA EMPRESARIAL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'VIDA INDIVIDUAL')->sum('premio_bruto') > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#seguros]').click();"> 
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Seguro de vida </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Seguro de vida </label>
                </div>
              </a>
              @endif
            </div> 
            <div class="col-lg-3 col-6">
              @if($associado->RelationSipag->where('status', 'ATIVO')->count() > 0)
              <?php $count++; ?>
              <a href="javascript:" class="text-dark" onclick="$('a[href=#sipag]').click();"> 
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> SIPAG </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark"> 
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> SIPAG </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if(@$associado->RelationIAP->indicador_titulo_descontado)
              <?php $count++; ?>
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
          </div>
          <h5 class="font-weight-normal"><b>Outros produtos/serviços </b></h5>
          <hr class="mt-2">
          <div class="row mx-auto mb-5">
            <div class="col-lg-3 col-6">
              @if(isset($associado->RelationCapital) && $associado->RelationCapital->valor_integralizado > 0)
              <a href="javascript:" class="text-dark" onclick="$('a[href=#contacapital]').click();">
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Conta capital </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Conta capital </label>
                </div>
              </a>
              @endif
            </div>
            <div class="col-lg-3 col-6">
              @if($associado->RelationContaCorrente->sum('valor_pacote') > 0)
              <a href="javascript:" class="text-dark" onclick="$('a[href=#contacorrente]').click();">  
                <div class="radio radio-success">
                  <input type="radio" checked>
                  <label> Pacote de tarifas </label>
                </div>
              </a>
              @else
              <a href="javascript:" class="text-dark">  
                <div class="radio radio-danger">
                  <input type="radio" checked>
                  <label> Pacote de tarifas </label>
                </div>
              </a>
              @endif
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="cobranca">
        @if(isset($associado->RelationCobrancas[0]))
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($pro_cobranca->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationCobrancas->sortByDesc('data_adesao') as $cobranca)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$cobranca->perfil}}</b> <small class="{{($cobranca->situacao == 'ATIVO' ? 'badge badge-success' : ($cobranca->situacao == 'SERVIÇO SUSPENSO' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$cobranca->situacao}}</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-4 col-12">
                <h6 class="mt-lg-0">Ramo</h6>
                <label>{{$cobranca->ramo}}</label>
              </div>
              <div class="col-lg-6 col-12">
                <h6 class="mt-lg-0">Grupo</h6>
                <label>{{$cobranca->grupo}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Possui cotrato?</h6>
                <label>{{($cobranca->indicador_contrato == 1 ? 'SIM' : 'NÃO')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Tipo de DDA</h6>
                <label>{{$cobranca->tipo_dda}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data de adesão</h6>
                <label>{{date('d/m/Y', strtotime($cobranca->data_adesao))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Float</h6>
                <label>{{$cobranca->float}} dia(s)</label>
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
      </div>
      <div role="tabpanel" class="tab-pane fade" id="consorcios">
        @if(isset($associado->RelationConsorcios[0]))
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($pro_consorcios->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationConsorcios->sortBy('versao') as $consorcios)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$consorcios->n_contrato}}</b> <small class="{{($consorcios->versao == 'ATIVA' ? 'badge badge-success' : ($consorcios->versao == 'CANCELADO POR SOLICITAÇÃO OU INAD.' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$consorcios->versao}}</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-6 col-12">
                <h6 class="mt-lg-0">Segmento</h6>
                <label>{{$consorcios->segmento}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Bem de referência</h6>
                <label>{{$consorcios->bem_referencia}}</label>
              </div>  
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Situação</h6>
                <label>{{$consorcios->situacao}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Grupo</h6>
                <label>{{$consorcios->grupo}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Cota</h6>
                <label>{{$consorcios->cota}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Taxa de administração</h6>
                <label>{{number_format($consorcios->taxa_administracao, 2, ',', '.')}} %</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Forma de pagamento</h6>
                <label>{{$consorcios->forma_pagamento}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Tipo de comtemplação</h6>
                <label>{{$consorcios->tipo_contemplacao}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data de adesão</h6>
                <label>{{date('d/m/Y', strtotime($consorcios->data_adesao))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data de cancelamento</h6>
                <label>{{($consorcios->data_cancelamento != '1899-12-31' ? date('d/m/Y', strtotime($consorcios->data_cancelamentoo)) : '-')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor contratado</h6>
                <label>R$ {{number_format($consorcios->valor_contratado, 2, ',', '.')}}</label>
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
      </div>
      <div role="tabpanel" class="tab-pane fade" id="previdencias">
        @if(isset($associado->RelationPrevidencias[0]))
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($pro_previdencias->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationPrevidencias->sortByDesc('data_adesao') as $previdencias)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$previdencias->n_registro}}</b> <small class="{{($previdencias->tipo_participante == 'ATIVO - COBRANÇA BANCÁRIA' ? 'badge badge-success' : ($previdencias->tipo_participante == 'CANCELADO' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$previdencias->situacao_participante}}</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Plano</h6>
                <label>{{$previdencias->plano}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Regime</h6>
                <label>{{$previdencias->regime}}</label>
              </div>  
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Tipo de participante</h6>
                <label>{{$previdencias->tipo_participante}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Situação</h6>
                <label>{{$previdencias->situacao_participante}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Forma de pagamento</h6>
                <label>{{$previdencias->forma_pagamento}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data de adesão</h6>
                <label>{{date('d/m/Y', strtotime($previdencias->data_adesao))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Data de cancelamento</h6>
                <label>{{($previdencias->data_desligamento != '1900-01-01' ? date('d/m/Y', strtotime($previdencias->data_desligamento)) : '-')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Valor da proposta</h6>
                <label>R$ {{number_format($previdencias->valor_proposta, 2, ',', '.')}}</label>
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
      </div>
      <div role="tabpanel" class="tab-pane fade" id="seguros">
        @if(isset($associado->RelationSeguros[0]))
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('d/m/Y', strtotime($pro_seguros->data_movimento))}}</label>
        </div>
        @foreach($associado->RelationSeguros->sortByDesc('data_vigencia') as $seguros)
        <div class="col-12"> 
          <div class="mb-5">
            <h5 class="font-weight-normal"><b>{{$seguros->produto}}</b> <small class="badge badge-success">Vigente</small></h5>
            <hr class="mt-2">
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Nº da apólice</h6>
                <label>{{$seguros->n_apolice}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Ramo</h6>
                <label>{{$seguros->ramo}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Família</h6>
                <label>{{$seguros->familia}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6 class="mt-lg-0">Tipo proposta</h6>
                <label>{{$seguros->tipo_proposta}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Corretora</h6>
                <label>{{$seguros->corretora}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Seguradora</h6>
                <label>{{$seguros->seguradora}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Início de vigência</h6>
                <label>{{date('d/m/Y', strtotime($seguros->data_vigencia))}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Final de vigência</h6>
                <label>{{($seguros->data_encerramento != '1900-01-01' ? date('d/m/Y', strtotime($seguros->data_encerramento)) : '-')}}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                <h6>Prêmio Líquido</h6>
                <label>R$ {{number_format($seguros->premio_liquido, 2, ',', '.')}}</label>
              </div>
              <div class="col-lg-3 col-12">
                <h6>Prêmio Bruto</h6>
                <label>R$ {{number_format($seguros->premio_bruto, 2, ',', '.')}}</label>
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
      </div>
      <div role="tabpanel" class="tab-pane fade" id="sipag">
        @if(isset($associado->RelationSipag[0]))
        <div class="row bg-light justify-content-center mt-n4 mb-5 p-3 rounded">
          <label class="m-auto font-weight-bold">Data base: {{date('m/Y', strtotime(@$pro_sipag->data_movimento))}}</label>
        </div>
          @foreach($associado->RelationSipag->sortByDesc('data_credenciamento') as $sipag)
          <div class="col-12"> 
            <div class="mb-5">
              <h5 class="font-weight-normal"><b>{{str_replace('_', ' ', $sipag->base)}}</b> <small class="{{($sipag->status == 'ATIVO' ? 'badge badge-success' : ($sipag->status == 'SUSPENSO' ? 'badge badge-danger' : 'badge badge-info'))}}">{{$sipag->status}}</small></h5>
              <hr class="mt-2">
              <div class="row mx-auto">
                <div class="col-lg-8 px-0 col-12">
                  <div class="col-lg-6 col-12">
                    <h6 class="mt-lg-0">Estabelescimento</h6>
                    <label>{{$sipag->ec}}</label>
                  </div>
                  <div class="col-lg-6 col-12">
                    <h6 class="mt-lg-0">MCC</h6>
                    <label>{{(isset($sipag->descricao_mcc) ? $sipag->descricao_mcc : 'Não possui')}}</label>
                  </div>
                  <div class="col-lg-6 col-12">
                    <h6>Macro Segmento</h6>
                    <label>{{(isset($sipag->segmento) ? $sipag->segmento : 'Não possui')}}</label>
                  </div>
                  <div class="col-lg-6 col-12">
                    <h6>Domicílio <small>(Banco/Agência)</small></h6>
                    <label>{{$sipag->domicilio_banco}} - {{$sipag->domicilio_agencia}}</label>
                  </div>
                  <div class="col-lg-6 col-12">
                    <h6>Data de credênciamento</h6>
                    <label>{{date('d/m/Y', strtotime($sipag->data_credenciamento))}}</label>
                  </div>
                  <div class="col-lg-6 col-12">
                    <h6>Faturamento acumulado <small>({{date('Y')}})</small></h6>
                    <label>R$ {{number_format($sipag->RelationFaturamento->sum('total_cnpj'), 2, ',', '.')}}</label>
                  </div>
                </div>
                <div class="col-lg-4 col-12 pl-0">
                  @if($sipag->RelationFaturamento->sum('total_cnpj') > 0)
                    <div class="row">
                      <div class="col-12">
                        <table class="table table-striped text-center border">
                          <thead>
                            <th>Data de movimento</th>
                            <th>Valor faturado</th>
                          </thead>
                          <tbody>
                            @foreach($sipag->RelationFaturamento->sortByDesc('data_movimento') as $faturamento)
                            <tr>
                              <td>{{date('m/Y', strtotime($faturamento->data_movimento))}}</td> 
                              <td>{{number_format($faturamento->total_cnpj, 2, ',', '.')}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @else
                  <div class="row col-12 h-100 px-0 align-items-center justify-content-center">
                    <div class="text-center">
                      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
                      <h5>Não possui faturamento.</h5>
                    </div>
                  </div>
                  @endif
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
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')
  @include('atendimento.painel.adicionarAtividade')
  @include('atendimento.painel.editarAtividade')
  @include('atendimento.painel.impressao')
@endsection

@section('suporte')
<script type="text/javascript">
  $(document).ready( function (){

    // Quantidade de produtos 
    $('.IAP').html({{$count}});

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
    
    // Relatório de impressão
    $('#modal-impressao #formImpressao').on('submit', function(e){
      $('#modal-impressao .modal-body, #modal-impressao .modal-footer').addClass('d-none');
      $('#modal-impressao .carregamento').removeClass('d-none');
      $('#modal-impressao .carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Relatório gerado com sucesso!</label></div>');
      setTimeout(function(){
        $('#modal-impressao').modal('hide');
        $('#modal-impressao .modal-body, #modal-impressao .modal-footer').removeClass('d-none');
        $('#modal-impressao .carregamento').addClass('d-none');
      }, 2000);      
    });
});
</script>
@endsection

