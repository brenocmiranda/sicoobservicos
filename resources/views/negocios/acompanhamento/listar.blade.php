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
	@if(Session::has('error'))
      <div class="col-12 rounded alert alert-{{ Session::get('error')['class'] }}">
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
        {{ Session::get('error')['mensagem'] }}
      </div>
    @endif
	<div class="card">
		<div class="card-body">
			<div class="col-12 mb-3">
				<table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table">
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
					order: [ 3, "asc" ],
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
			}
		});
	});
</script>
@endsection