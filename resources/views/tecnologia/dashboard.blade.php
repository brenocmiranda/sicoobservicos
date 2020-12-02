@section('title')
Tecnologia
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Dashboard</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">GTI</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div>
	</div>
	<div class="row mx-auto">
		<div class="sttabs tabs-style-iconbox" style="border-radius: 0.6em; border: transparent;">
			<nav>
				<ul style="background: transparent; border: transparent;">
					<li class="tab-current"><a href="#section-iconbox-1" class="sticon ti-headphone-alt"><span>Chamados</span></a></li>
					<li><a href="#section-iconbox-2" class="sticon ti-link"><span>Homepage</span></a></li>
					<li><a href="#section-iconbox-3" class="sticon ti-package"><span>Invetário</span></a></li>
				</ul>
			</nav>
			<div class="content-wrap">
				<section id="section-iconbox-1" class="content-current">
					<div class="white-box row mb-0">
	                    <div class="col-lg-3 col-sm-6 col-xs-12 px-2 pb-3 pb-lg-0">
	                    	<div class="p-3 border shadow-sm" style="background-color: #eeeeee40!important; border-radius: 5px">
							<div class="analytics-info p-2">
								<h3 class="box-title">Em aberto</h3>
								<ul class="list-inline two-part">
									<li>
										<i class="ti-help-alt text-danger"></i> 
									</li>
									<li class="text-right">
										<span class="counter text-danger">{{$chamadosEmaberto}}</span>
									</li>
								</ul>
							</div>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12 px-2 pb-3 pb-lg-0">
							<div class="p-3 border shadow-sm" style="background-color: #eeeeee40!important; border-radius: 5px">
							<div class="analytics-info p-2">
								<h3 class="box-title">Em andamento</h3>
								<ul class="list-inline two-part">
									<li>
										<i class="ti-hummer text-warning"></i> 
									</li>
									<li class="text-right">
										<span class="counter text-warning">{{$chamadosEmandamento}}</span>
									</li>
								</ul>
							</div>
						</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12 px-2 pb-3 pb-lg-0">
							<div class="p-3 border shadow-sm" style="background-color: #eeeeee40!important; border-radius: 5px">
							<div class="analytics-info p-2">
								<h3 class="box-title">Encerrado</h3>
								<ul class="list-inline two-part">
									<li>
										<i class="ti-check text-success"></i> 
									</li>
									<li class="text-right">
										<span class="counter text-success">{{$chamadosEncerrado}}</span>
									</li>
								</ul>
							</div>
						</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12 px-2 pb-3 pb-lg-0">
							<div class="p-3 border shadow-sm" style="background-color: #eeeeee40!important; border-radius: 5px">
							<div class="analytics-info p-2">
								<h3 class="box-title">Total de chamados</h3>
								<ul class="list-inline two-part">
									<li>
										<i class="ti-pie-chart text-info"></i>
									</li>
									<li class="text-right">
										<span class="text-info">{{count($chamados)}}</span>
									</li>
								</ul>
							</div>
						</div>
						</div>
		            </div>
		            <div class="white-box row mb-0">
		            	<div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Chamados por Fonte</h3>
							<hr class="mt-2">
							<div id="morris-donut-chart1" class="morris-donut-chart" style="height: 250px"></div>
						</div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Chamados por Tipo</h3>
							<hr class="mt-2">
							<div id="morris-donut-chart2" class="morris-donut-chart" style="height: 250px"></div>
						</div>
					</div>
					 <div class="white-box row mb-0">
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0">Chamados por dia</h3>
							<hr class="mt-2">
							<div id="morris-line-chart" class="morris-donut-chart" style="height: 250px"></div>
						</div> 
					</div>
					<div class="white-box row mb-0">
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-5">
							<h3 class="box-title mb-0">Chamados por usuário</h3>
							<hr class="mt-2">
							<div class="table-responsive">
								<table class="table color-table muted-table" id="table1">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Qtd. chamados</th>
											<th>Data do último</th>
										</tr>
									</thead>
									<tbody>
										@foreach($chamadosUsuarios as $dados)
										<tr class="text-center">
											<td class="txt-oflo">{{$dados->RelationUsuario->RelationAssociado->nome}}</td>
											<td>{{$dados->quantidade}}</td>
											<td>{{date('d/m/Y H:i', strtotime($chamados->where('usr_id_usuarios', $dados->usr_id_usuarios)->last()->created_at))}}</td>
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
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-left">Total de atalhos</h3>
							<hr class="mt-2">
							<div class="col-lg-12 col-sm-12 col-xs-12 text-center row m-auto align-items-center justify-content-center h-75 pb-5">
								<h1 style="font-size: 55px;">{{count($homepage)}} 
									<small>cadastrados</small>
								</h1>
							</div>
							
						</div>
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-4">
							<h3 class="box-title mb-0">Adicionados recentes</h3>
							<hr class="mt-2">
							<div class="table-responsive">
								<table class="table color-table muted-table" id="table2">
									<thead>
										<tr>
											<th>Título</th>
											<th>Subtítulo</th>
											<th>Data de inclusão</th>
										</tr>
									</thead>
									<tbody>
										@foreach($homepage->sortByDesc('created_at') as $dados)
										<tr class="text-center">
											<td class="txt-oflo">{{$dados->titulo}}</td>
											<td>{{(isset($dados->subtitulo) ? $dados->subtitulo : '-')}}</td>
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
					<div class="row col-12  white-box">
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<h3 class="box-title text-left mb-0">Total de equipamentos</h3>
							<hr class="mt-2">
							<div class="col-lg-12 col-sm-12 col-xs-12 text-center row m-auto align-items-center justify-content-center h-75 pb-5">
								<h1 style="font-size: 55px;">{{count($chamados)}} 
									<small>cadastrados</small>
								</h1>
							</div>
						</div>
					</div>
					<div class="white-box row mb-0">
		            	<div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Equipamentos por Setor</h3>
							<hr class="mt-2">
							<div id="morris-donut-chart3" class="morris-donut-chart" style="height: 250px"></div>
						</div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0 text-center">Equipamentos por Unidade</h3>
							<hr class="mt-2">
							<div id="morris-donut-chart4" class="morris-donut-chart" style="height: 250px"></div>
						</div>
					</div>
					<div class="white-box row mb-0">
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<h3 class="box-title mb-0">Equipamentos por marca</h3>
							<hr class="mt-2">
							<div id="morris-bar-chart" class="morris-donut-chart" style="height: 250px"></div>
						</div> 
					</div>
					<div class="white-box row mb-0">
						<div class="col-lg-12 col-sm-12 col-xs-12 mt-5">
							<h3 class="box-title mb-0">Equipamentos por usuário</h3>
							<hr class="mt-2">
							<div class="table-responsive">
								<table class="table color-table muted-table" id="table3">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Qtd. equipamentos</th>
										</tr>
									</thead>
									<tbody>
										@foreach($equipamentosUsuarios as $dados)
										<tr class="text-center">
											<td class="txt-oflo">{{$dados->RelationUsuarios->RelationAssociado->nome}}</td>
											<td>{{$dados->quantidade}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
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
		// Chamados por fonte
		$('.sttabs').tabs({active: 0});
		var chamadosFontes = {!! $chamadosFontes !!};
	    var morrisData = [];
	    $.each(chamadosFontes, function(key, val){
	    	morrisData.push({'label': val.nome, 'value': val.quantidade}); 
	    });
		var chart = Morris.Donut({
			element: 'morris-donut-chart1',
			data: morrisData,
			resize: true
		});
		// Chamados por tipo
		var chamadosTipos = {!! $chamadosTipos !!};
	    var morrisData = [];
	    $.each(chamadosTipos, function(key, val){
	    	morrisData.push({'label': val.nome, 'value': val.quantidade}); 
	    });
		var chart = Morris.Donut({
			element: 'morris-donut-chart2',
			data: morrisData,
			resize: true
		});
		// Chamados por dia
		var chamadosDia = {!! $chamadosDia !!};
	    var morrisData = [];
	    $.each(chamadosDia, function(key, val){
	    	morrisData.push({'data': val.data, 'quantidade': val.quantidade}); 
	    });
		Morris.Area({
          	element: 'morris-line-chart',
         	 data: morrisData,
          	xkey: 'data',
          	ykeys: ['quantidade'],
         	 labels: ['Quantidade'],
          	pointSize: 0,
	        fillOpacity: 0.4,
	        pointStrokeColors:['#b4becb', '#01c0c8'],
	        behaveLikeLine: true,
	        gridLineColor: '#e0e0e0',
	        lineWidth: 0,
	        smooth: false,
	        hideHover: 'auto',
	        lineColors: ['#b4becb', '#01c0c8'],
	        resize: true
        });

		// Chamados por usuário
		$('#table1').DataTable({
	    	searching: false,
	    	pageLength: 5,
	    	ordering: false
	    });

		// Homepage
	    $('#table2').DataTable({
	    	searching: false,
	    	pageLength: 5,
	    	ordering: false
	    });

	    // Equipamentos por setor
		$('.sttabs').tabs({active: 2});
		var chamadosFontes = {!! $equipamentosSetor !!};
	    var morrisData = [];
	    $.each(chamadosFontes, function(key, val){
	    	morrisData.push({'label': val.nome, 'value': val.quantidade}); 
	    });
		var chart = Morris.Donut({
			element: 'morris-donut-chart3',
			data: morrisData,
			resize: true
		});
		// Equipamentos por PA
		var chamadosTipos = {!! $equipamentosPA !!};
	    var morrisData = [];
	    $.each(chamadosTipos, function(key, val){
	    	morrisData.push({'label': val.nome, 'value': val.quantidade}); 
	    });
		var chart = Morris.Donut({
			element: 'morris-donut-chart4',
			data: morrisData,
			resize: true
		});
		// Equipamentos por marca
		var equipamentosMarca = {!! $equipamentosMarca !!};
	    var morrisData = [];
	    $.each(equipamentosMarca, function(key, val){
	    	morrisData.push({'marca': val.marca, 'quantidade': val.quantidade}); 
	    });
    	Morris.Bar({
	        element: 'morris-bar-chart',
	        data: morrisData,
	        xkey: 'marca',
	        ykeys: ['quantidade'],
	        labels: ['Quantidade'],
	        barColors:['#b8edf0', '#b4c1d7', '#fcc9ba'],
	        hideHover: 'auto',
	        gridLineColor: '#eef0f2',
	        resize: true
	    });
		// Equipamentos por usuário
		 $('#table3').DataTable({
	    	searching: false,
	    	pageLength: 5,
	    	ordering: false
	    });

		$('.sttabs').tabs({active: 0});
	});
</script>
@endsection