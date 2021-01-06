@section('title')
Atalhos
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Atalhos</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.gti')}}">Tecnologia</a></li>
				<li class="active">Atalhos</li>
			</ol>
		</div>
	</div>
	<div class="confim"></div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mb-4 mx-auto">
				@include('layouts.search')
				@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
				<div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
					<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo atalho" data-toggle="modal" data-target="#modal-adicionar">
						<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
						<span class="hidden-xs">Cadastrar</span>
					</button>
				</div>
				@endif
			</div>
			
			<ul class="row col-12 m-auto py-3" id="atalhos">
				@if(isset($atalhos[0]))
					@foreach($atalhos as $atalho)
					<li class="col-lg-2 col-sm-6 col-12">
						<div class="p-3 h-100">
							<div class="text-center">
								<img src="{{ asset('storage/app/'.$atalho->RelationImagem->endereco) }}" class="border img-circle p-2 bg-ligth" width="60" height="60">
							</div>
							<div class="text-center">
								<h5 class="text-uppercase mb-2 text-truncate">
									<a href="javascript:void(0)" class="btn-detalhes" data="{{route('detalhes.atalhos', $atalho->id)}}">
										<span>{{$atalho->titulo}}</span>
									</a>
								</h5>
								<label class="text-truncate text-uppercase d-block">	
									<span>{{(isset($atalho->subtitulo) ? $atalho->subtitulo : '_')}}</span>
								</label>
								@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
								<div class="my-3">
									<a href="javascript:void(0)" data="{{route('detalhes.atalhos', $atalho->id)}}" class="btn btn-default btn-outline btn-xs ml-auto btn-editar" title="Editar informações">
										<small>Editar</small>
									</a>
									<a href="javascript:void(0)" data="{{route('delete.atalhos', $atalho->id)}}" class="btn btn-default btn-outline btn-xs ml-auto btn-remove" title="Excluir atalho">
										<small>Deletar</small>
									</a>
								</div>
								@endif
							</div>
						</div>
					</li>
					@endforeach
				@else
				<div class="row mx-auto col-12 p-0">
					<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhum atalho cadastrado.</label>
				</div>
				@endif
			</ul>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('tecnologia.atalhos.adicionar')
	@include('tecnologia.atalhos.editar')
	@include('tecnologia.atalhos.detalhes')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Icone de upload
		$('.btn-image').hover( function(){
			$('.btn-image i').fadeIn('fast');
		} , function() {
			$('.btn-image i').fadeOut('fast');
		});

		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#atalhos li").css("display", "block");
			$("#atalhos li").each(function(){
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
				$('.modal .titulo').val(data.titulo);
				$('.modal .subtitulo').val(data.subtitulo);
				$('.modal .endereco').val(data.endereco);
				$('.modal #PreviewImageEdit').attr('src', '{{asset("storage/app")}}/'+data.image);
				$('#modal-editar').modal('show');
			}).fail(function(e){
				swal("Não foi possível carregar as informações.", {
	              icon: "error",
	            });
			});			
		});
		$('.btn-remove').on('click', function(e){
			// Removendo status do chamado
			e.preventDefault();
			var url = $(this).attr('data')
			swal({
				title: "Tem certeza que deseja remover esse atalho?",
				icon: "warning",
				buttons: ["Cancelar", "Confirmar"],
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.get(url, function(data){
						if(data.success == true){
							swal("Status removido com sucesso!", {
								icon: "success",
								button: false
							});
							location.reload();
						}else{
							swal("Não foi possível remover esse atalho da atalhos!", {
								icon: "error",
							});
						}
					});
				} else {
					swal.close();
				}
			});
		});
		$('.btn-detalhes').on('click', function(e){
			// Modal detalhes
			$.get($(this).attr('data'), function(data){
				$('.modal .titulo').val(data.titulo);
				$('.modal .subtitulo').val(data.subtitulo);
				$('.modal .endereco').val(data.endereco);
				$('.modal #PreviewImage').attr('src', '{{asset("storage/app")}}/'+data.image);
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

		$('#modal-adicionar #formAdicionar').on('submit', function(e){
			// Adicionando novos
			e.preventDefault();
			$.ajax({
				url: '{{ route("adicionar.atalhos") }}',
				type: 'POST',
				contentType: false,
	            cache: false,
	            processData:false,
				data: new FormData(this),
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
				url: 'atalhos/editar/'+$('#formEditar .identificador').val(),
				type: 'POST',
				contentType: false,
	            cache: false,
	            processData:false,
				data: new FormData(this),
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