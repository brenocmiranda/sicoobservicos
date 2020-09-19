@section('title')
Usuários
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Usuários</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li><a href="javascript:void(0)">Administrativo</a></li>
				<li class="active">Usuários</li>
			</ol>
		</div>
	</div>
	<div class="reset"></div>
	<div class="card">
		<div class="card-body">
			<div class="h-100 row col">
				<div class="col-lg-12 position-absolute">
					<div class="d-flex justify-content-end">
						<button class="btn btn-primary btn-outline d-flex align-items-center" id="adicionar" name="adicionar" title="Adicionar novo usuário" data-toggle="modal" data-target="#modal-adicionar" style="z-index: 10">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Novo usuário</span> 
						</button>
					</div>
				</div>
			</div>
			<div class="col-12 mb-3 mx-3 mb-3 mx-3">	
				<table class="table table-striped text-center color-table muted-table rounded" id="table">
					<thead>
						<th> Nick </th>
						<th> Nome </th>
						<th> Instituição </th>
						<th> Função </th>
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
	@include('gestao.administrativo.usuarios.adicionar')
	@include('gestao.administrativo.usuarios.editar')
	@include('gestao.administrativo.usuarios.detalhes')
	@include('gestao.administrativo.usuarios.alterar')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Mascaras
		$('.login').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {
			A: {pattern: /[a-z0-9_.]/},
		}});
		$('.telefone').mask('(00) 00000-0000');

		// Limpando as informações de adicionar
		$('#adicionar').on('click', function(){
			$('#modal-adicionar form').each(function(){
				this.reset();
			});
			if ($(this).hasClass('border-bottom border-danger')){
				this.removeClass('border-bottom border-danger');
			}
		});

		// Criação da tabela
		$('#table').DataTable({
			order: [ 1, "asc" ],
			paging: true,
			select: true,
			searching: true,
			destroy: true,
        	ajax: "{{ route('listar.usuarios.administrativo') }}",
        	serverSide: true,
			"columns": [ 
			{ "data": "image","name":"image"},
			{ "data": "nome","name":"nome"},
			{ "data": "login", "name":"login"},
			{ "data": "funcao","name":"funcao"},
			{ "data": "status1","name":"status1"},
			{ "data": "acoes","name":"acoes"},
			],
		});

		// -------------------------------------------------
		// Retornando informações 
		// -------------------------------------------------

		$('#table tbody').on('click', 'button#editar', function(e){
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
			$('.modal .login').val(data.login);
			$('.modal .status').val(data.status);
			$('.modal .email').val(data.email);
			$('.modal .telefone').val(data.telefone.replace('+55', ''));
			$('.modal .telefone').unmask();
			$('.modal .telefone').mask('(00) 00000-0000');
			$('.modal .usr_id_setor').val(data.usr_id_setor);
			$('.modal .usr_id_funcao').val(data.usr_id_funcao);
			$('.modal .cli_id_associado').val(data.cli_id_associado);
			$('.modal .usr_id_instituicao').val(data.usr_id_instituicao);
			$('.modal .usr_id_unidade').val(data.usr_id_unidade);
			$('#modal-editar').modal('show');	
		});
		$('#table tbody').on('click', 'button#alterar', function(e){
			// Modal alterar
			$('#modal-alterar form').each (function(){
				this.reset();
			});
			var table = $('#table').DataTable();
			table.$('tr.selected').removeClass('selected');
			$(this).parents('tr').addClass('selected');
			$(this).parent('tr').addClass('selected');
			var data = table.row('tr.selected').data();
			$('.modal .cli_id_associado').val(data.cli_id_associado);
			$('.modal .status').val(data.status);
			$('#modal-alterar').modal('show');	
		});
		$('#table tbody').on('click', 'button#resetar', function(e){
			// Modal resetar
			var table = $('#table').DataTable();
			table.$('tr.selected').removeClass('selected');
			$(this).parents('tr').addClass('selected');
			$(this).parent('tr').addClass('selected');
			var data = table.row('tr.selected').data();
		    swal({
		      title: "Tem certeza que deseja redefinir a senha do usuário?",
		      text: "Essa redefinição irá impactar no acesso a plataforma pelo colaborador.",
		      icon: "warning",
		      buttons: ["Cancelar", "Confirmar"],
		    })
		    .then((willDelete) => {
		      if (willDelete) {
		        $.get('usuarios/resetar/'+data.id, function(data){
		          if(data.success == true){
		            swal("Senha redefinida com sucesso!", {
		              icon: "success",
		              button: false
		            });
		            location.reload();
		          }else{
		            swal("Não foi possível redefinir a sua senha!", {
		              icon: "error",
		            });
		          }
		        });
		      } else {
		        swal.close();
		      }
		    });
		});

		$('#table tbody').on('click', 'a#detalhes', function(e){
			// Modal detalhes
			var table = $('#table').DataTable();
			table.$('tr.selected').removeClass('selected');
			$(this).parents('tr').addClass('selected');
			$(this).parent('tr').addClass('selected');
			var data = table.row('tr.selected').data();
			$('.modal .login').val(data.login);
			$('.modal .status').val(data.status);
			$('.modal .email').val(data.email);
			$('.modal .telefone').val(data.telefone.replace('+55', ''));
			$('.modal .telefone').unmask();
			$('.modal .telefone').mask('(00) 00000-0000');
			$('.modal .usr_id_setor').val(data.usr_id_setor);
			$('.modal .usr_id_funcao').val(data.usr_id_funcao);
			$('.modal .cli_id_associado').val(data.cli_id_associado);
			$('.modal .usr_id_instituicao').val(data.usr_id_instituicao);
			$('.modal .usr_id_unidade').val(data.usr_id_unidade);
			$('#modal-detalhes').modal('show');
		});

		// -------------------------------------------------
		// Requisições
		// -------------------------------------------------

		$('#modal-adicionar #formAdicionar').on('submit', function(e){
			// Adicionando novos itens
			var table = $('#table').DataTable();
			var data = table.row('tr.selected').data();
			e.preventDefault();
			$.ajax({
				url: '{{ route("adicionar.usuarios.administrativo") }}',
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
						$('#err').html('');
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
		$('#modal-editar #formEditar').on('submit', function(e){
			// Editando as informações
			var table = $('#table').DataTable();
			var data = table.row('tr.selected').data();
			e.preventDefault();
			$.ajax({
				url: 'usuarios/editar/'+data.id,
				type: 'POST',
				data: $('#modal-editar #formEditar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-adicionar #err').html('');
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
						$('#err').html('');
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
		$('#modal-alterar #formAlterar').on('submit', function(e){
			// Alterando os status
			var table = $('#table').DataTable();
			var data = table.row('tr.selected').data();
			e.preventDefault();
			$.ajax({
				url: 'usuarios/alterar/'+data.id,
				type: 'POST',
				data: $('#modal-alterar #formAlterar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-adicionar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						$('#modal-alterar #formAlterar').each (function(){
							this.reset();
						});
						table.ajax.reload();
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
