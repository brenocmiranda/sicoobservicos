@section('title')
Associados
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Associados</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Negócios</a></li>
				<li class="active">Associados</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 mb-3">
				<table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table" style="overflow-y: auto; display: none !important;">
					<thead>
						<th> Possui? </th>
						<th> Nome </th>
						<th> Documento </th>
						<th> Gerente </th>
						<th> PA </th>
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
					order: [ 1, "asc" ],
					pageLength: 100,
					paging: true,
					select: true,
					searching: true,
					deferRender: true,
					data: table,
					"columns": [ 
					{ "data": "analise", "name":"analise"},
					{ "data": "nome", "name":"nome"},
					{ "data": "documento1", "name":"documento1"},
					{ "data": "nome_gerente", "name":"nome_gerente"},
					{ "data": "PA", "name":"PA"},
					{ "data": "acoes","name":"acoes"},
					]
				});	
			}
		});
	});
</script>
@endsection