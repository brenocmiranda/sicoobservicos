@section('title')
Materiais
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Solicitações de materiais</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Suporte</a></li>
				<li><a class="active">Materiais</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12">
				<div class="col-12 row mb-4 mx-auto">
					@include('layouts.search')
					<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Solicitar novo material" data-toggle="modal" data-target="#modal-solicitacao">
						<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
						<span class="hidden-xs">Nova solicitação</span>
					</button>
				</div>

				<div class="row col-12 mx-auto my-5">
					<div class="col-12 p-0">
						<h5>Minhas solicitações</h5>
						<hr class="mt-2">
					</div>
					<div class="col-12 p-0">
						@if(isset($requisicoes[0]))
						<ul class="p-0" id="requisicoes">
							@foreach($requisicoes as $requisicao)
							<li class="row">
								<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
									<div class="col-1 m-auto row justify-content-center">
										<i class="mdi {{($requisicao->status == 1 ? 'mdi-comment-check-outline text-success' : ($requisicao->status == 0 ? 'mdi-comment-question-outline text-warning' : 'mdi-comment-remove-outline text-danger'))}} mdi-48px"></i>
									</div>
									<div class="col-8">
										<div>
											<h5 class="my-1">
												<span>{{$requisicao->RelationMaterial->nome}}</span>
												<small>{{$requisicao->RelationMaterial->RelationCategoria->nome}}</small>
											</h5>
											<h6 class="mt-2 font-weight-normal text-muted">Solicitação de Nº {{$requisicao->id}}</h6>
										</div>
										<div>
											<small><b>Quantidade:</b> {{$requisicao->quantidade}} unidades</small>
										</div>
										<div>
											<small><b>Data da solicitação:</b> {{$requisicao->created_at->format('d/m/Y H:i')}}</small>
										</div>
										@if(!empty($requisicao->observacao) && $requisicao->status == 2)
										<div>
											<small><b>Motivo:</b> {{$requisicao->observacao}}</small>
										</div>
										@endif
									</div>
									<div class="col-2 m-auto row justify-content-center">
										<div class="col-12 badge badge-{{($requisicao->status == 1 ? 'success' : ($requisicao->status == 0 ? 'warning' : 'danger'))}} px-3">
											<label class="text-white my-auto">
												<i class="mdi {{($requisicao->status == 1 ? 'mdi-check' : ($requisicao->status == 0 ? 'mdi-alert-circle-outline' : 'mdi-close'))}} pr-2"></i>
												<h6 class="text-white float-right my-1 font-weight-normal">{{($requisicao->status == 1 ? 'Atendida' : ($requisicao->status == 0 ? 'Pendente' : 'Cancelada'))}}</h6>
											</label>
										</div>
										@if($requisicao->status == 0)
										<div class="col-12 text-center mt-2">
											<a href="javascript:void(0)" class="btn-cancelar" data="{{$requisicao->id}}">
												<small>
													<i class="mdi mdi-close pr-2"></i><span>Cancelar</span>
												</small>
											</a>
										</div>
										@endif
									</div>
								</div>
							</li>
							@endforeach
						</ul>
						@else
							<div class="row mx-auto">
								<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação.</label>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('suporte.materiais.solicitacao')
	@include('suporte.materiais.cancelar')
@endsection

@section('suporte')

