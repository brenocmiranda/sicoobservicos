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
					@if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1)
					<div class="row mx-auto">
						<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar nova função" data-toggle="modal" data-target="#modal-adicionar" style="z-index: 10">
							<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
							<span class="hidden-xs">Cadastrar</span> 
						</button>
					</div>
					@endif
				</div>
			</div>
			<div class="col-12 mb-3">
				<table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table" style="overflow-y: auto;">
					<thead>
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
			order: [0, 'asc'],
			paginate: true,
			select: true,
			searching: true,
			destroy: true,
			ajax: "{{ route('listar.funcoes.administrativo') }}",
			serverSide: true,
			"columns": [ 
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
			// Crédito
			if(data.ver_credito){
				$('.modal #checkbox30').attr('checked', 'checked');
			}else{
				$('.modal #checkbox30').removeAttr('checked');
			}
			if(data.gerenciar_credito){
				$('.modal #checkbox31').attr('checked', 'checked');
			}else{
				$('.modal #checkbox31').removeAttr('checked');
			}
			// Técnologia
			if(data.ver_gti){
				$('.modal #checkbox32').attr('checked', 'checked');
			}else{
				$('.modal #checkbox32').removeAttr('checked');
			}
			if(data.gerenciar_gti){
				$('.modal #checkbox33').attr('checked', 'checked');
			}else{
				$('.modal #checkbox33').removeAttr('checked');
			}
			// Configurações
			if(data.ver_configuracoes){
				$('.modal #checkbox34').attr('checked', 'checked');
			}else{
				$('.modal #checkbox34').removeAttr('checked');
			}
			if(data.gerenciar_configuracoes){
				$('.modal #checkbox35').attr('checked', 'checked');
			}else{
				$('.modal #checkbox35').removeAttr('checked');
			}
			// Administrativo
			if(data.ver_administrativo){
				$('.modal #checkbox36').attr('checked', 'checked');
			}else{
				$('.modal #checkbox36').removeAttr('checked');
			}
			if(data.gerenciar_administrativo){
				$('.modal #checkbox37').attr('checked', 'checked');
			}else{
				$('.modal #checkbox37').removeAttr('checked');
			}
			// Cadastro
			if(data.ver_cadastro){
				$('.modal #checkbox38').attr('checked', 'checked');
			}else{
				$('.modal #checkbox38').removeAttr('checked');
			}
			if(data.gerenciar_cadastro){
				$('.modal #checkbox39').attr('checked', 'checked');
			}else{
				$('.modal #checkbox39').removeAttr('checked');
			}
			// Produtos
			if(data.ver_produtos){
				$('.modal #checkbox40').attr('checked', 'checked');
			}else{
				$('.modal #checkbox40').removeAttr('checked');
			}
			if(data.gerenciar_produtos){
				$('.modal #checkbox41').attr('checked', 'checked');
			}else{
				$('.modal #checkbox41').removeAttr('checked');
			}
			// Atendimento
			if(data.ver_atendimento){
				$('.modal #checkbox42').attr('checked', 'checked');
			}else{
				$('.modal #checkbox42').removeAttr('checked');
			}
			if(data.gerenciar_atendimento){
				$('.modal #checkbox43').attr('checked', 'checked');
			}else{
				$('.modal #checkbox43').removeAttr('checked');
			}
			// Negócios
			if(data.ver_negocios){
				$('.modal #checkbox44').attr('checked', 'checked');
			}else{
				$('.modal #checkbox44').removeAttr('checked');
			}
			if(data.gerenciar_negocios){
				$('.modal #checkbox45').attr('checked', 'checked');
			}else{
				$('.modal #checkbox45').removeAttr('checked');
			}
			// Suporte
			if(data.ver_suporte){
				$('.modal #checkbox46').attr('checked', 'checked');
			}else{
				$('.modal #checkbox46').removeAttr('checked');
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
			// Crédito
			if(data.ver_credito){
				$('.modal #checkbox60').attr('checked', 'checked');
				$('.modal #checkbox60').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox60').removeAttr('checked');
				$('.modal #checkbox60').attr('disabled', 'disabled');
			}
			if(data.gerenciar_credito){
				$('.modal #checkbox61').attr('checked', 'checked');
				$('.modal #checkbox61').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox61').removeAttr('checked');
				$('.modal #checkbox61').attr('disabled', 'disabled');
			}
			// Técnologia
			if(data.ver_gti){
				$('.modal #checkbox62').attr('checked', 'checked');
				$('.modal #checkbox62').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox62').removeAttr('checked');
				$('.modal #checkbox62').attr('disabled', 'disabled');
			}
			if(data.gerenciar_gti){
				$('.modal #checkbox63').attr('checked', 'checked');
				$('.modal #checkbox63').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox63').removeAttr('checked');
				$('.modal #checkbox63').attr('disabled', 'disabled');
			}
			// Configurações
			if(data.ver_configuracoes){
				$('.modal #checkbox64').attr('checked', 'checked');
				$('.modal #checkbox64').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox64').removeAttr('checked');
				$('.modal #checkbox64').attr('disabled', 'disabled');
			}
			if(data.gerenciar_configuracoes){
				$('.modal #checkbox65').attr('checked', 'checked');
				$('.modal #checkbox65').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox65').removeAttr('checked');
				$('.modal #checkbox65').attr('disabled', 'disabled');
			}
			// Administrativo
			if(data.ver_administrativo){
				$('.modal #checkbox66').attr('checked', 'checked');
				$('.modal #checkbox66').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox66').removeAttr('checked');
				$('.modal #checkbox66').attr('disabled', 'disabled');
			}
			if(data.gerenciar_administrativo){
				$('.modal #checkbox67').attr('checked', 'checked');
				$('.modal #checkbox67').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox67').removeAttr('checked');
				$('.modal #checkbox67').attr('disabled', 'disabled');
			}
			// Cadastro
			if(data.ver_cadastro){
				$('.modal #checkbox68').attr('checked', 'checked');
				$('.modal #checkbox68').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox68').removeAttr('checked');
				$('.modal #checkbox68').attr('disabled', 'disabled');
			}
			if(data.gerenciar_cadastro){
				$('.modal #checkbox69').attr('checked', 'checked');
				$('.modal #checkbox69').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox69').removeAttr('checked');
				$('.modal #checkbox69').attr('disabled', 'disabled');
			}
			// Produtos
			if(data.ver_produtos){
				$('.modal #checkbox70').attr('checked', 'checked');
				$('.modal #checkbox70').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox70').removeAttr('checked');
				$('.modal #checkbox70').attr('disabled', 'disabled');
			}
			if(data.gerenciar_produtos){
				$('.modal #checkbox71').attr('checked', 'checked');
				$('.modal #checkbox71').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox71').removeAttr('checked');
				$('.modal #checkbox71').attr('disabled', 'disabled');
			}
			// Atendimento
			if(data.ver_atendimento){
				$('.modal #checkbox72').attr('checked', 'checked');
				$('.modal #checkbox72').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox72').removeAttr('checked');
				$('.modal #checkbox72').attr('disabled', 'disabled');
			}
			if(data.gerenciar_atendimento){
				$('.modal #checkbox73').attr('checked', 'checked');
				$('.modal #checkbox73').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox73').removeAttr('checked');
				$('.modal #checkbox73').attr('disabled', 'disabled');
			}
			// Negócios
			if(data.ver_negocios){
				$('.modal #checkbox74').attr('checked', 'checked');
				$('.modal #checkbox74').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox74').removeAttr('checked');
				$('.modal #checkbox74').attr('disabled', 'disabled');
			}
			if(data.gerenciar_negocios){
				$('.modal #checkbox75').attr('checked', 'checked');
				$('.modal #checkbox75').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox75').removeAttr('checked');
				$('.modal #checkbox75').attr('disabled', 'disabled');
			}
			// Suporte
			if(data.ver_suporte){
				$('.modal #checkbox76').attr('checked', 'checked');
				$('.modal #checkbox76').attr('disabled', 'disabled');
			}else{
				$('.modal #checkbox76').removeAttr('checked');
				$('.modal #checkbox76').attr('disabled', 'disabled');
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
			var url = "{{url('app/configuracoes/administrativo/funcoes/alterar')}}/"+data.id;
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