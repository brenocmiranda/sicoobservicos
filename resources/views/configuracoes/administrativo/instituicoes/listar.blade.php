@section('title')
Instituições
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Instituições</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li><a href="javascript:void(0)">Administrativo</a></li>
				<li class="active">Instituições</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mb-4 mx-auto">
				@include('layouts.search')
				@if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1)
				<div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
					<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar nova instituição" data-toggle="modal" data-target="#modal-adicionar">
						<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
						<span class="hidden-xs">Cadastrar</span>
					</button>
				</div>
				@endif
			</div>
			@if(isset($instituicoes[0]))
			<ul class="row col-12 m-auto" id="instituicoes">
				@foreach($instituicoes as $instituicao)
				<li class="col-12 col-sm-6 col-lg-3 p-3">
					<div class="card p-3 shadow-sm">
						<div class="text-center">
							<i class="mdi mdi-city mdi-48px mdi-dark"></i>
						</div>
						<div class="text-center">
							<h5 class="text-uppercase">
								<span>
									<a href="javascript:void(0)" class="btn-detalhes nome mt-0" data="{{route('detalhes.instituicoes.administrativo', $instituicao->id)}}">{{$instituicao->nome}}</a>
								</span>
								<i class="fa fa-circle text-{{($instituicao->status == 1 ? 'success' : 'danger')}} pb-1 status" style="font-size: 9px;vertical-align: middle;"></i>
							</h5>
							<label class="text-truncate d-block">	
								<span class="email">{{$instituicao->email}}</span>
							</label>
							<label class="text-truncate">
								<span class="telefone">{{$instituicao->telefone}}</span>
							</label>
							<div class="my-2">
								<a href="javascript:void(0)" data="{{route('detalhes.instituicoes.administrativo', $instituicao->id)}}" class="btn btn-success btn-outline btn-xs ml-auto btn-editar" title="Editar informações">
									<i class="mdi mdi-pencil"></i>
									<small>Editar</small>
								</a>
								@if($instituicao->status == 1)
								<a href="javascript:void(0)" data="{{route('alterar.instituicoes.administrativo', $instituicao->id)}}" class="btn btn-danger btn-outline btn-xs ml-auto btn-alterar" title="Desativar instituição">
									<i class="mdi mdi-close"></i>
									<small>Desativar</small>
								</a>
								@else
								<a href="javascript:void(0)" data="{{route('alterar.instituicoes.administrativo', $instituicao->id)}}" class="btn btn-success btn-outline btn-xs ml-auto btn-alterar" title="Ativar instituição">
									<i class="mdi mdi-check"></i>
									<small>Ativar</small>
								</a>
								@endif
							</div>
						</div>
					</div>
				</li>
				@endforeach
			</ul>
			@else
            <div class="row mx-auto col-12 p-0">
				<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma instituição cadastrada.</label>
			</div>
            @endif
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('configuracoes.administrativo.instituicoes.adicionar')
	@include('configuracoes.administrativo.instituicoes.editar')
	@include('configuracoes.administrativo.instituicoes.detalhes')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Mascaras
		$('.telefone').mask('(99) 9999-9999');

		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#instituicoes li").css("display", "block");
			$("#instituicoes li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});
		
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
		
		// -------------------------------------------------
		// Retornando informações 
		// -------------------------------------------------

		$('.btn-editar').on('click', function(e) {
			// Modal editar
			$('#modal-editar form').each(function(){
				this.reset();
			});
			$('#modal-editar #err').html('');
			$.get($(this).attr('data'), function(data){
				$('.modal .identificador').val(data.id);
				$('.modal .nome').val(data.nome);
				$('.modal .telefone').val(data.telefone);
				$('.modal .email').val(data.email);
				$('.modal .descricao').val(data.descricao);
				if(data.status == 1){
					$(".modal .status").prop('checked', false).trigger("click");
				}else{
					$(".modal .status").prop('checked', true).trigger("click");
				}	
				$('#modal-editar').modal('show');
			}).fail(function(e){
				swal("Não foi possível carregar as informações.", {
	              icon: "error",
	            });
			});			
		});
		$('.btn-detalhes').on('click', function(e){
			// Modal detalhes
			$.get($(this).attr('data'), function(data){
				$('.modal .nome').val(data.nome);
				$('.modal .telefone').val(data.telefone);
				$('.modal .email').val(data.email);
				$('.modal .descricao').val(data.descricao);
				if(data.status == 1){
					$('#modal-detalhes .status').removeAttr('disabled');
					$(".modal .status").prop('checked', false).trigger("click");
					$('#modal-detalhes .status').attr('disabled', 'disabled');
				}else{
					$('#modal-detalhes .status').removeAttr('disabled');
					$(".modal .status").prop('checked', true).trigger("click");
					$('#modal-detalhes .status').attr('disabled', 'disabled');
				}
				$('#modal-detalhes').modal('show');	
			}).fail(function(e){
				swal("Não foi possível carregar as informações.", {
	              icon: "error",
	            });
			});	
		});

		// -------------------------------------------------
		// Requisições
		// -------------------------------------------------
		$('.btn-alterar').on('click', function(e){
			// Alterando status
			e.preventDefault();
			var url = $(this).attr('data');
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
								button: false
							});
							location.reload();
						}else{
							swal("Não foi possível alterar essas informações, tente novamete!", {
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
			// Adicionando novos
			e.preventDefault();
			$.ajax({
				url: '{{ route("adicionar.instituicoes.administrativo") }}',
				type: 'POST',
				data: $('#modal-adicionar #formAdicionar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
					$('#modal-adicionar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}, error: function(data){
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
			e.preventDefault();
			$.ajax({
				url: 'instituicoes/editar/'+$('#formEditar .identificador').val(),
				type: 'POST',
				data: $('#modal-editar #formEditar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
					$('#modal-editar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						location.reload();
					}, 1000);
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