<script type="text/javascript">
	function removeItem(index){
		$(index).closest('div').remove();
		if(!($('#modal-solicitacao #materiais').find('div')[0])){
			$('#modal-solicitacao button[type=submit]').attr('disabled', 'disabled');
			$('#modal-solicitacao #materiais').html('<div class="pb-2 null"> <span>Nenhum item selecionado.</span> </div>'); 
		}
	}

	$(document).ready( function (){
		

		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#requisicoes li").css("display", "block");
			$("#requisicoes li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});

		// Retornando materiais
		$('.categorias').on('change', function(e){
			var categoria = $('.categorias').val();
			$.ajax({
				url: "{{url('app/suporte/materiais/categorias')}}/"+categoria,
				type: 'GET',
				success: function(data){ 
					$('#modal-solicitacao #err').html('');
					if(data[0]){
						$('.materiais').html('');
						$('.materiais').removeAttr('disabled');
						$('.materiais').append('<option value="">Selecione</option>');
						$.each(data, function(count, dados){
							$('.materiais').fadeIn(3000).append('<option value="'+dados.id+'"> '+dados.nome+'</option>');
						});	
					}else{
						$('.materiais').html('');
						$('.materiais').attr('disabled', 'disabled');
						$('.materiais').fadeIn(3000).append('<option value=""> Nenhum material cadastrado</option>');
					}
				}
			});
		});
		// Adicionar item
		$('#modal-solicitacao #adicionarItem').on('click', function(e){
			var nome = $('.materiais').find(":selected").text();
			var material = $('.materiais').val();
			var quantidade = $('.quantidade').val();
			if(material){
				if(quantidade && quantidade > 0){
					$('#modal-solicitacao #err').html('');
					$('#modal-solicitacao #materiais .null').remove();
					$('#modal-solicitacao #materiais').append('<div class="pb-2"> <span class="font-weight-bold">&#183</span> <span>'+nome+'</span> <input type="hidden" name="id_material[]" value="'+material+'"> <small>('+quantidade+' unidades)</small> <input type="hidden" name="quantidade[]" value="'+quantidade+'"> <a href="javascript:void(0)" title="Remover material" onclick="removeItem(this);"> <i class="mdi mdi-delete-empty text-danger"></i> </a> </div>');
					$('#modal-solicitacao button[type=submit]').removeAttr('disabled');
					$('.categorias').val('');
					$('.materiais').html('');
					$('.materiais').attr('disabled', 'disabled');
					$('.quantidade').val('');

				}else{
					$('#modal-solicitacao #err').html('<div class="text-danger mx-4"><p>Descreva a quantidade necessária.</p></div>');
				} 
			}else{
				$('#modal-solicitacao #err').html('<div class="text-danger mx-4"><p>Selecione um material.</p></div>');
			}
		});
		// Modal de recusar
		$('.btn-cancelar').on('click', function(e){
			e.preventDefault();
			var id = $(this).attr('data');
			$('#modal-cancelar #identificador').val(id);
			$('#modal-cancelar').modal('show');
		});

		// Efetuando solicitação
		$('#modal-solicitacao #formSolicitacao').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: '{{ route("efetuar.solicitacoes.materiais") }}',
				type: 'POST',
				data: $('#modal-solicitacao #formSolicitacao').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-solicitacao #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					location.reload();
				}, error: function (data) {
					setTimeout(function(){
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('.carregamento').html('');
						if(!data.responseJSON){
							console.log(data.responseText);
							$('#modal-solicitacao #err').html(data.responseText);
						}else{
							$('#modal-solicitacao #err').html('');
							$('input').removeClass('border-bottom border-danger');
							$.each(data.responseJSON.errors, function(key, value){
								$('#modal-solicitacao #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
								$('input[name="'+key+'"]').addClass('border-bottom border-danger');
							});
						}
					}, 2000);
				}
			});
		});
		// Desaprovar solicitação
		$('#modal-cancelar #formCancelar').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: 'materiais/cancelar/'+$('#modal-cancelar #identificador').val(),
				type: 'POST',
				data: new FormData(this),
				processData: false,
		        contentType: false,
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-cancelar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						location.reload()
					}, 2000);
				}, error: function (data) {
					setTimeout(function(){
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('.carregamento').html('');
						if(!data.responseJSON){
							console.log(data.responseText);
							$('#modal-cancelar #err').html(data.responseText);
						}else{
							$('#modal-cancelar #err').html('');
							$('input').removeClass('border-bottom border-danger');
							$.each(data.responseJSON.errors, function(key, value){
								$('#modal-cancelar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
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