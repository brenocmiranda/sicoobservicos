@section('title')
Garantias fiduciárias
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Garantias Fiduciárias</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.credito')}}">Crédito</a></li>
				<li><a class="active">Garantias</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="h-100 row col">
				<div class="col-lg-12 position-absolute">
					<div class="row mx-auto">
						@if(Auth::user()->RelationFuncao->gerenciar_credito == 1)
						<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo contrato" data-toggle="modal" data-target="#modal-adicionar" style="z-index: 10">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Nova garantia</span> 
						</button>
						@endif
					</div>
				</div>
			</div>
			<div class="mb-3 mx-3">
				<table class="table text-center color-table muted-table rounded" id="table">
					<thead>
						<th> Nº contrato </th>
						<th> Associado </th>
						<th> Produto </th>
						<th> Tipo </th>
						<th> Descrição </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('credito.garantias.adicionar')
	@include('credito.garantias.editar')
	@include('credito.garantias.detalhes')
@endsection

@section('suporte')
<script type="text/javascript">
	function excluirGarantia(id){
		$('#garantia'+id).remove();
		return true;
	}

	$(document).ready( function (){
		var	contador = 1;

		// Limpando as informações dos modais
		$('#adicionar').on('click', function(){
			$('.modal form').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('.modal #err').html('');
			$('.adicionarGarantia').html('');
		});

		// Criando a datatables
		$('#table').DataTable({
			deferRender: true,
			order: [1, 'asc'],
			paginate: true,
			select: true,
			searching: true,
			destroy: true,
			ajax: '{{ route("listar.garantias.fiduciaria.credito") }}',
			serverSide: true,
			"columns": [ 
			{ "data": "contrato1","name":"contrato1"},
			{ "data": "nome1", "name":"nome1"},
			{ "data": "produto1", "name":"produto1"},
			{ "data": "tipo","name":"tipo"},
			{ "data": "descricao","name":"descricao", "width": "35%"},
			{ "data": "acoes","name":"acoes", "width": "10%"}
			]
		});

		// Selecionando linhas da tabela
		$('#table tbody').on('click', 'tr', function (){
			var table = $('#table').DataTable();
			if (!($(this).hasClass('active'))) {
				table.$('tr.active').removeClass('active');
				$(this).addClass('active');
			}
		});

		// Editando informações 
		$('#table tbody').on('click', 'button#editar', function (){
			// Limpando as informações dos modais
			$('.modal form').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('.modal #err').html('');
			$('.adicionarGarantia').html('');
			// Retornando as informações na tabela
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			$('.modal .contrato').val(data.cre_id_contrato);
			// Função para retorno das garantias
			$.get("{{url('app/credito/garantias/detalhes')}}/"+data.cre_id_contrato, function(dataGarantias){
				// Retorno dos avalistas da operação
				for (var i = 0; i < dataGarantias[1].length; i++) {
					$(".adicionarGarantia").append('<div class="form-group rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4 pl-0"> <label class="col-form-label pb-0">Tipo</label> <select class="form-control form-control-line" name="tipoGarantia" required> <option value=""> Selecione </option> <option value="Cessão de direitos creditórios" '+(dataGarantias[1][i].tipo == 'Cessão de direitos creditórios' ? 'selected' : '')+'>Cessão de direitos creditórios</option> <option value="Equipamento" '+(dataGarantias[1][i].tipo == 'Equipamento' ? 'selected' : '')+'>Equipamento</option> <option value="Imóvel" '+(dataGarantias[1][i].tipo == 'Imóvel' ? 'selected' : '')+'>Imóvel</option> <option value="Terreno" '+(dataGarantias[1][i].tipo == 'Terreno' ? 'selected' : '')+'>Terreno</option> <option value="Usina" '+(dataGarantias[1][i].tipo == 'Usina' ? 'selected' : '')+'>Usina</option> <option value="Veículo" '+(dataGarantias[1][i].tipo == 'Veículo' ? 'selected' : '')+'>Veículo</option> <option value="Outros" '+(dataGarantias[1][i].tipo == 'Outros' ? 'selected' : '')+'>Outros</option> </select> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control form-control-line" name="descricaoGarantia" value="'+dataGarantias[1][i].descricao+'" required/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>');
					contador++;
				}
			});
			$('#modal-editar').modal('show');
		});

		// Detalhes das informações do contrato
		$('#table tbody').on('dblclick', 'tr', function (){
			// Limpando as informações dos modais
			$('.modal form').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('.modal #err').html('');
			$('.adicionarGarantia').html('');
			// Retornando as informações na tabela
			var table = $('#table').DataTable();
			var data = table.row(this).data();
			$(this).addClass('active');
			$('.modal .contrato').val(data.cre_id_contrato);
			// Função para retorno das garantias
			$.get("{{url('app/credito/garantias/detalhes')}}/fidejussoria/"+data.id, function(dataGarantias){
				// Retorno dos avalistas da operação
				for (var i = 0; i < dataGarantias[1].length; i++) {
					$(".adicionarGarantia").append('<div class="form-group rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4 pl-0"> <label class="col-form-label pb-0">Tipo</label> <select class="form-control form-control-line" name="tipoGarantia" required> <option value=""> Selecione </option> <option value="Cessão de direitos creditórios" '+(dataGarantias[1][i].tipo == 'Cessão de direitos creditórios' ? 'selected' : '')+'>Cessão de direitos creditórios</option> <option value="Equipamento" '+(dataGarantias[1][i].tipo == 'Equipamento' ? 'selected' : '')+'>Equipamento</option> <option value="Imóvel" '+(dataGarantias[1][i].tipo == 'Imóvel' ? 'selected' : '')+'>Imóvel</option> <option value="Terreno" '+(dataGarantias[1][i].tipo == 'Terreno' ? 'selected' : '')+'>Terreno</option> <option value="Usina" '+(dataGarantias[1][i].tipo == 'Usina' ? 'selected' : '')+'>Usina</option> <option value="Veículo" '+(dataGarantias[1][i].tipo == 'Veículo' ? 'selected' : '')+'>Veículo</option> <option value="Outros" '+(dataGarantias[1][i].tipo == 'Outros' ? 'selected' : '')+'>Outros</option> </select> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control form-control-line" name="descricaoGarantia" value="'+dataGarantias[1][i].descricao+'" required/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>');
					contador++;
				}
			});
			$('#modal-detalhes').modal('show');
		});


		// Inserindo novas garantias
		$(".btnGarantia").on('click', function(e){
			e.preventDefault();
			$(".adicionarGarantia").append('<div class="form-group rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4 pl-0"> <label class="col-form-label pb-0">Tipo</label> <select class="form-control form-control-line" name="tipoGarantia[]" required> <option value=""> Selecione </option> <option value="Cessão de direitos creditórios">Cessão de direitos creditórios</option> <option value="Equipamento">Equipamento</option> <option value="Imóvel">Imóvel</option> <option value="Terreno">Terreno</option> <option value="Usina">Usina</option> <option value="Veículo">Veículo</option> <option value="Outros">Outros</option> </select> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control form-control-line" name="descricaoGarantia[]" required/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>');
			contador++;
		});

		$('#table tbody').on('click', 'button#alterar', function () {
			// Alterando o estado
			var table = $('#table').DataTable();
			table.$('tr.active').removeClass('active');
			$(this).parents('tr').addClass('active');
			$(this).parent('tr').addClass('active');
			var data = table.row('tr.active').data();
			var url = "{{url('app/credito/garantias/alterar')}}/fiduciaria/"+data.id;
			swal({
				title: "Tem certeza que deseja remover essa garantia?",
				icon: "error",
				buttons: ["Cancelar", "Remover"],
				dangerMode: true,
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

		// Adicionando garantitas aos contratos
		$('#modal-adicionar #formAdicionar').on('submit', function(e){
			var table = $('#table').DataTable();
			$.ajax({
				url: '{{ route("adicionar.garantias.credito") }}',
				type: 'POST',
				data: $('#modal-adicionar #formAdicionar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
				},
				success: function(data){
					$('#err').html('');
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						$('#modal-adicionar #formAdicionar').each(function(){
							this.reset();
						});
						table.ajax.reload();
						$('input').removeClass('border-bottom border-danger');
						$('.carregamento').html('');
						$('.modal-body, .modal-footer').removeClass('d-none');
						$(".modal-backdrop").remove();
						$('#modal-adicionar').modal('hide');
					}, 1200);
				}, error: function (data) {
					setTimeout(function(){
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('.carregamento').html('');
						if(!data.responseJSON){
							console.log(data.responseText);
							$('#modal-adicionar #err').html(data.responseText);
						}else{
							$('#modal-adicionar #err').html('');
							$('input').removeClass('border-bottom border-danger');
							$.each(data.responseJSON.errors, function(key, value){
								$('#modal-adicionar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
								$('input[name="'+key+'"]').addClass('border-bottom border-danger');
							});
						}
					}, 1500);
				}
			});
			e.preventDefault();
		});

		// Editando as informações do contrato
		$('#modal-editar #formEditar').on('submit', function(e){
			$(this).parents('tr').addClass('active');
			var table = $('#table').DataTable();
			var data = table.row('tr.active').data();
			$.ajax({
				url: "{{url('app/credito/garantias/editar')}}/fiduciaria/"+data.id,
				type: 'POST',
				data: $('#modal-editar #formEditar').serialize(),
				beforeSend: function(){
					$('#err').html('');
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						$('#modal-editar #formEditar').each (function(){
							this.reset();
						});
						table.ajax.reload();
						$('input').removeClass('border-bottom border-danger');
						$('.carregamento').html('');
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('#modal-editar').modal('hide');
					}, 1500);
				}, error: function (data) {
					setTimeout(function(){
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('.carregamento').html('');
						if(!data.responseJSON){
							console.log(data.responseText);
							$('#modal-editar #err').html(data.responseText);
						}else{
							$('#modal-editar #err').html('');
							$('input').removeClass('border-bottom border-danger');
							$.each(data.responseJSON.errors, function(key, value){
								$('#modal-editar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
								$('input[name="'+key+'"]').addClass('border-bottom border-danger');
							});
						}
					}, 1500);
				}
			});
			e.preventDefault();
		});
		
	});
</script>
@endsection
