@section('title')
Bens
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Bens da cooperativa</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.administrativo')}}">Administrativo</a></li>
				<li class="active">Bens</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12">
				<div class="col-12 row mb-4 mx-auto">
					@include('layouts.search')
					<div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
						@if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
						<a href="{{route('adicionar.bens.administrativo')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo bens da da cooperativa">
							<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
							<span class="hidden-xs">Cadastrar</span>
						</a>
						@endif
					</div>
				</div>
				<div class="row col-12 mx-auto my-5 px-0">
					<div class="col-12 p-0">
						@if(isset($bens[0]))
							<ul class="row p-0" id="bens">
								@foreach($bens as $item)
								<li class="col-lg-6 col-sm-6 col-12">
									<div class="row mx-auto col-12 px-0 h-100 py-3">
										<div class="row col-12 px-0 mx-auto border shadow-sm">
											<div class="col-lg-4 d-none d-lg-block w-100 px-0 border-right">
												<a href="{{route('detalhes.bens.administrativo', $item->id)}}">
													<div style="min-height: 160px; height: 100%; background: url({{asset('storage/app').'/'.$item->RelationImagemPrincipal->endereco}}); background-size: 100% 100%;"></div>
												</a>
											</div>
											<div class="row mx-auto col-12 col-lg-8 py-3 px-0 h-100">
												<div class="mx-auto row col-12">
													<a href="{{route('detalhes.bens.administrativo', $item->id)}}" class="w-100 text-left">
														<h5 class="mt-2 mb-1">{{$item->nome}} <small>{{($item->tipo == 'veiculos' ? "Veículos" : ($item->tipo == 'imovel' ? "Imóvel" : "Outros"))}}</small></h5>
														<p class="text-dark mb-3" style="line-height: 13px">
															<small>{{$item->RelationAssociado->nome}}</small>
														</p>
														@if(isset($item->cep))
														<div style="line-height: 15px">
															<small class="text-dark d-block">{{(isset($item->rua) ? $item->rua.', ' : '').(isset($item->numero) ? $item->numero.', ' : '').(isset($item->bairro) ? $item->bairro : '')}}</small>
															<small class="text-dark d-block">{{$item->complemento}}</small>
															<small class="text-dark d-block">{{$item->cidade}}/{{$item->estado}}</small>
														</div>
														@endif
														<h5>R$ {{number_format($item->valor,2,",",".")}}</h5> 
													</a>
												</div>
									            @if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
													<div class="mx-auto mt-auto row col-12">
														<div class="w-100 text-right">
												            <a href="{{route('editar.bens.administrativo', $item->id)}}" title="Alterar informações" class="btn btn-default btn-xs m-2 col-2">
												                <i class="mdi mdi-pencil"></i>
												            </a>
												            <a href="javascript:void(0)" data="{{route('delete.bens.administrativo', $item->id)}}" title="Remover item" class="btn btn-default btn-xs btn-delete my-2 col-2">
												                <i class="mdi mdi-close"></i>
												            </a>
										          		</div>
													</div>
												@endif
											</div>
										</div>
									</div>
								</li>
								@endforeach
							</ul>
						@else
							<div class="row mx-auto">
								<label class="alert alert-secondary col-12 rounded mb-0"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i>A sua instituição não possui nenhum bem cadastrado.</label>
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
			$("#bens li").css("display", "block");
			$("#bens li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});

		// Removendo bens
		$('.btn-delete').on('click', function (e) {
			var url = $(this).attr('data');
			console.log(url);
			swal({
				title: "Tem certeza que deseja remover esse bem?",
				icon: "warning",
				buttons: ["Cancelar", "Remover"],
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.get(url, function(data){
						if(data.success == true){
							swal("Bem removido com sucesso!", {
								icon: "success",
								button: false
							});
							location.reload();
						}else{
							swal("Não foi possível remover as informações.", {
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