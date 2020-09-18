@section('title')
Garantias
@endsection

@section('caminho')
<small class="section-header-breadcrumb d-flex">
	<div class="breadcrumb-item">
		<a href="javascript:void(0)" class="p-0 d-block">Crédito</a>
	</div>
	<div class="breadcrumb-item d-flex active p-0">
		<a href="{{ route('exibir.garantias.credito') }}" class="p-0 d-block text-primary">Garantias</a>
	</div>
</small>
@endsection

@extends('layouts.structure')

@section('content')
<div class="content-wrapper">
	<div class="card">
		<div class="card-body">
			<div class="h-100 d-flex">
				<div class="col-lg-12 d-flex">
					<div>
						<h3>Garantias</h3>
						<h6>Estão listados a abaixo todas as funções cadastradas.</h6>
					</div>
					<div class="ml-auto">
						<button class="btn btn-outline-success px-2 d-flex align-items-center" id="adicionar" name="adicionar" title="Adicionar nova função" data-toggle="modal" data-target="#modal-adicionar"><i class="m-0 pr-1 mdi mdi-plus"></i> Nova garantias </button>
					</div>
				</div>
			</div>
			<hr>
			<div class="mb-3 mx-3">
				<table class="table table-striped text-center" id="table">
					<thead>
						<th> Nº contrato </th>
						<th> Associado </th>
						<th> Produto </th>
						<th> Tipo </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		$('#modal-processamento').modal('show');
		$('#modal-processamento').removeClass('fade');
		$('input').keypress( function(e) {
			var code = null;
			code = (e.keyCode ? e.keyCode : e.which);                
			return (code == 13) ? false : true;
		});

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
			$('#modal-editar #formAdicionar').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('#modal-editar #err').html('');
		});

		// Criando a datatables
		$.ajax({
			url: '{{ route("listar.garantias.credito") }}',
			type: 'GET',
			success: function(table){
				$('#table').DataTable({
					order: [ 1, "asc" ],
					paging: true,
					select: true,
					searching: true,
					data: table,
					"columns": [ 
					{ "data": "num_contrato","name":"num_contrato"},
					{ "data": "nome", "name":"nome"},
					{ "data": "produto1.nome","name":"produto1.nome"},
					{ "data": "tipo","name":"tipo"},
					{ "data": "acoes","name":"acoes"},
					],
					"initComplete": processamento(),
				});

				$('#table tbody').on('click', 'tr', function (){
					var table = $('#table').DataTable();
					if (!($(this).hasClass('selected'))) {
						table.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
				});

				// Editar informações
				$('#table tbody').on('click', 'button#editar', function () {
					$('#modal-editar #formEditar').each (function(){
						this.reset();
					});
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					$('.modal .nome').val(data.nome);
					if(data.status.replace('</label>', '').split('>', 2)[1] == "Ativo"){
						$('.modal .status').bootstrapToggle('on');
					}else{
						$('.modal .status').bootstrapToggle('off');
					}					
					$('#modal-editar').modal('show');	
				});

				// Alterar status
				$('#table tbody').on('click', 'button#alterar', function () {
					$('#modal-alterar #formAlterar').each (function(){
						this.reset();
					});
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					$('.modal .nome').html(data.nome);
					if(data.status.replace('</label>', '').split('>', 2)[1] == "Ativo"){
						$('.modal .status').bootstrapToggle('off');
					}else{
						$('.modal .status').bootstrapToggle('on');
					}	
					$('#modal-alterar').modal('show');	
				});

				// Detalhes das informações
				$('#table tbody').on('dblclick','tr', function (){
					var table = $('#table').DataTable();
					var data = table.row(this).data();
					$(this).addClass('selected');
					$('#editar').attr('data-toggle', 'modal');
					$('#editar').attr('data-target', '#modal-editar');
					$('#alterar').attr('data-toggle', 'modal');
					$('#alterar').attr('data-target', '#modal-alterar');
					$('.modal .nome').val(data.nome);
					if(data.status.replace('</label>', '').split('>', 2)[1] == "Ativo"){
						$('#modal-detalhes .status').removeAttr('disabled');
						$('.modal .status').bootstrapToggle('on');
						$('#modal-detalhes .status').attr('disabled', 'disabled');
					}else{
						$('#modal-detalhes .status').removeAttr('disabled');
						$('.modal .status').bootstrapToggle('off');
						$('#modal-detalhes .status').attr('disabled', 'disabled');
					}	
					$('#modal-detalhes').modal('show');
				});
			}
		});

	// Adicionando novos itens
	$('#modal-adicionar #formAdicionar').on('submit', function(e){
		var table = $('#table').DataTable();
		var data = table.row('tr.selected').data();
		e.preventDefault();
		$.ajax({
			url: '{{ route("adicionar.funcoes") }}',
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
			var data = table.row('tr.selected').data();
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
						table.row('tr.selected').remove().draw(false);
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
			var data = table.row('tr.selected').data();
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
						table.row('tr.selected').remove().draw(false);
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

@endsection