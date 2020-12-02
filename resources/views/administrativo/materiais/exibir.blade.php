@section('title')
Solicitações de materiais
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
				<li><a href="{{route('dashboard.administrativo')}}">Administrativo</a></li>
				<li><a class="active">Materiais</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12">
				<div class="col-12 row mb-4 mx-auto justify-content-center">
					@include('layouts.search')
				</div>

				<div class="row col-12 mx-auto my-5">
					<div class="col-12 p-0">
						<h5>Solicitações pendetes</h5>
						<hr class="mt-2">
					</div>
					<div class="col-12">
						@if(isset($pendencias[0]))
							<ul class="p-0" id="prendencias">
								@foreach($pendencias as $pendencia)
								<li class="row">
									<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
										<div class="col-1 m-auto row justify-content-center">
											<i class="mdi mdi-comment-question-outline mdi-48px text-warning"></i>
										</div>
										<div class="col-8">
											<div>
												<h5 class="my-1">{{$pendencia->RelationMaterial->nome}} <small>{{$pendencia->RelationMaterial->RelationCategoria->nome}}</small></h5>
												<small>{{$pendencia->quantidade}} unidades</small>
											</div>
											<div>
												<h6 class="mt-4 mb-2 font-weight-normal">
													<b>Usuário:</b> <span class="text-secondary">{{$pendencia->RelationUsuario->RelationAssociado->nome}}</span>
												</h6>
											</div>
											<div>
												<small><b>Data da solicitação:</b> {{$pendencia->created_at->format('d/m/Y H:i')}}</small>
											</div>
										</div>
										@if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
										<div class="col-3 m-auto row justify-content-end">
											@if($pendencia->RelationMaterial->quantidade > $pendencia->quantidade)
											<a href="javascript:void(0)" class="btn btn-success btn-outline btn-alterar m-2 col-8" data="{{route('aprovar.solicitacoes.administrativo', $pendencia->id)}}">
												<i class="mdi mdi-check pr-2"></i>
												<small>Aprovar</small>
											</a>
											@else
												<span class="text-danger text-right mb-3">* Não possui estoque para aprovação.</span>
											@endif
											<a href="javascript:void(0)" class="btn btn-danger btn-outline btn-desaprovar m-2 col-8" data="{{$pendencia->id}}">
												<i class="mdi mdi-close pr-2"></i>
												<small>Desaprovar</small>
											</a>
										</div>
										@endif
									</div>
								</li>
								@endforeach
							
							</ul>
						@else
							<div class="row p-0">
								<label class="alert alert-secondary col-12 rounded">Você não possui nenhuma pendência.</label>
							</div>
						@endif
					</div>
				</div>

				<div class="row col-12 mx-auto my-5">
					<div class="col-12 p-0">
						<h5>Histórico de solicitações</h5>
						<hr class="mt-2">
					</div>
					<div class="col-12">
						@if(isset($historico[0]))
							<ul class="p-0" id="prendencias">
								@foreach($historico as $item)
								<li class="row">
									<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
										<div class="col-1 m-auto row justify-content-center">
											<i class="mdi {{($item->status == 1 ? 'mdi-comment-check-outline text-success' : ($item->status == 0 ? 'mdi-comment-question-outline text-warning' : 'mdi-comment-remove-outline text-danger'))}} mdi-48px"></i>
										</div>
										<div class="col-9">
											<div>
												<h5 class="my-1">{{$item->RelationMaterial->nome}} <small>{{$item->RelationMaterial->RelationCategoria->nome}}</small></h5>
												<small>{{$item->quantidade}} unidades</small>
											</div>
											<div>
												<h6 class="mt-4 mb-2 font-weight-normal">
													<b>Usuário:</b> <span class="text-secondary">{{$item->RelationUsuario->RelationAssociado->nome}}</span>
												</h6>
											</div>
											<div>
												<small><b>Data da solicitação:</b> {{$item->created_at->format('d/m/Y H:i')}}</small>
											</div>
										</div>
										<div class="col-2 m-auto row justify-content-center">
											<div class="col-12 badge badge-{{($item->status == 1 ? 'success' : ($item->status == 0 ? 'warning' : 'danger'))}} px-3">
												<label class="text-white my-auto">
													<i class="mdi {{($item->status == 1 ? 'mdi-check' : ($item->status == 0 ? 'mdi-alert-circle-outline' : 'mdi-close'))}} pr-2"></i>
													<h6 class="text-white float-right my-1 font-weight-normal">{{($item->status == 1 ? 'Atendida' : ($item->status == 0 ? 'Pendente' : 'Cancelada'))}}</h6>
												</label>
											</div>
										</div>
									</div>
								</li>
								@endforeach
							
							</ul>
						@else
							<div class="row p-0">
								<label class="alert alert-secondary col-12 rounded">Você não possui nenhuma pendência.</label>
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
	@include('administrativo.materiais.cancelar')
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
		// Modal de recusar
		$('.btn-desaprovar').on('click', function(e){
			e.preventDefault();
			var id = $(this).attr('data');
			$('#modal-desaprovar #identificador').val(id);
			$('#modal-desaprovar').modal('show');
		});

		$('#modal-desaprovar #formDesaprovar').on('submit', function(e){
			e.preventDefault();
			// Desaprovando solicitações
			$.ajax({
				url: 'solicitacoes/desaprovar/'+$('#modal-desaprovar #identificador').val(),
				type: 'POST',
				data: new FormData(this),
				processData: false,
		        contentType: false,
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-desaprovar #err').html('');
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
							$('#modal-desaprovar #err').html(data.responseText);
						}else{
							$('#modal-desaprovar #err').html('');
							$('input').removeClass('border-bottom border-danger');
							$.each(data.responseJSON.errors, function(key, value){
								$('#modal-desaprovar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
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