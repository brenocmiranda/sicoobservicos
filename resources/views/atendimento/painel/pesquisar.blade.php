@section('title')
Painel comercial
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Painel comercial</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Atendimento</a></li>
				<li><a class="active">Painel comercial</a></li>
			</ol>
		</div>
	</div>

	<div class="card col-12">
		<div class="col-12 row mx-auto">
			<div class="col-12 mx-auto my-4">
				<form method="GET" action="{{route('exibir.associado.atendimento')}}" id="formPesquisar" enctype="multipart/form-data" autocomplete="off">
					
					<div class="card-header bg-white border-0">
						<h5 class="text-center">Encontre seu associado</h5>
					</div>
					<hr class="col-10 my-0">
					<div class="card-body">
						<div class="input-group col-10 mx-auto"> 
							<input type="search" class="form-control" placeholder="Entre com nome, razão social ou documento do associado..." aria-controls="table" name="pesquisar" id="pesquisar" style="border-top-left-radius:6px;border-bottom-left-radius:6px;" required>	
							<div class="input-group-addon p-0 m-0 border-0">
								<button type="submit" class="btn btn-success" style="border-top-right-radius:6px;border-bottom-right-radius:6px;"> 
									<i class="mdi mdi-magnify pr-2"></i> 
									<span>Pesquisar</span> 
								</button>
							</div>
	                    </div>	
	                    <div class="col-12 py-3 text-center">
							<small class="text-warning">* Ao digitar os dados procurados irá retornar os possíveis associados relacionados, basta escolher um deles e pesquisar.</small>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Retornando dados do associado 
		$("#pesquisar").autocomplete({
			source: function(request, response){
				$.ajax({
					url: "{{ route('pesquisar.associado.atendimento') }}",
					data: {	term : request.term	},
					dataType: "json",
					success: function(dados){
						var resp = $.map(dados, function(obj){
							return obj.nome +" : "+ obj.documento;
						}); 
						response(resp);
					}
				})
			},
			minLength: 1
		});
		$("#pesquisar").autocomplete({
			change: function( event, ui ) {
				if(ui.item == null){
					$(this).val('');
				}
			}
		});
	});
</script>
@endsection