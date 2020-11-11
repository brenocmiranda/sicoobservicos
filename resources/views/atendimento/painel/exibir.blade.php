@section('title')
Painel do associado
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<h4 class="page-title">{{$associado->nome}} 
        <a href="{{route('exibir.painel.atendimento')}}" class="btn btn-dark btn-xs mx-2">
          <small class="text-white">Pesquisar outro</small>
        </a>
      </h4> 
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Atendimento</a></li>
        <li><a class="active">Painel do associado</a></li>
      </ol>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3 text-right"> 
    <a href="#" class="mx-2"><i class="mdi mdi-plus pr-2"></i>Cadastro de atividade</a>
    <a href="#" class="mx-2"><i class="mdi mdi-printer pr-2"></i>Imprimir</a>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="panel panel-info block2">
      <div class="panel-heading">
       <label>Dados cadastrais</label>
        <div class="panel-action text-white">
          <a href="javascript:void(0)" data-perform="panel-collapse">
            <i class="ti-angle-up"></i>
          </a> 
        </div>
      </div>
      <div class="panel-wrapper collapse in">
        <div class="panel-body">
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
                <h6 class="mt-0">{{($associado->descricao_identidade != 'NÃO SE APLICA' ? $associado->descricao_identidade : 'Documento de identificação')}}</h6>
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
                <h6>Porte do cliente</h6>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->porte_cliente : '-')}}</label>
              </div>
              <div class="col-3">
                <h6>Profissão</h6>
                <label>{{$associado->profissao}}</label>
              </div> 
            </div>
            <div class="row">
              <div class="col-3">
                <h6>Escolaridade</h6>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->escolaridade : '-')}}</label>
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
                <h6>Nível CRL <small>(Vigência até: {{(isset($associado->RelationConsolidado) ? date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) : '-')}})</small></h6>
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
            <h5>Dados financeiros</h5>
            <hr class="mt-2">
            <div class="col-12">
              <div class="row">
                <div class="col-3">
                  <h6>Tipo de renda</h6>
                  <label>{{$associado->tipo_renda}}</label>
                </div>
                <div class="col-3">
                  <h6>Renda/Faturamento <small>(Mensal bruto)</small></h6>
                  <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor bens <small>(Total)</small></h6>
                  <label>R$ {{(isset($associado->RelationConsolidado) ? number_format(@$associado->RelationConsolidado->valor_movel, 2, ',', '.') : '-')}}</label>
                </div>
                <div class="col-3">
                  <h6>Valor imóveis <small>(Total)</small></h6>
                  <label>R$ {{(isset($associado->RelationConsolidado) ? number_format(@$associado->RelationConsolidado->valor_imovel, 2, ',', '.') : '-')}}</label>
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
                  <label>{{(isset($associado->RelationConsolidado) ? ($associado->RelationConsolidado->inidicador_rural == 1 ? 'Sim' : 'Não') : '-')}}</label>
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
                  <h6>Número <small>(Total)</small></h6>
                  <label>{{$associado->RelationEnderecos->numero}}</label>
                </div>
                <div class="col-3">
                  <h6>Complemento <small>(Total)</small></h6>
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
                  <h6>País <small>(Total)</small></h6>
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
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="panel panel-info block2">
      <div class="panel-heading">
       <label>Conta Capital</label>
       <div class="panel-action text-white">
          <a href="javascript:void(0)" data-perform="panel-collapse" class="teste">
            <i class="ti-angle-down"></i>
          </a> 
        </div>
      </div>
      <div class="panel-wrapper collapse">
        <div class="panel-body">
          <div class="row">
            <div class="col-6">
              <h6 class="mt-0">Nome</h6>
              <label>{{$associado->nome}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Documento</h6>
              <label>{{$associado->documento}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Data de Nascimento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
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
              <h6>CNAE</h6>
              <label>{{$associado->cod_cnae}}</label>
            </div>
            <div class="col-3">
              <h6>Sexo</h6>
              <label>{{($associado->sexo == 'M' ? 'Masculino' : ($associado->sexo == 'F' ? 'Feminino' : 'Não classificado'))}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Data de relacionamento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
            </div>
            <div class="col-3">
              <h6>Data de renovação</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
            </div>
            <div class="col-3">
              <h6>Tipo de renda</h6>
              <label>{{$associado->tipo_renda}}</label>
            </div>
            <div class="col-3">
              <h6>Renda/Faturamento</h6>
              <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Gerente</h6>
              <label>#Nome da gerente</label>
            </div>
            <div class="col-3">
              <h6>PA</h6>
              <label>{{$associado->PA}}</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="panel panel-info block2">
      <div class="panel-heading">
       <label>Conta Corrente</label>
       <div class="panel-action text-white">
          <a href="javascript:void(0)" data-perform="panel-collapse" class="teste">
            <i class="ti-angle-down"></i>
          </a> 
        </div>
      </div>
      <div class="panel-wrapper collapse">
        <div class="panel-body">
          <div class="row">
            <div class="col-6">
              <h6 class="mt-0">Nome</h6>
              <label>{{$associado->nome}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Documento</h6>
              <label>{{$associado->documento}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Data de Nascimento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
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
              <h6>CNAE</h6>
              <label>{{$associado->cod_cnae}}</label>
            </div>
            <div class="col-3">
              <h6>Sexo</h6>
              <label>{{($associado->sexo == 'M' ? 'Masculino' : ($associado->sexo == 'F' ? 'Feminino' : 'Não classificado'))}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Data de relacionamento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
            </div>
            <div class="col-3">
              <h6>Data de renovação</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
            </div>
            <div class="col-3">
              <h6>Tipo de renda</h6>
              <label>{{$associado->tipo_renda}}</label>
            </div>
            <div class="col-3">
              <h6>Renda/Faturamento</h6>
              <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Gerente</h6>
              <label>#Nome da gerente</label>
            </div>
            <div class="col-3">
              <h6>PA</h6>
              <label>{{$associado->PA}}</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="panel panel-info block2">
      <div class="panel-heading">
       <label>Cartão de crédito</label>
       <div class="panel-action text-white">
          <a href="javascript:void(0)" data-perform="panel-collapse" class="teste">
            <i class="ti-angle-down"></i>
          </a> 
        </div>
      </div>
      <div class="panel-wrapper collapse">
        <div class="panel-body">
          <div class="row">
            <div class="col-6">
              <h6 class="mt-0">Nome</h6>
              <label>{{$associado->nome}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Documento</h6>
              <label>{{$associado->documento}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Data de Nascimento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
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
              <h6>CNAE</h6>
              <label>{{$associado->cod_cnae}}</label>
            </div>
            <div class="col-3">
              <h6>Sexo</h6>
              <label>{{($associado->sexo == 'M' ? 'Masculino' : ($associado->sexo == 'F' ? 'Feminino' : 'Não classificado'))}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Data de relacionamento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
            </div>
            <div class="col-3">
              <h6>Data de renovação</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
            </div>
            <div class="col-3">
              <h6>Tipo de renda</h6>
              <label>{{$associado->tipo_renda}}</label>
            </div>
            <div class="col-3">
              <h6>Renda/Faturamento</h6>
              <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Gerente</h6>
              <label>#Nome da gerente</label>
            </div>
            <div class="col-3">
              <h6>PA</h6>
              <label>{{$associado->PA}}</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="panel panel-info block2">
      <div class="panel-heading">
       <label>Carteira de crédito</label>
       <div class="panel-action text-white">
          <a href="javascript:void(0)" data-perform="panel-collapse" class="teste">
            <i class="ti-angle-down"></i>
          </a> 
        </div>
      </div>
      <div class="panel-wrapper collapse">
        <div class="panel-body">
          <div class="row">
            <div class="col-6">
              <h6 class="mt-0">Nome</h6>
              <label>{{$associado->nome}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Documento</h6>
              <label>{{$associado->documento}}</label>
            </div>
            <div class="col-3">
              <h6 class="mt-0">Data de Nascimento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
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
              <h6>CNAE</h6>
              <label>{{$associado->cod_cnae}}</label>
            </div>
            <div class="col-3">
              <h6>Sexo</h6>
              <label>{{($associado->sexo == 'M' ? 'Masculino' : ($associado->sexo == 'F' ? 'Feminino' : 'Não classificado'))}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Data de relacionamento</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
            </div>
            <div class="col-3">
              <h6>Data de renovação</h6>
              <label>{{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
            </div>
            <div class="col-3">
              <h6>Tipo de renda</h6>
              <label>{{$associado->tipo_renda}}</label>
            </div>
            <div class="col-3">
              <h6>Renda/Faturamento</h6>
              <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <h6>Gerente</h6>
              <label>#Nome da gerente</label>
            </div>
            <div class="col-3">
              <h6>PA</h6>
              <label>{{$associado->PA}}</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection