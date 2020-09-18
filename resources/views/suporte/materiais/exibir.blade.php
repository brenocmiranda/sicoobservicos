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
						<i class="m-0 pr-1 mdi mdi-plus"></i> 
						<span>Nova solicitação</span>
					</button>
				</div>

				<div class="row col-12 mx-auto my-5">
					<div class="col-12 p-0">
						<h5>Minhas solicitações</h5>
						<hr class="mt-2">
					</div>
					<div class="col-12">
						@if(isset($requisicoes[0]))
						<ul class="p-0" id="requisicoes">
							@foreach($requisicoes as $requisicao)
							<li class="row">
								<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
									<div class="col-1 m-auto row justify-content-center">
										<i class="mdi {{($requisicao->status == 1 ? 'mdi-comment-check-outline text-success' : 'mdi-comment-question-outline text-warning')}} mdi-48px"></i>
									</div>
									<div class="col-8">
										<div>
											<h5 class="my-1">{{$requisicao->RelationMaterial->nome}}</h5>
											<h6 class="mt-0 font-weight-normal text-muted">{{$requisicao->RelationMaterial->RelationCategoria->nome}}</h6>
										</div>
										<div>
											<small><b>Quantidade:</b> {{$requisicao->quantidade}} unidades</small>
										</div>
										<div>
											<small><b>Data da solicitação:</b> {{$requisicao->created_at->format('d/m/Y H:i')}}</small>
										</div>
									</div>
									<div class="col-2 m-auto row justify-content-center">
										<div class="badge badge-{{($requisicao->status == 1 ? 'success' : 'warning')}} px-3">
											<label class="text-white my-auto">
												<i class="mdi {{($requisicao->status == 1 ? 'mdi-check' : 'mdi-alert-circle-outline')}} pr-2"></i>
												<span>{{($requisicao->status == 1 ? 'Atendida' : 'Pendente')}}</span>
											</label>
										</div>
									</div>
								</div>
							</li>
							@endforeach
						</ul>
						@else
							<div class="row mx-auto">
								<label class="alert alert-secondary col-12 rounded">Você não possui nenhuma solicitação.</label>
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
@endsection

@section('suporte')
<script type="text/javascript">
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
					if(data[0]){
						$('.materiais').html('');
						$('.materiais').removeAttr('disabled');
						$.each(data, function(count, dados){
							$('.materiais').fadeIn(3000).append('<option value="'+dados.id+'"> '+dados.nome+'</option>');
						});	
					}else{
						$('.materiais').html('');
						$('.materiais').fadeIn(3000).append('<option> Nenhum material cadastrado</option>');
					}
					
				}
			});
		});
		// Aprovando solicitação
		$('.btn-alterar').on('click', function(e){
			e.preventDefault();
			var url = $(this).attr('data');
			swal({
				title: "Tem certeza que deseja aprovar?",
				icon: "warning",
				buttons: ["Cancelar", "Aprovar"],
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
							swal("Material não possui estoque para aprovação, reabasteça e tente novamente!", {
								icon: "error",
							});
						}
					});
				} else {
					swal.close();
				}
			});
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

	});
</script>
@endsection