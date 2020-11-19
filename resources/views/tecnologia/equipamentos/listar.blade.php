@section('title')
Invetário geral
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Invetário geral</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.gti')}}">Tecnologia</a></li>
				<li><a href="javascript:void(0)">Invetário</a></li>
				<li class="active">Geral</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="h-100 row col">
				<div class="col-lg-12 position-absolute">
					@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
					<div class="row mx-auto">
						<a href="{{route('adicionar.equipamentos')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo equipamento" style="z-index: 10">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Novo equipamento</span> 
						</a>
					</div>
					@endif
				</div>
			</div>
			<div class="col-12 mb-3 mx-3">
				<table class="table text-center color-table muted-table rounded" id="table">
					<thead>
						<th> Imagem </th>
						<th> Nome </th>
						<th> Nº patrimonio </th>
						<th> Nº série </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('tecnologia.equipamentos.detalhes')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		
		// Criando a datatables
		$('#table').DataTable({
			deferRender: true,
			order: [1, 'asc'],
			paginate: true,
			select: true,
			searching: true,
			destroy: true,
			ajax: "{{ route('listar.equipamentos') }}",
			serverSide: true,
			"columns": [ 
			{ "data": "imagem1","name":"imagem1"},
			{ "data": "nome1", "name":"nome1"},
			{ "data": "n_patrimonio", "name":"n_patrimonio"},
			{ "data": "serialNumber", "name":"serialNumber"},
			{ "data": "acoes","name":"acoes"},
			],
		});
		
		// -------------------------------------------------
		// Retornando informações 
		// -------------------------------------------------
		$('#table tbody').on('click', 'a#detalhes', function () {
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			$('.modal .nome').html(data.nome);
			$('.modal .marca').html(data.marca);
			$('.modal .modelo').html(data.modelo);
			$('.modal .n_patrimonio').html(data.n_patrimonio);
			$('.modal .serialNumber').html(data.serialNumber);
			$('.modal .id_setor').html(data.setor);
			$('.modal .usuario').html(data.usuario);
			$('.modal .descricao').html(data.descricao);
			$.get('./detalhes/'+data.id, function(data){
				$('.modal #ImagemPrincipalUrl').attr('href', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('.modal #ImagemPrincipal').attr('src', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('.preview').html('');
				$.each(data.imagens, function(count,dados){
					$('.preview').append('<a href="{{url("storage/app")}}/'+dados.endereco+'"><img class="border rounded m-1 p-2" src="{{url("storage/app")}}/'+dados.endereco+'" height="50" width="50"></a>')
				});
			});
			$('#modal-detalhes').modal('show');	
		});

		// -------------------------------------------------
		// Requisições
		// -------------------------------------------------
		$('#table tbody').on('click', 'button#remover', function () {
			// Alterando status
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			swal({
				title: "Tem certeza que deseja remover esse equipamento?",
				icon: "warning",
				buttons: ["Cancelar", "Remover"],
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.get('./remover/'+data.id, function(data){
						if(data.success == true){
							swal("Equipamento removido com sucesso!", {
								icon: "success",
								button: false
							});
							table.ajax.reload();
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