@section('title')
Análise dos associados
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Análise dos associados</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Negócios</a></li>
				<li class="active">Análise de associado</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 mb-3">
				<table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table" style="overflow-y: auto; display: none !important;">
					<thead>
						<th> Nome </th>
						<th> Documento </th>
						<th> Renda </th>
						<th> Gerente </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
			<div class="my-3 col-12 text-center processing-in">
				<div class="spinner-border text-primary mb-3" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
				<h6>Carregando as informações...</h6>
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		/* Criando a datatables
		$('#table').DataTable({
			deferRender: true,
			order: [0, 'asc'],
			paginate: true,
			select: true,
			searching: true,
			destroy: true,
			ajax: "{{ route('listar.analise.negocios') }}",
			serverSide: true,
			"columns": [ 
			{ "data": "nome", "name":"nome"},
			{ "data": "documento", "name":"documento"},
			{ "data": "renda1", "name":"renda1"},
			{ "data": "nome_gerente", "name":"nome_gerente"},
			{ "data": "acoes","name":"acoes"},
			],
		});*/

		// Criando a datatables
		$.ajax({
			url: '{{ route("listar.analise.negocios") }}',
			type: 'GET',
			success: function(table){
				// Carregamento de dados
				$('.processing-in').addClass('d-none');
				$('.processing-off').fadeIn();
				$('#table').fadeIn();
				$('#table').DataTable({
					order: [ 0, "asc" ],
					pageLength: 100,
					paging: true,
					select: true,
					searching: true,
					deferRender: true,
					data: table,
					"columns": [ 
					{ "data": "nome", "name":"nome"},
					{ "data": "documento1", "name":"documento1"},
					{ "data": "renda1", "name":"renda1"},
					{ "data": "nome_gerente", "name":"nome_gerente"},
					{ "data": "acoes","name":"acoes"},
					]
				});	
			}
		});
	});
</script>
@endsection