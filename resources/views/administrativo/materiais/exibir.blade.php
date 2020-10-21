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
				<li><a href="javascript:void(0)">Suporte</a></li>
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
						<h5>Solicitações pendetes de aprovação</h5>
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
										<div class="col-2 m-auto row justify-content-center">
											<a href="javascript:void(0)" class="btn btn-success btn-outline btn-alterar" data="{{route('aprovar.solicitacoes.administrativo', $pendencia->id)}}">
												<i class="mdi mdi-check pr-2"></i>
												<span>Aprovar</span>
											</a>
										</div>
									</div>
								</li>
								@endforeach
							
							</ul>
						@else
							<div class="row p-0">
								<label class="alert alert-secondary col-12 rounded">Você não possui nenhuma pêndencia.</label>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
	});
</script>
@endsection