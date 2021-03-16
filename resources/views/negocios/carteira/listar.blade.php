@section('title')
Carteira de atendimento
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Carteira de atendimento</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Negócios</a></li>
				<li class="active">Carteira de atendimento</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 mb-3">
				<table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table">
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
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Criando a datatables
		$.ajax({
			url: '{{ route("listar.carteira.negocios") }}',
			type: 'GET',
			success: function(table){
				// Carregamento de dados
				$('#table').DataTable({
					order: [ 0, "asc" ],
					pageLength: 100,
					paging: true,
					select: true,
					searching: true,
					deferRender: true,
					data: table,
					"columns": [ 
					{ "data": "documento1", "name":"documento1"},
					{ "data": "nome", "name":"nome"},
					{ "data": "nome_gerente", "name":"nome_gerente"},
					{ "data": "PA", "name":"PA"},
					{ "data": "status1", "name":"status1"},
					{ "data": "acoes","name":"acoes"},
					]
				});	
			}
		});

		// Devolução do associado para análise
		$('#table tbody').on('click', 'button#devolver', function(e){
			// Alterando o estado
			var table = $('#table').DataTable();
			table.$('tr.selected').removeClass('selected');
			$(this).parents('tr').addClass('selected');
			$(this).parent('tr').addClass('selected');
			var data = table.row('tr.selected').data();
			//var url = "{{url('app/configuracoes/administrativo/funcoes/alterar')}}/"+data.id;
			swal({
				title: "Tem certeza que deseja alterar o estado?",
				icon: "warning",
				buttons: ["Cancelar", "Alterar"],
			})
			.then((willDelete) => {
				if (willDelete) {
					$.get(url, function(data){
						if(data.success == true){
							swal("Informações alteradas com sucesso!", {
								icon: "success",
							});
							table.ajax.reload();
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
	});
</script>
@endsection