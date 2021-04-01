@section('title')
Análise econômica
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Análise econômica</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Negócios</a></li>
				<li class="active">Análise econômica</li>
			</ol>
		</div>
	</div>
	
	<div class="card">
		<div class="card-body">
			<div class="col-12 mb-3">
				<table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table" style="overflow-y: auto; display: none !important;">
					<thead>
						<th> Documento </th>
						<th> Nome </th>
						<th> Gerente </th>
						<th> PA </th>
						<th> Status </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
			<div class="my-3 col-12 text-center processing-in">
				<div class="spinner-border text-primary mb-3" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
				<h6>Carregando as informações...</h6>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('negocios.analise.remover')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function(){
		// Criando a datatables
		$.ajax({
			url: '{{ route("listar.analise.negocios") }}',
			type: 'GET',
			success: function(table){
				// Carregamento de dados
				$('.processing-in').addClass('d-none');
				$('.processing-off').fadeIn();
				$('#table').fadeIn('fast');
				$('#table').DataTable({
					deferRender: true,
					order: [ 1, "asc" ],
					paginate: true,
					pageLength: 100,
					select: true,
					searching: true,
					destroy: true,
					data: table,
					"columns": [ 
					{ "data": "documento", "name":"documento"},
					{ "data": "nome", "name":"nome"},
					{ "data": "gerente", "name":"gerente"},
					{ "data": "PA", "name":"PA"},
					{ "data": "status", "name":"status"},
					{ "data": "acoes","name":"acoes"},
					]
				});	

				// Encaminhar do associado para análise
				$('#table tbody').on('click', 'a#encaminhar', function(e) {
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					var url = "{{url('app/negocios/analise/encaminhar')}}/"+data.cli_id_associado;
					swal({
						title: "Tem certeza que encaminhar para tratamento?",
						icon: "warning",
						buttons: ["Cancelar", "Encaminhar"],
					})
					.then((willDelete) => {
						if (willDelete) {
							$.get(url, function(data){
								if(data.success == true){
									swal("Informações enviar com sucesso!", {
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
				$('#table tbody').on('click', 'a#remover', function(e) {
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					$('#modal-remover #cli_id_associado').val(data.cli_id_associado);
					$('#modal-remover .nome').html(data.nome);
					$('#modal-remover').modal('show');
				});

				// Enviar processo de remoção
				$('#modal-remover #formRemover').on('submit', function(e){
					e.preventDefault();
					$.ajax({
						url: "{{url('app/negocios/analise/remover')}}/"+$('#modal-remover #cli_id_associado').val(),
						type: 'POST',
						data: new FormData(this),
						processData: false,
				        contentType: false,
						beforeSend: function(){
							$('.modal-body, .modal-footer').addClass('d-none');
							$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
							$('#modal-remover #err').html('');
						},
						success: function(data){
							$('.modal-body, .modal-footer').addClass('d-none');
							$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
							var table = $('#table').DataTable();
							table.row('tr.selected').remove().draw();
							setTimeout(function(){
								$('#modal-remover').modal('hide');
							}, 2000);
						}, error: function (data) {
							setTimeout(function(){
								$('.modal-body, .modal-footer').removeClass('d-none');
								$('.carregamento').html('');
								if(!data.responseJSON){
									console.log(data.responseText);
									$('#modal-remover #err').html(data.responseText);
								}else{
									$('#modal-remover #err').html('');
									$('input').removeClass('border-bottom border-danger');
									$.each(data.responseJSON.errors, function(key, value){
										$('#modal-remover #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
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