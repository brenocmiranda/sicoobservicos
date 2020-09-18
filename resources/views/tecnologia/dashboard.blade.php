@section('title')
GTI
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
		<div class="col-lg-3 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<h3 class="box-title">Chamados em aberto</h3>
				<ul class="list-inline two-part">
					<li>
						<i class="ti-headphone-alt text-success"></i> 
					</li>
					<li class="text-right"><span class="counter text-success">{{count($ativos)}}</span></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<h3 class="box-title">Total de chamados</h3>
				<ul class="list-inline two-part">
					<li>
						<i class="ti-microphone text-success"></i> 
					</li>
					<li class="text-right"><span class="counter text-purple">{{count($ativos)}}</span></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<h3 class="box-title">Total de ativos</h3>
				<ul class="list-inline two-part">
					<li>
						<i class="ti-package text-info"></i> 
					</li>
					<li class="text-right"><span class="counter text-info">{{count($ativos)}}</span></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<h3 class="box-title">Total de atalhos</h3>
				<ul class="list-inline two-part">
					<li>
						<i class="ti-link text-danger"></i>
					</li>
					<li class="text-right"><span class="text-danger">{{count($homepage)}}</span></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-12 row">
		<div class="col-lg-8 w-100 white-box">
            <h3 class="box-title">Quantidade chamados por estado</h3>
            <ul class="list-inline text-right">
                <li>
                    <h5><i class="fa fa-circle m-r-5" style="color: #28a745;"></i>Abertos</h5> 
                </li>
                <li>
                    <h5><i class="fa fa-circle m-r-5" style="color: #fb4;"></i>Em andamento</h5> 
                </li>
                <li>
                    <h5><i class="fa fa-circle m-r-5" style="color: #e82d2d;"></i>Finalizados</h5> 
                </li>
            </ul>
            <div id="morris-area-chamados"></div>
       	</div>
       	<div class="col-4">
	       	<div class="col-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Abertos</h3>
					<ul class="list-inline two-part">
						<li>
							<i class="ti-link text-success"></i>
						</li>
						<li class="text-right"><span class="text-success">{{count($homepage)}}</span></li>
					</ul>
				</div>
			</div>
			<div class="col-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Em andamento</h3>
					<ul class="list-inline two-part">
						<li>
							<i class="ti-link text-warning"></i>
						</li>
						<li class="text-right"><span class="text-warning">{{count($homepage)}}</span></li>
					</ul>
				</div>
			</div>
			<div class="col-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Finalizados</h3>
					<ul class="list-inline two-part">
						<li>
							<i class="ti-link text-danger"></i>
						</li>
						<li class="text-right"><span class="text-danger">{{count($homepage)}}</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		var chamados = {!! $chamados !!};
		console.log(chamados);

		var morrisData = [];
		$.each(chamados, function(key, val){
		    morrisData.push({'period': new Date(val.created_at).toLocaleDateString('pt-BR'), 'SiteA' : val.id}); 
		});
		console.log(morrisData);

		Morris.Area({
	        element: 'morris-area-chamados',
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