@section('title')
Funções
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Funções</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li><a href="javascript:void(0)">Administrativo</a></li>
				<li class="active">Funções</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="h-100 row col">
				<div class="col-lg-12 position-absolute">
					<div class="row mx-auto">
						<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar nova função" data-toggle="modal" data-target="#modal-adicionar" style="z-index: 10">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Nova função</span> 
						</button>
					</div>
				</div>
			</div>
			<div class="col-12 mb-3 mx-3">
				<table class="table table-striped text-center color-table muted-table rounded" id="table">
					<thead>
						<th> ID# </th>
						<th> Nome </th>
						<th> Status </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('configuracoes.administrativo.funcoes.adicionar')
	@include('configuracoes.administrativo.funcoes.editar')
	@include('configuracoes.administrativo.funcoes.detalhes')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Limpando as informações para adicionar
		$('#adicionar').on('click', function(){
			$('#modal-adicionar form').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('#modal-adicionar #err').html('');
		});

		// Criando a datatables
		$('#table').DataTable({
			deferRender: true,
			order: [1, 'asc'],
			paginate: true,
			select: true,
			searching: true,
			destroy: true,
			ajax: "{{ route('listar.funcoes.administrativo') }}",
			serverSide: true,
			"columns": [ 
			{ "data": "id","name":"id"},
			{ "data": "nome1", "name":"nome1"},
			{ "data": "status1", "name":"status1"},
			{ "data": "acoes","name":"acoes"},
			],
		});

		// -------------------------------------------------
		// Retornando informações 
		// -------------------------------------------------

		$('#table tbody').on('click', 'button#editar', function () {
			// Modal editar
			$('#modal-editar form').each (function(){
				this.reset();
			});
			$('#modal-editar #err').html('');
			var table = $('#table').DataTable();
			table.$('tr.selected').removeClass('selected');
			$(this).parents('tr').addClass('selected');
			$(this).parent('tr').addClass('selected');
			var data = table.row('tr.selected').data();
			$('.modal .nome').val(data.nome);
			if(data.ver_credito){
				$('.modal #checkbox11').attr('checked', 'checked');
			}else{
				$('.modal #checkbox11').removeAttr('checked');
			}
			if(data.gerenciar_credito){
				$('.modal #checkbox12').attr('checked', 'checked');
			}else{
				$('.modal #checkbox12').removeAttr('checked');
			}
			if(data.ver_suporte){
				$('.modal #checkbox13').attr('checked', 'checked');
			}else{
				$('.modal #checkbox13').removeAttr('checked');
			}
			if(data.gerenciar_suporte){
				$('.modal #checkbox14').attr('checked', 'checked');
			}else{
				$('.modal #checkbox14').removeAttr('checked');
			}
			if(data.ver_gti){
				$('.modal #checkbox15').attr('checked', 'checked');
			}else{
				$('.modal #checkbox15').removeAttr('checked');
			}
			if(data.gerenciar_gti){
				$('.modal #checkbox16').attr('checked', 'checked');
			}else{
				$('.modal #checkbox16').removeAttr('checked');
			}
			if(data.ver_configuracoes){
				$('.modal #checkbox17').attr('checked', 'checked');
			}else{
				$('.modal #checkbox17').removeAttr('checked');
			}
			if(data.gerenciar_configuracoes){
				$('.modal #checkbox18').attr('checked', 'checked');
			}else{
				$('.modal #checkbox18').removeAttr('checked');
			}
			if(data.ver_administrativo){
				$('.modal #checkbox19').attr('checked', 'checked');
			}else{
				$('.modal #checkbox19').removeAttr('checked');
			}
			if(data.gerenciar_administrativo){
				$('.modal #checkbox20').attr('checked', 'checked');
			}else{
				$('.modal #checkbox20').removeAttr('checked');
			}
			if(data.status == 1){
				$(".modal .status").prop('checked', false).trigger("click");
			}else{
				$(".modal .status").prop('checked', true).trigger("click");
			}			
			$('#modal-editar').modal('show');	
		});
		$('#table tbody').on('click', 'a#detalhes', function (){
			// Modal de detalhes
			var table = $('#table').DataTable();
			table.$('tr.selected').removeClass('selected');
			$(this).parents('tr').addClass('selected');
			$(this).parent('tr').addClass('selected');
			var data = table.row('tr.selected').data();
			$('.modal .nome').val(data.nome);
			if(data.ver_credito){
				$('.modal #checkbox21').attr('checked', 'checked');
			}else{
				$('.modal #checkbox21').removeAttr('checked');
			}
			if(data.gerenciar_credito){
				$('.modal #checkbox22').attr('checked', 'checked');
			}else{
				$('.modal #checkbox22').removeAttr('checked');
			}
			if(data.ver_suporte){
				$('.modal #checkbox23').attr('checked', 'checked');
			}else{
				$('.modal #checkbox23').removeAttr('checked');
			}
			if(data.gerenciar_suporte){
				$('.modal #checkbox24').attr('checked', 'checked');
			}else{
				$('.modal #checkbox24').removeAttr('checked');
			}
			if(data.ver_gti){
				$('.modal #checkbox25').attr('checked', 'checked');
			}else{
				$('.modal #checkbox25').removeAttr('checked');
			}
			if(data.gerenciar_gti){
				$('.modal #checkbox26').attr('checked', 'checked');
			}else{
				$('.modal #checkbox26').removeAttr('checked');
			}
			if(data.ver_configuracoes){
				$('.modal #checkbox27').attr('checked', 'checked');
			}else{
				$('.modal #checkbox27').removeAttr('checked');
			}
			if(data.gerenciar_configuracoes){
				$('.modal #checkbox28').attr('checked', 'checked');
			}else{
				$('.modal #checkbox28').removeAttr('checked');
			}
			if(data.ver_administrativo){
				$('.modal #checkbox29').attr('checked', 'checked');
			}else{
				$('.modal #checkbox29').removeAttr('checked');
			}
			if(data.gerenciar_administrativo){
				$('.modal #checkbox30').attr('checked', 'checked');
			}else{
				$('.modal #checkbox30').removeAttr('checked');
			}
			if(data.status){
				$('#modal-detalhes .status').removeAttr('disabled');
				$(".modal .status").prop('checked', false).trigger("click");
				$('#modal-detalhes .status').attr('disabled', 'disabled');
			}else{
				$('#modal-detalhes .status').removeAttr('disabled');
				$(".modal .status").prop('checked', true).trigger("click");
				$('#modal-detalhes .status').attr('disabled', 'disabled');
			}	
			$('#modal-detalhes').modal('show');
		});

		// -------------------------------------------------
		// Requisições
		// -------------------------------------------------

		$('#table tbody').on('click', 'button#alterar', function () {
			// Alterando o estado
			var table = $('#table').DataTable();
			table.$('tr.selected').removeClass('selected');
			$(this).parents('tr').addClass('selected');
			$(this).parent('tr').addClass('selected');
			var data = table.row('tr.selected').data();
			var url = "{{url('app/gestao/administrativo/funcoes/alterar')}}/"+data.id;
			swal({
				title: "Tem certeza que deseja alterar o estado?",
				icon: "warning",
				buttons: ["Cancelar", "Alterar"],
			})
			.then((willDelete) => {
				if (willDelete) {
					$.get(url, function(data){
						if(data.success == true){
							swal("Informações alteradas com sucesso!", {
								icon: "success",
							});
							table.ajax.reload();
						}else{
							swal("Não foi possível alterar essas informações, tente novamente!", {
								icon: "error",
							});
						}
					});
				} else {
					swal.close();
				}
			});
		});
		$('#modal-adicionar #formAdicionar').on('submit', function(e){
			// Adicionando novos itens
			var table = $('#table').DataTable();
			var data = table.row('tr.selected').data();
			e.preventDefault();
			$.ajax({
				url: '{{ route("adicionar.funcoes.administrativo") }}',
				type: 'POST',
				data: $('#modal-adicionar #formAdicionar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-adicionar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						$('#modal-adicionar #formAdicionar').each (function(){
							this.reset();
						});
						table.ajax.reload();
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
								$('#modal-adicionar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
								$('input[name="'+key+'"]').addClass('border-bottom border-danger');
							});
						}
					}, 2000);
				}
			});
		});
		$('#modal-editar #formEditar').on('submit', function(e){
			// Editando as informações
			var table = $('#table').DataTable();
			var data = table.row('tr.selected').data();
			e.preventDefault();
			$.ajax({
				url: 'funcoes/editar/'+data.id,
				type: 'POST',
				data: $('#modal-editar #formEditar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-editar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						$('#modal-editar #formEditar').each (function(){
							this.reset();
						});
						table.ajax.reload();
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
								$('#modal-editar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
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