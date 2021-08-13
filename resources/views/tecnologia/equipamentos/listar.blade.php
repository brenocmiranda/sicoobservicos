@section('title')
Inventário geral
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Inventário geral</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.gti')}}">Tecnologia</a></li>
				<li><a href="javascript:void(0)">Inventário</a></li>
				<li class="active">Geral</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="h-100 row col mx-auto px-0">
				<div class="col-lg-12 position-absolute px-0 px-lg-4">
					@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
					<div class="row mx-auto">
						<a href="{{route('adicionar.equipamentos')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo equipamento" style="z-index: 10">
							<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
							<span class="hidden-xs">Cadastrar</span> 
						</a>
					</div>
					@endif
				</div>
			</div>
			<div class="col-12 px-0 px-lg-4 mb-3">
				<table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table" style="overflow-y: auto;">
					<thead>
						<th> Imagem </th>
						<th> Equipamento </th>
						<th> Localização </th>
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
@include('tecnologia.equipamentos.alterar')
@include('tecnologia.equipamentos.historico')
@include('tecnologia.equipamentos.filtros')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		
		// Criando a datatables
		$('#table').DataTable({
			deferRender: true,
			order: false,
			paginate: true,
			select: true,
			searching: true,
			destroy: true,
			ajax: "{{ route('listar.equipamentos') }}",
			serverSide: true,
			"columns": [ 
			{ "data": "imagem1","name":"imagem1"},
			{ "data": "nome1", "name":"nome1"},
			{ "data": "localizacao", "name":"localizacao"},
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
			$('.modal .equipamento').html(data.equipamento);
			$('.modal .sistema_operacional').html((data.sistema_operacional ? data.sistema_operacional : '-'));
			$('.modal .tipo_licenca').html((data.tipo_licenca ? data.tipo_licenca : '-'));
			$('.modal .antivirus').html((data.antivirus ? data.antivirus : '-'));
			$('.modal .marca').html(data.marca);
			$('.modal .modelo').html(data.modelo);
			$('.modal .serviceTag').html((data.serviceTag ? data.serviceTag : '-'));
			$('.modal .n_patrimonio').html((data.n_patrimonio ? data.n_patrimonio : '-'));
			$('.modal .serialNumber').html(data.serialNumber);
			$('.modal .id_setor').html(data.setor);
			$('.modal .usuario').html(data.usuario);
			if(data.descricao){
				$('.modal .descricao').html(data.descricao);
			}else{
				$('.modal .descricao').html('Não informado');
			}
			
			$.get("{{url('app/gti/equipamentos/detalhes')}}/"+data.id, function(data){
				$('.modal #ImagemPrincipalUrl').attr('href', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('.modal #ImagemPrincipal').attr('src', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('.preview').html('');
				$.each(data.imagens, function(count,dados){
					$('.preview').append('<a href="{{url("storage/app")}}/'+dados.endereco+'"><img class="border rounded m-1 p-2" src="{{url("storage/app")}}/'+dados.endereco+'" height="50" width="50"></a>')
				});
			});
			$('#modal-detalhes').modal('show');	
		});

		// Alterando o usuário
		$('#table tbody').on('click', 'a#alterar', function (){
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			$('.modal .identificador').val(data.id);
			$('#modal-alterar').modal('show');	
		});

		// Abrindo o histórico do equipamento
		$('#table tbody').on('click', 'a#historico', function (){
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			$.get("{{url('app/gti/equipamentos/historico')}}/"+data.id, function(dados){
				$('.modal .historico').html('');
				$.each(dados, function(key, value) {
					$('.modal .historico').append('<div class="mb-4"> <p class="mb-0 font-weight-bold">'+value.nome+'</p> <small>Entrega: '+new Date(value.dataRecebimento).toLocaleDateString('pt-br')+' '+new Date(value.dataRecebimento).toLocaleTimeString('pt-br')+'</small> &#183 <small>Devolução: '+(value.dataDevolucao != null ? new Date(value.dataDevolucao).toLocaleDateString('pt-br')+' '+new Date(value.dataDevolucao).toLocaleTimeString('pt-br') : '-')+'</small> </div>'); });
			});
			$('#modal-historico').modal('show');	
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
					$.get("{{url('app/gti/equipamentos/remover')}}/"+data.id, function(data){
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

		// Editando as informações
		$('#modal-alterar #formAlterar').on('submit', function(e){
			var table = $('#table').DataTable();
			e.preventDefault();
			$.ajax({
				url: "{{url('app/gti/equipamentos/alterarUsuario')}}/"+$('#modal-alterar .identificador').val(),
				type: 'POST',
				data: $('#modal-alterar #formAlterar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-alterar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						$('#modal-alterar #formAlterar').each (function(){
							this.reset();
						});
						table.ajax.reload();
						$('input').removeClass('border-bottom border-danger');
						$('.carregamento').html('');
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('#modal-alterar').modal('hide');
					}, 1000);
				}, error: function (data) {
					setTimeout(function(){
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('.carregamento').html('');
						if(!data.responseJSON){
							console.log(data.responseText);
							$('#modal-alterar #err').html(data.responseText);
						}else{
							$('#modal-alterar #err').html('');
							$('input').removeClass('border-bottom border-danger');
							$.each(data.responseJSON.errors, function(key, value){
								$('#modal-alterar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
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