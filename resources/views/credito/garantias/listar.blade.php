@section('title')
Garantias
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Garantias</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.credito')}}">Crédito</a></li>
				<li><a class="active">Garantias</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="h-100 row col">
				<div class="col-lg-12 position-absolute">
					<div class="row mx-auto">
						<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar garantia" data-toggle="modal" data-target="#modal-adicionar" style="z-index: 10">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Adicionar garantia</span> 
						</button>
					</div>
				</div>
			</div>
			<div class="mb-3 mx-3">
				<table class="table text-center color-table muted-table rounded" id="table">
					<thead>
						<th> Nº contrato </th>
						<th> Associado </th>
						<th> Produto </th>
						<th> Tipo </th>
						<th> Localização </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Limpando as informações para adicionar
		$('#adicionar').on('click', function(){
			$('#modal-adicionar #formAdicionar').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('#modal-adicionar #err').html('');
		});
		
		// Limpando as informações de editar
		$('#editar').on('click', function(){
			$('#modal-editar #formEditar').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('#modal-editar #err').html('');
		});

		// Criando a datatables
		$('#table').DataTable({
			order: [ 1, "asc" ],
			paging: true,
			select: true,
			searching: true,
			ajax: '{{ route("listar.garantias.credito") }}',
			data: table,
			"columns": [ 
			{ "data": "num_contrato","name":"num_contrato"},
			{ "data": "nome1", "name":"nome1"},
			{ "data": "produto1","name":"produto1"},
			{ "data": "tipo","name":"tipo"},
			{ "data": "armario1","name":"armario1"},
			{ "data": "acoes","name":"acoes"},
			]
		});

		$('#table tbody').on('click', 'tr', function (){
			var table = $('#table').DataTable();
			if (!($(this).hasClass('active'))) {
				table.$('tr.active').removeClass('active');
				$(this).addClass('active');
			}
		});

		// Editar informações
		$('#table tbody').on('click', 'button#editar', function () {
			$('#modal-editar #formEditar').each (function(){
				this.reset();
			});
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			$('.modal .nome').val(data.nome);		
			$('#modal-editar').modal('show');	
		});

		// Alterar status
		$('#table tbody').on('click', 'button#alterar', function () {
			$('#modal-alterar #formAlterar').each (function(){
				this.reset();
			});
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			$('.modal .nome').html(data.nome);
			$('#modal-alterar').modal('show');	
		});

		// Detalhes das informações
		$('#table tbody').on('dblclick','tr', function (){
			var table = $('#table').DataTable();
			var data = table.row(this).data();
			$(this).addClass('active');
			$('#editar').attr('data-toggle', 'modal');
			$('#editar').attr('data-target', '#modal-editar');
			$('#alterar').attr('data-toggle', 'modal');
			$('#alterar').attr('data-target', '#modal-alterar');
			$('.modal .nome').val(data.nome);
			$('#modal-detalhes').modal('show');
		});

	// Adicionando novos itens
	$('#modal-adicionar #formAdicionar').on('submit', function(e){
		var table = $('#table').DataTable();
		var data = table.row('tr.active').data();
		e.preventDefault();
		$.ajax({
			url: '{{ route("adicionar.garantias.credito") }}',
			type: 'POST',
			data: $('#modal-adicionar #formAdicionar').serialize(),
			beforeSend: function(){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
				$('#modal-adicionar #err').html('');
			},
			success: function(data){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check-all" style="font-size:62px;"></i></div><p>Função adicionada com sucesso!</p></div>');
				setTimeout(function(){
					$('#modal-adicionar #formAdicionar').each (function(){
						this.reset();
					});
					table.row.add(data).draw(false);
					$('input').removeClass('border-bottom border-danger');
					$('.carregamento').html('');
					$('.modal-body, .modal-footer').removeClass('d-none');
					$('#modal-adicionar').modal('hide');
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
							$('#modal-adicionar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
							$('input[name="'+key+'"]').addClass('border-bottom border-danger');
						});
					}
				}, 2000);
			}
		});
	});

	// Editando as informações
	$('#modal-editar #formEditar').on('submit', function(e){
		var table = $('#table').DataTable();
		var data = table.row('tr.active').data();
		console.log(data);
		e.preventDefault();
		$.ajax({
			url: 'funcoes/editar/'+data.id_funcao,
			type: 'POST',
			data: $('#modal-editar #formEditar').serialize(),
			beforeSend: function(){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
				$('#modal-editar #err').html('');
			},
			success: function(data){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check-all" style="font-size:62px;"></i></div><p>Informações alteradas com sucesso!</p></div>');
				setTimeout(function(){
					$('#modal-editar #formEditar').each (function(){
						this.reset();
					});
					table.row('tr.active').remove().draw(false);
					table.row.add(data).draw(false);
					$('input').removeClass('border-bottom border-danger');
					$('.carregamento').html('');
					$('.modal-body, .modal-footer').removeClass('d-none');
					$('#modal-editar').modal('hide');
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
							$('#modal-editar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
							$('input[name="'+key+'"]').addClass('border-bottom border-danger');
						});
					}
				}, 2000);
			}
		});
	});

	// Alterando os status
	$('#modal-alterar #formAlterar').on('submit', function(e){
		var table = $('#table').DataTable();
		var data = table.row('tr.active').data();
		e.preventDefault();
		$.ajax({
			url: 'funcoes/alterar/'+data.id_funcao,
			type: 'POST',
			data: $('#modal-alterar #formAlterar').serialize(),
			beforeSend: function(){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
				$('#modal-alterar #err').html('');
			},
			success: function(data){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check-all" style="font-size:62px;"></i></div><p>Status alterado com sucesso!</p></div>');
				setTimeout(function(){
					$('#modal-alterar #formAlterar').each (function(){
						this.reset();
					});
					table.row('tr.active').remove().draw(false);
					table.row.add(data).draw(false);
					$('input').removeClass('border-bottom border-danger');
					$('.carregamento').html('');
					$('.modal-body, .modal-footer').removeClass('d-none');
					$('#modal-alterar').modal('hide');
				}, 2000);
			}, error: function (data) {
				setTimeout(function(){
					$('.modal-body, .modal-footer').removeClass('d-none');
					$('.carregamento').html('');
					if(!data.responseJSON){
						console.log(data.responseText);
						$('#modal-alterar #err').html(data.responseText);
					}else{
						$('#modal-alterar #err').html('');
						$('input').removeClass('border-bottom border-danger');
						$.each(data.responseJSON.errors, function(key, value){
							$('#modal-alterar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
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
