@section('title')
Equipamentos
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Ativos</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">GTI</a></li>
				<li class="active">Ativos</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mb-4 mx-auto">
				@include('layouts.search')
				<div class="col-5 p-0 row mx-auto">
					<a href="{{route('adicionar.ativos')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo ativo">
						<i class="m-0 pr-1 mdi mdi-plus"></i> 
						<span>Novo ativo</span>
					</a>
				</div>
			</div>
			<ul class="row col-12 m-auto" id="ativos">
				@if(isset($ativos[0]))
					@foreach($ativos as $ativo)
					<li class="col-3 p-3">
						<div class="card shadow-sm">
							<div class="card-header p-0 bg-white border-white">
                            	<div class="item text-center"> 
									<img src="{{(isset($ativo->RelationImagemPrincipal) ? asset('storage/app/'.$ativo->RelationImagemPrincipal->endereco) : asset('public/img/image.png'))}}" class="p-4" height="120" width="130">
								</div>		
							</div>
							<div class="card-body py-3 px-4">
								<h5 class="text-uppercase text-truncate mb-1">
									<a href="javascript:void(0)" data="{{route('detalhes.ativos', $ativo->id)}}" class="btn-detalhes">{{$ativo->nome}}</a>
								</h5>
								<label class="text-truncate text-primary">
									{{$ativo->RelationUsuario->last()->RelationAssociado->nome}}
								</label>
								<label class="text-truncate d-block my-0">	
									<small><b>Marca:</b> {{$ativo->marca}}</small>
								</label>
								<label class="text-truncate d-block my-0">
									<small><b>Módelo:</b> {{$ativo->modelo}}</small>
								</label>
								<label class="text-truncate d-block">
									<small><b>S/N:</b> {{$ativo->serialNumber}}</small>
								</label>
								<div class="my-3 text-center">
									<a href="{{route('relatorio.ativos', $ativo->id)}}" target="_blank" class="btn btn-success btn-outline btn-shadow" title="Relatório do ativo">
										<i class="mdi mdi-cloud-print-outline"></i>
									</a>	
									<a href="{{route('editar.ativos', $ativo->id)}}" class="status btn btn-success btn-outline" title="Editar inforamções">
										<i class="mdi mdi-settings"></i>
									</a>
									<a href="javascript:void(0)" data="{{route('delete.ativos', $ativo->id)}}" class="btn btn-danger btn-outline btn-delete" title="Deletar ativo">
										<i class="mdi mdi-close"></i>
									</a>
								</div>
							</div>
						</div>
					</li>
					@endforeach
				@else
					<div class="row mx-auto col-12 p-0">
						<label class="alert alert-secondary col-12 rounded">Você não possui nenhum ativo cadastrado.</label>
					</div>
				@endif
			</ul>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('tecnologia.ativos.detalhes')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#ativos li").css("display", "block");
			$("#ativos li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});
		
		// -------------------------------------------------
		// Retornando informações 
		// -------------------------------------------------
		$('.btn-detalhes').on('click', function(e){
			// Modal detalhes
			$.get($(this).attr('data'), function(data){
				$('.modal .nome').html(data.nome);
				$('.modal .marca').html(data.marca);
				$('.modal .modelo').html(data.modelo);
				$('.modal .n_patrimonio').html(data.n_patrimonio);
				$('.modal .serialNumber').html(data.serialNumber);
				$('.modal .id_setor').html(data.setor.nome);
				$('.modal .usuario').html(data.usuario);
				$('.modal .descricao').html(data.descricao);
				$('.modal #ImagemPrincipalUrl').attr('href', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('.modal #ImagemPrincipal').attr('src', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('.preview').html('');
				$.each(data.imagens, function(count,dados){
					$('.preview').append('<a href="{{url("storage/app")}}/'+dados.endereco+'"><img class="border rounded m-1" src="{{url("storage/app")}}/'+dados.endereco+'" height="50" width="50"></a>')
				});
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
		$('.btn-delete').on('click', function(e){
			// Alterando status
			e.preventDefault();
			var url = $(this).attr('data');
			swal({
				title: "Tem certeza que deseja remover esse ativo?",
				icon: "warning",
				buttons: ["Cancelar", "Deletar"],
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.get(url, function(data){
						if(data.success == true){
							swal("Ativo removido com sucesso!", {
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