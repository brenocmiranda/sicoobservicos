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
				@if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
				<div class="col-12 row mb-4 mx-auto">
					@include('layouts.search')
					<a href="{{route('adicionar.bens.administrativo')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo bens da da cooperativa">
						<i class="m-0 pr-1 mdi mdi-plus"></i> 
						<span>Novo bem</span>
					</a>
				</div>
				@endif
				<div class="row col-12 mx-auto my-5">
					<div class="col-12 p-0">
						@if(isset($bens[0]))
							<ul class="row p-0" id="bens">
								@foreach($bens as $item)
								<li class="col-6">
									<div class="row mx-auto col-12 border shadow-sm rounded my-3 p-3">
										<div class="col-12">
											<a href="{{route('detalhes.bens.administrativo', $item->id)}}" class="row">
												<div class="col-4 row mx-auto p-1">
													<img src="{{asset('storage/app').'/'.$item->RelationImagemPrincipal->endereco}}" class="rounded" height="100" width="140">
												</div>
												<div class="col-8 pr-0">
													<h5>{{$item->nome}} <small>{{($item->tipo == 'veiculos' ? "Veículos" : ($item->tipo == 'imovel' ? "Imóvel" : "Outros"))}}</small></h5>
													@if(isset($item->cep))
													<div style="line-height: 15px">
														<small class="text-dark d-block">{{(isset($item->rua) ? $item->rua.',' : '')}} {{$item->numero}}, {{$item->bairro}}</small>
														<small class="text-dark d-block">{{$item->cep}} - {{$item->cidade}}/{{$item->estado}}</small>
													</div>
													@endif
										            <h5>R$ {{number_format($item->valor,2,",",".")}}</h5> 
												</div>
											</a>
										</div>
										@if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
										<div class="col-12 m-auto row text-right">
											<div class="row ml-auto">
								              <a href="{{route('editar.bens.administrativo', $item->id)}}" class="btn btn-default btn-xs px-3 m-2 col-5">
								                <i class="mdi mdi-pencil"></i>
								                <small>Editar</small>
								              </a>
								              <a href="javascript:void(0)" data="{{route('delete.bens.administrativo', $item->id)}}" class="btn btn-default btn-xs btn-delete px-3 my-2 col-6">
								                <i class="mdi mdi-close"></i>
								                <small>Remover</small>
								              </a>
								            </div>
										</div>
										@endif
									</div>
								</li>
								@endforeach
							</ul>
						@else
							<div class="row mx-auto">
								<label class="alert alert-secondary col-12 rounded">Você não possui nenhum bens cadastrados.</label>
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