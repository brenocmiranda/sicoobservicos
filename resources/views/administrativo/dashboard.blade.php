@section('title')
Dashboard
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-12">
			<h4 class="page-title col-4">Dashboard </h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Administrativo</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div>
	</div>
	<div class="row mx-auto">
		<div class="sttabs tabs-style-iconbox" style="border-radius: 0.6em; border: transparent;">
			<nav>
				<ul style="background: transparent; border: transparent;">
					<li class="tab-current"><a href="#section-iconbox-1" class="sticon ti-ruler-pencil"><span>Materiais</span></a></li>
					<li><a href="#section-iconbox-2" class="sticon ti-files"><span>Documentos</span></a></li>
					<li><a href="#section-iconbox-3" class="sticon ti-car"><span>Bens da cooperativa</span></a> </li>
				</ul>
			</nav>
			<div class="content-wrap">
				<section id="section-iconbox-1" class="content-current">
					<div class="row col-12 white-box mx-auto">
						<div class="w-100 mb-5 pb-5">
                            <div class="col-lg-4 col-sm-6 row-in-br">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-warning"><i class="ti-help"></i></span>
                                    </li>
                                    <li class="col-last">
                                        <h3 class="counter text-right m-t-15">{{count($materiaisHistorico->where('tipo', 's')->where('status', 0))}}</h3>
                                    </li>
                                    <li class="col-middle">
                                        <h4>Solicitações em aberto</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 0)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 0)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}%">
                                                <span class="sr-only">{{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 0)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}% Pendente (pendente)</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-danger"><i class="ti-package"></i></span>
                                    </li>
                                    <li class="col-last">
                                        <h3 class="counter text-right m-t-15">{{count($materiaisHistorico->where('tipo', 's')->where('status', 2))}}</h3>
                                    </li>
                                    <li class="col-middle">
                                        <h4>Solicitações canceladas</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 2)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 2)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}%">
                                                <span class="sr-only">{{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 2)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}% Total (total)</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-sm-6 row-in-br b-r-none">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-success"><i class="ti-check"></i></span>
                                    </li>
                                    <li class="col-last">
                                        <h3 class="counter text-right m-t-15">{{count($materiaisHistorico->where('tipo', 's')->where('status', 1))}}</h3>
                                    </li>
                                    <li class="col-middle">
                                        <h4>Solicitações aprovadas</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 1)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 1)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}%">
                                                <span class="sr-only">{{(isset($materiaisHistorico->where('tipo', 's')[0]) ? (100*count($materiaisHistorico->where('tipo', 's')->where('status', 1)))/count($materiaisHistorico->where('tipo', 's')) : 0)}}% Aprovado (aprovado)</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Total de materiais</h3>
							<hr class="mt-2">
							<div class="col-lg-12 col-sm-12 col-xs-12 text-center row m-auto align-items-center justify-content-center h-75 pb-5">
								<h1 style="font-size: 55px;">{{count($materiais->where('status', 1))}} 
									<small>cadastrados</small>
								</h1>
							</div>
						</div>
						<div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Quantidade de materiais por categoria</h3>
							<hr class="mt-2">
							<div id="morris-donut-chart2" class="morris-donut-chart" style="height: 300px"></div>
						</div>
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-5">
							<h3 class="box-title mb-0">Materiais com quantidade mínima</h3>
							<hr class="mt-2">
							<ul class="country-state">
								@foreach($materiais as $dados)
									@if($dados->quantidade <= $dados->quantidade_min)
									<li>
										<h5>{{$dados->nome}}</h5>
										<small>{{$dados->quantidade}} restantes </small>
										<div class="pull-right">{{$dados->quantidade_min}} <i class="fa fa-level-down text-danger"></i></div>
										<div class="progress">
											<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="(($dados->quantidade*100)/$dados->quantidade_min)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{(($dados->quantidade*100)/$dados->quantidade_min)}}%"> <span class="sr-only">{{(($dados->quantidade*100)/$dados->quantidade_min)}}% Complete</span></div>
										</div>
									</li>
									@endif
								@endforeach
							</ul>
						</div> 
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-5">
							<h3 class="box-title mb-0">Histórico de saídas</h3>
							<hr class="mt-2">
							<div class="table-responsive">
								<table class="table color-table muted-table" id="table3">
									<thead>
										<tr>
											<th>Produto</th>
											<th>Solicitante</th>
											<th>Data</th>
											<th>Quantidade</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										@foreach($materiaisHistorico->where('tipo', 's')->sortByDesc('created_at') as $key => $historico)
										<tr class="text-center">
											<td><small>{{$historico->RelationMaterial->nome}}</small></td>
											<td><small>{{$historico->RelationUsuario->RelationAssociado->nome}}</small></td>
											<td><small>{{$historico->created_at->format('d/m/Y H:i')}}</small></td>
											<td><small>{{$historico->quantidade}} {{$historico->quantidade_tipo}}</small></td>
											<td><span class="label {{($historico->status == 0 ? 'label-warning' : 'label-success')}} label-rouded">{{($historico->status == 0 ? "Pendente" : "Aprovada")}}</span> </td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<div class="col-lg-12 col-sm-12 col-xs-12 mt-5">	
							<h3 class="box-title mb-0">Histórico de entradas</h3>
							<hr class="mt-2">		
							<div class="table-responsive">
								<table class="table color-table muted-table" id="table4">
									<thead>
										<tr>
											<th>Produto</th>
											<th>Solicitante</th>
											<th>Data</th>
											<th>Quantidade</th>
										</tr>
									</thead>
									<tbody>
										@foreach($materiaisHistorico->where('tipo', 'e')->sortByDesc('created_at') as $key => $historico)
										<tr class="text-center">
											<td><small>{{$historico->RelationMaterial->nome}}</small></td>
											<td><small>{{$historico->RelationUsuario->RelationAssociado->nome}}</small></td>
											<td><small>{{$historico->created_at->format('d/m/Y H:i')}}</small></td>
											<td><span class="text-success">{{$historico->quantidade}}</span></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</section>
				<section id="section-iconbox-2">
					<div class="row col-12 white-box">
						<div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Total de documentos</h3>
							<hr class="mt-2">
							<div class="col-lg-12 col-sm-12 col-xs-12 text-center row m-auto align-items-center justify-content-center h-75 pb-5">
								<h1 style="font-size: 55px;">{{count($documentos)}} 
									<small>cadastrados</small>
								</h1>
							</div>
							
						</div>
						<div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Quantidade por status</h3>
							<hr class="mt-2">
							<div id="morris-donut-chart1" class="morris-donut-chart" style="height: 300px"></div>
						</div>
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-4">
							<h3 class="box-title mb-0">Adicionados recentes</h3>
							<hr class="mt-2">
							<div class="table-responsive">
								<table class="table color-table muted-table" id="table2">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Status</th>
											<th>Data de inclusão</th>
										</tr>
									</thead>
									<tbody>
										@foreach($documentos->sortByDesc('created_at') as $key => $dados)
										<tr class="text-center">
											<td class="txt-oflo">{{$dados->nome}}</td>
											<td>{{($dados->status == 1 ? "Ativo" : "Desativado")}}</td>
											<td class="txt-oflo">{{$dados->created_at->format('d/m/Y H:i')}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>      
					</div>
				</section>
				<section id="section-iconbox-3">
					<div class="row col-12 white-box">
						<div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title text-center mb-0">Total de bens</h3>
							<hr class="mt-2">
							<div class="col-lg-12 col-sm-12 col-xs-12 text-center row m-auto align-items-center justify-content-center h-75 pb-5">
								<h1 style="font-size: 55px;">{{count($bens)}} 
									<small>cadastrados</small>
								</h1>
							</div>
						</div>
						<div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Quantidade por tipo</h3>
							<hr class="mt-2">
							<div id="morris-donut-chart" class="morris-donut-chart" style="height: 300px"></div>

						</div>
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-4">
							<h3 class="box-title mb-0">Adicionados recentes</h3>
							<hr class="mt-2">
							<div class="table-responsive">
								<table class="table color-table muted-table" id="table1">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Tipo</th>
											<th>Localização</th>
											<th>Valor</th>
											<th>Data de inclusão</th>
										</tr>
									</thead>
									<tbody>
										@foreach($bens->sortByDesc('created_at') as $dados)
										<tr class="text-center">
											<td class="txt-oflo">{{$dados->nome}}</td>
											<td>{{($dados->tipo == 'veiculos' ? "Veículos" : ($dados->tipo == 'imovel' ? "Imóvel" : "Outros"))}}</td>
											<td class="txt-oflo">{{$dados->cidade}}</td>
											<td class="txt-oflo">R$ {{number_format($dados->valor, 2, ',', '.')}}</td>
											<td class="txt-oflo">{{date('d/m/Y H:i', strtotime($dados->created_at))}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-5">
							<h3 class="box-title mb-0">Bens por cidade</h3>
							<hr class="mt-2">
							<ul class="country-state">
								@foreach($bensCidade as $dados)
								<li>
									<h2>{{count($bens->whereNotNull('cidade')->where('cidade', $dados->cidade))}}</h2> <small>{{$dados->cidade}}</small>
									<div class="progress">
										<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{(100*count($bens->whereNotNull('cidade')->where('cidade', $dados->cidade)))/count($bens)}}%" aria-valuemin="0" aria-valuemax="100" style="width:{{(100*count($bens->whereNotNull('cidade')->where('cidade', $dados->cidade)))/count($bens)}}%"> <span class="sr-only">{{(100*count($bens->whereNotNull('cidade')->where('cidade', $dados->cidade)))/count($bens)}}% Complete</span></div>
									</div>
								</li>
								@endforeach
							</ul>
						</div>         
					</div>
				</section>
				
			</div>
			<!-- /content -->
		</div>
	</div>
	
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){

		 // Materiais
	    $('.sttabs').tabs({active: 0});
	    var materiais = {!! $materiaisCategoria !!};
	    var morrisData = [];
	    $.each(materiais, function(key, val){
	    	morrisData.push({'label': val.nome, 'value': val.quantidade}); 
	    });
	    var chart2 = Morris.Donut({
	    	element: 'morris-donut-chart2',
	    	data: morrisData,
	    	resize: true
	    });

	    // Documentos cadastrados
	    $('.sttabs').tabs({active: 1});
	    var chart2 = Morris.Donut({
	    	element: 'morris-donut-chart1',
	    	data: [{
	    		label: "Ativos",
	    		value: "{{ count($documentos->where('status', 1)) }}",
	    	}, {
	    		label: "Inativos",
	    		value: "{{ count($documentos->where('status', 0)) }}",
	    	}],
	    	resize: true,
	    	colors:['#99d683', '#ff0000']
	    });

	    // Bens cadastrados
		$('.sttabs').tabs({active: 2});
		var chart = Morris.Donut({
			element: 'morris-donut-chart',
			data: [{
				label: "Imóveis",
				value: "{{count($bens->where('tipo', 'imovel'))}}",
			}, {
				label: "Veículos",
				value: "{{count($bens->where('tipo', 'veiculos'))}}",
			}, {
				label: "Outros",
				value: "{{count($bens->where('tipo', 'outros'))}}",
			}],
			resize: true,
			colors:['#99d683', '#13dafe', '#6164c1']
		});
	   
	    $('#table1').DataTable({
	    	searching: false,
	    	pageLength: 5,
	    	ordering: false
	    });

	    $('#table2').DataTable({
	    	searching: false,
	    	pageLength: 5,
	    	ordering: false
	    });

	    $('#table3').DataTable({
	    	searching: false,
	    	pageLength: 5,
	    	ordering: false
	    });

	    $('#table4').DataTable({
	    	searching: false,
	    	pageLength: 5,
	    	ordering: false
	    });

	    $('.sttabs').tabs({active: 0});

	});
</script>
@endsection