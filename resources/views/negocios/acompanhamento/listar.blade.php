@section('title')
Acompanhamento
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Acompanhamento</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Negócios</a></li>
				<li class="active">Acompanhamento</li>
			</ol>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<div class="col-12 mb-3">
				<table class="table table-responsive table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table" style="overflow-y: auto;">
					<thead>
						<th> Documento </th>
						<th> Nome </th>
						<th> Atendente </th>
						<th> Data </th>
						<th> Status </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('negocios.acompanhamento.alterar')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Criando a datatables
		$.ajax({
			url: '{{ route("listar.acompanhamento.negocios") }}',
			type: 'GET',
			success: function(table){
				// Carregamento de dados
				$('#table').DataTable({
					pageLength: 100,
					paging: true,
					select: true,
					searching: true,
					deferRender: true,
					data: table,
					"columns": [ 
					{ "data": "documento1", "name":"documento1"},
					{ "data": "nome", "name":"nome"},
					{ "data": "colaborador", "name":"colaborador"},
					{ "data": "data", "name":"data"},
					{ "data": "status1", "name":"status1"},
					{ "data": "acoes","name":"acoes"},
					]
				});	

				// Devolução do associado para análise
				$('#table tbody').on('click', 'a#devolver', function(e){
					console.log('teste');
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					var url = "{{url('app/negocios/carteira/devolver')}}/"+data.cli_id_associado;
					swal({
						title: "Tem certeza que deseja devolver para análise?",
						icon: "warning",
						buttons: ["Cancelar", "Devolver"],
					})
					.then((willDelete) => {
						if (willDelete) {
							$.get(url, function(data){
								if(data.success == true){
									swal("Informações alteradas com sucesso!", {
										icon: "success",
									});
									table.row('tr.selected').remove().draw();
								}else{
									swal("Não foi possível alterar essas informações, tente novamente!", {
										icon: "error",
									});
								}
							});
						} else {
							swal.close();
						}
					});
				});

				// Remover o associado da análise
				$('#table tbody').on('click', 'a#alterar', function(e) {
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					$('#modal-alterar #id_carteira').val(data.id);
					$('#modal-alterar .nome').html(data.nome);
					$('#modal-alterar').modal('show');
				});

				// Enviar processo de remoção
				$('#modal-alterar #formAlterar').on('submit', function(e){
					var table = $('#table').DataTable();
					e.preventDefault();
					$.ajax({
						url: "{{url('app/negocios/acompanhamento/alterar')}}/"+$('#modal-alterar #id_carteira').val(),
						type: 'POST',
						data: new FormData(this),
						processData: false,
				        contentType: false,
						beforeSend: function(){
							$('.modal-body, .modal-footer').addClass('d-none');
							$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
							$('#modal-alterar #err').html('');
						},
						success: function(data){
							$('.modal-body, .modal-footer').addClass('d-none');
							$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
							setTimeout(function(){
								location.reload();
							}, 1200);
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
			}
		});
	});
</script>
@endsection