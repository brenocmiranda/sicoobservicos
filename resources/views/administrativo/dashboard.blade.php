@section('title')
Dashboard
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
	<div class="row">
		<div class="col-lg-4 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<h3 class="box-title">Solicitações em aberto</h3>
				<ul class="list-inline two-part">
					<li>
						<i class="ti-alert text-warning"></i> 
					</li>
					<li class="text-right"><span class="counter text-warning">{{count($materiaisHistorico->where('status', 0)->where('tipo', 's'))}}</span></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-4 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<h3 class="box-title">Solicitações em aprovadas</h3>
				<ul class="list-inline two-part">
					<li>
						<i class="ti-check text-success"></i> 
					</li>
					<li class="text-right"><span class="counter text-success">{{count($materiaisHistorico->where('status', 1)->where('tipo', 's'))}}</span></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-4 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<h3 class="box-title">Total de solictações</h3>
				<ul class="list-inline two-part">
					<li>
						<i class="ti-package text-info"></i> 
					</li>
					<li class="text-right"><span class="counter text-info">{{count($materiaisHistorico->where('tipo', 's'))}}</span></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row mx-auto">
		<div class="col-lg-12 col-sm-12 col-xs-12 white-box">
			<h3 class="box-title">Solicitações por data</h3>
			<ul class="list-inline text-right">
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #fb4;"></i>Abertas</h5> 
				</li>
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #28a745;"></i>Atendidas</h5> 
				</li>
			</ul>
			<div id="morris-area-materiais"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="white-box">
				<div class="col-md-3 col-sm-4 col-xs-6 pull-right">
					<select class="form-control pull-right row b-none">
						<option>March 2017</option>
						<option>April 2017</option>
						<option>May 2017</option>
						<option>June 2017</option>
						<option>July 2017</option>
					</select>
				</div>
				<h3 class="box-title">Histórico de saídas</h3>
				<div class="row sales-report">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<h2>March 2017</h2>
						<p>Total de solicitações</p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 ">
						<h1 class="text-right text-info m-t-20">{{count($materiaisHistorico->where('tipo', 's'))}}</h1> 
					</div>
				</div>
				<div class="table-responsive">
					<table class="table">
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
								<td class="txt-oflo">{{$historico->RelationMaterial->nome}}</td>
								<td>{{$historico->RelationUsuario->RelationAssociado->nome}}</td>
								<td class="txt-oflo">{{$historico->created_at->format('d/m/Y H:i')}}</td>
								<td><span class="text-success">{{$historico->quantidade}}</span></td>
								<td><span class="label {{($historico->status == 0 ? 'label-warning' : 'label-success')}} label-rouded">{{($historico->status == 0 ? "Pendente" : "Aprovada")}}</span> </td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="white-box">
				<div class="col-md-3 col-sm-4 col-xs-6 pull-right">
					<select class="form-control pull-right row b-none">
						<option>March 2017</option>
						<option>April 2017</option>
						<option>May 2017</option>
						<option>June 2017</option>
						<option>July 2017</option>
					</select>
				</div>
				<h3 class="box-title">Histórico de entradas</h3>
				<div class="row sales-report">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<h2>March 2017</h2>
						<p>Total de reposições</p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 ">
						<h1 class="text-right text-info m-t-20">{{count($materiaisHistorico->where('tipo', 'e'))}}</h1> 
					</div>
				</div>
				<div class="table-responsive">
					<table class="table">
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
								<td class="txt-oflo">{{$historico->RelationMaterial->nome}}</td>
								<td>{{$historico->RelationUsuario->RelationAssociado->nome}}</td>
								<td class="txt-oflo">{{$historico->created_at->format('d/m/Y H:i')}}</td>
								<td><span class="text-success">{{$historico->quantidade}}</span></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		var materiais = {!! $materiaisHistorico->where('tipo', 's') !!};
		console.log(materiais);

		var morrisData = [];
		$.each(materiais, function(key, val){
			morrisData.push({'period': new Date(val.created_at).toLocaleDateString('pt-BR'), 'SiteA' : val.id}); 
		});
		console.log(morrisData);

		Morris.Area({
			element: 'morris-area-materiais',
			data: morrisData,
			xkey: 'period',
			ykeys: ['SiteA'],
			labels: ['Site A'],
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
	});
</script>
@endsection