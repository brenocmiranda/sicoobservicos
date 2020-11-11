@section('title')
Painel comercial
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<h4 class="page-title">{{$associado->nome}} 
        <a href="{{route('exibir.painel.atendimento')}}" class="btn btn-dark btn-xs mx-2"> <small class="text-white">Pesquisar outro</small></a>
      </h4> 
		</div>
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Atendimento</a></li>
				<li><a class="active">Painel comercial</a></li>
			</ol>
		</div>
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
          <div> 
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
                <h6>Renda/Faturamento <small>(Mensal)</small></h6>
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
          <div>
            <h5>Contatos</h5>
            <hr class="mt-2">
          </div>
          
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="panel panel-info block2">
      <div class="panel-heading">
       <label>Dados financeiros</label>
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

@section('suporte')
<script type="text/javascript">
$(document).ready( function (){
});
</script>
@endsection