@section('title')
Armário
@endsection

@section('caminho')
<small class="section-header-breadcrumb d-flex">
	<div class="breadcrumb-item">
		<a href="javascript:void(0)" class="p-0 d-block">Crédito</a>
	</div>
	<div class="breadcrumb-item d-flex p-0">
		<a href="{{ route('exibir.disposicao.credito') }}" class="p-0 d-block">Disposição</a>
	</div>
	<div class="breadcrumb-item d-flex active p-0">
		<a href="{{ route('exibir.gaveta.credito', $armarios[0]->id_armario) }}" class="p-0 d-block text-primary">{{$armarios[0]->referencia}}</a>
	</div>
</small>
@endsection

@extends('layouts.structure')

@section('content')
<div class="content-wrapper">
	<div class="card">
		<div class="card-body">
			<div class="h-100 d-flex">
				<div class="col-lg-12 d-flex">
					<div>
						<h3>Contratos do armário</h3>
						<h6>Estão listados a abaixo todos os contratos relacionados ao armário {{$armarios[0]->referencia}}.</h6>
					</div>
					<div class="ml-auto">
						<button class="btn btn-outline-success px-2 d-flex align-items-center" id="adicionar" name="adicionar" title="Adicionar novo contrato" data-toggle="modal" data-target="#modal-adicionar"><i class="m-0 pr-1 mdi mdi-plus"></i> Novo contrato </button>
					</div>
				</div>
			</div>
			<hr>
			<div class="mb-3 col-12">
				<table class="table table-striped text-center" id="table">
					<thead>
						<th> Nº contrato </th>
						<th> Associado </th>
						<th> Produto </th>
						<th> Valor do contrato </th>
						<th> Localização </th>
						<th> Ações </th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

@section('modal')
	@include('credito.contratos.adicionar')
	@include('credito.contratos.editar')
	@include('credito.contratos.alterar')
	@include('credito.contratos.detalhes')
@endsection

@section('suporte')
<script type="text/javascript">
	function excluirAvalista(id){
		$('#avalista'+id).remove();
		return true;
	}

	function excluirGarantia(id){
		$('#garantia'+id).remove();
		return true;
	}

	$(document).ready( function(){
		var contador = 1;

		// Carregamento de pagina
		$('#modal-processamento').modal('show');
		$('#modal-processamento').removeClass('fade');

		// Formatação de campos
		$('select').formSelect();
		$('.nivel_risco').mask('SSSS');
		$('.quantidade_parcelas').mask('000', {reverse: true});
		$('.taxa_operacao').mask('000,00', {reverse: true});
		$('.taxa_mora').mask('000,00', {reverse: true});
		$('.taxa_multa').mask('000,00', {reverse: true});
		$('.money').mask('000.000.000.000.000,00', {reverse: true});
		
		// Cancelar fechamento de modal
		$('input').keypress(function(e) {
			var code = null;
			code = (e.keyCode ? e.keyCode : e.which);                
			return (code == 13) ? false : true;
		});

		// Retornando dados do associado responsável pelo contrato
		$(".cli_id_associado").autocomplete({
			source: function(request, response){
				$.ajax({
					url: "{{ route('listar.associado.credito') }}",
					data: {	term : request.term	},
					dataType: "json",
					success: function(data4){
						var resp = $.map(data4, function(obj){
							return obj.nome +" : "+ obj.documento;
						}); 
						response(resp);
					}})},
				minLength: 1
			});
		$(".cli_id_associado").autocomplete({
			change: function( event, ui ) {
				if(ui.item == null){
					$(this).val('');
				}
			}
		});

		// Inserindo novos avalistas
		$(".btnAval").on('click', function(e){
			e.preventDefault();
			// Insere um novo avalista
			$(".adicionarAvalista").append('<div class="form-group border rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"> <input type="text" name="avalista[]" class="avalista form-control mr-2"> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirAvalista('+contador+');">Remover</a> </div> </div> </div>');
			contador++; 
			// Autocomplete de novos avalistas
			$(".avalista").autocomplete({
				source: function(request, response){
					$.ajax({
						url: "{{ route('listar.associado.credito') }}",
						data: {	term : request.term	},
						dataType: "json",
						success: function(data4){
							var resp = $.map(data4, function(obj){
								return obj.nome +" : "+ obj.documento;
							}); 
							response(resp);
						}})},
					minLength: 1
				});
			$(".avalista").autocomplete({
				change: function( event, ui ) {
					if(ui.item == null){
						$(this).val('');
					}
				}
			});
		});

		// Inserindo novas garantias
		$(".btnGarantia").on('click', function(e){
			e.preventDefault();
			$(".adicionarGarantia").append('<div class="form-group border rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4"> <label class="col-form-label pb-0">Tipo</label> <input type="text" class="form-control" name="tipoGarantia[]"/> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control" name="descricaoGarantia[]"/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>'); 
			contador++;
		});

		// Limpando as informações dos modais
		$('#adicionar').on('click', function(){
			$('.modal form').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
			$('.modal #err').html('');
			$('#myTab li:first-child a').tab('show');
			$('.adicionarAvalista').html('');
			$('.adicionarGarantia').html('');
		});

		// Criando a datatables
		$.ajax({
			url: '{{ route("listar.gaveta.credito", $armarios[0]->id_armario)}}',
			type: 'GET',
			success: function(table){
				$('#table').DataTable({
					order: [ 1, "asc" ],
					paging: true,
					select: true,
					searching: true,
					deferRender: true,
					data: table,
					"columns": [ 
					{ "data": "num_contrato","name":"num_contrato"},
					{ "data": "nome", "name":"nome"},
					{ "data": "produto1.nome","name":"produto1.nome"},
					{ "data": "valor_contrato1","name":"valor_contrato1"},
					{ "data": "referencia","name":"referencia"},
					{ "data": "acoes","name":"acoes"},
					],
					"initComplete": processamento(),
				});

				// Selecionando linhas da tabela
				$('#table tbody').on('click', 'tr', function (){
					var table = $('#table').DataTable();
					if (!($(this).hasClass('selected'))) {
						table.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
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
					$('#myTab li:first-child a').tab('show');
					$('.adicionarAvalista').html('');
					$('.adicionarGarantia').html('');

					// Retornando as informações na tabela
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					$('.modal .cli_id_associado').val(data.nome+" : "+data.documento);
					$('.modal .num_contrato').val(data.num_contrato);
					$('.modal .produto').val(data.produto);
					$('.modal .modalidade').val(data.modalidade);
					$('.modal .data_operacao').val(data.data_operacao);
					$('.modal .data_vencimento').val(data.data_vencimento);
					$('.modal .valor_contrato').val(data.valor_contrato);
					$('.modal .cre_id_armario').val(data.cre_id_armario);
					$('.modal .finalidade').val(data.finalidade);
					$('.modal .nivel_risco').val(data.nivel_risco);
					$('.modal .quantidade_parcelas').val(data.quantidade_parcelas);
					$('.modal .taxa_operacao').val(data.taxa_operacao);
					$('.modal .taxa_mora').val(data.taxa_mora);
					$('.modal .taxa_multa').val(data.taxa_multa);
					$('.modal .observacao').val(data.observacao);
					if (data.renegociacao == 1){
						$('.modal .renegociacao1').attr('checked', 'checked');
					}else{
						$('.modal .renegociacao2').attr('checked', 'checked');
					}
					// Função para retorno das garantias
					$.get("../contratos/garantias/"+data.id_contrato, function(dataGarantias){
						// Retorno dos avalistas da operação
						for (var i = 0; i < dataGarantias[0].length; i++) {
							$(".adicionarAvalista").append('<div class="form-group border rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"> <input type="text" name="avalista[]" class="avalista form-control mr-2" value="'+dataGarantias[0][i].nome+" : "+dataGarantias[0][i].documento+'"> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirAvalista('+contador+');">Remover</a> </div> </div> </div>');
							contador++;
						}
						// Retorno das garantias da operação
						for (var i = 0; i < dataGarantias[1].length; i++) {
							$(".adicionarGarantia").append('<div class="form-group border rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4"> <label class="col-form-label pb-0">Tipo</label> <input type="text" class="form-control" name="tipoGarantia[]" value="'+dataGarantias[1][i].tipo+'"/> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control" name="descricaoGarantia[]" value="'+dataGarantias[1][i].descricao+'"/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>'); 
							contador++;
						}
						// Autocomplete de novos avalistas
						$(".avalista").autocomplete({
							source: function(request, response){
								$.ajax({
									url: "{{ route('listar.associado.credito') }}",
									data: {	term : request.term	},
									dataType: "json",
									success: function(data4){
										var resp = $.map(data4, function(obj){
											return obj.nome +" : "+ obj.documento;
										}); 
										response(resp);
									}})},
								minLength: 1
							});
						$(".avalista").autocomplete({
							change: function( event, ui ) {
								if(ui.item == null){
									$(this).val('');
								}
							}
						});
					});
					$('#modal-editar').modal('show');
				});

				// Alterar status
				$('#table tbody').on('click', 'button#alterar', function () {
					// Retornando as informações na tabela
					var table = $('#table').DataTable();
					table.$('tr.selected').removeClass('selected');
					$(this).parents('tr').addClass('selected');
					$(this).parent('tr').addClass('selected');
					var data = table.row('tr.selected').data();
					$('.modal .status').html(data.status);
					$('#modal-alterar').modal('show');	
				});

				// Detalhes das informações do contrato
				$('#table tbody').on('dblclick','tr', function (){
					// Limpando as informações dos modais
					$('.modal form').each (function(){
						this.reset();
						if ($(this).hasClass('border-bottom border-danger')){
							this.removeClass('border-bottom border-danger');
						}
					});
					$('.modal #err').html('');
					$('#myTab li:first-child a').tab('show');
					$('.adicionarAvalista').html('');
					$('.adicionarGarantia').html('');

					// Retornando as informações na tabela
					var table = $('#table').DataTable();
					var data = table.row(this).data();
					$(this).addClass('selected');
					$('.modal .cli_id_associado').val(data.nome+" : "+data.documento);
					$('.modal .num_contrato').val(data.num_contrato);
					$('.modal .produto').val(data.produto);
					$('.modal .modalidade').val(data.modalidade);
					$('.modal .data_operacao').val(data.data_operacao);
					$('.modal .data_vencimento').val(data.data_vencimento);
					$('.modal .valor_contrato').val(data.valor_contrato);
					$('.modal .cre_id_armario').val(data.cre_id_armario);
					$('.modal .finalidade').val(data.finalidade);
					$('.modal .nivel_risco').val(data.nivel_risco);
					$('.modal .quantidade_parcelas').val(data.quantidade_parcelas);
					$('.modal .taxa_operacao').val(data.taxa_operacao);
					$('.modal .taxa_mora').val(data.taxa_mora);
					$('.modal .taxa_multa').val(data.taxa_multa);
					$('.modal .observacao').val(data.observacao);
					if (data.renegociacao == 1){
						$('.modal .renegociacao1').attr('checked', 'checked');
					}else{
						$('.modal .renegociacao2').attr('checked', 'checked');
					}
					// Função para retorno das garantias
					$.get("../contratos/garantias/"+data.id_contrato, function(dataGarantias){
						// Retorno dos avalistas da operação
						for (var i = 0; i < dataGarantias[0].length; i++) {
							$(".adicionarAvalista").append('<div class="form-group border rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"> <input type="text" name="avalista[]" class="avalista form-control mr-2" value="'+dataGarantias[0][i].nome+" : "+dataGarantias[0][i].documento+'"> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirAvalista('+contador+');">Remover</a> </div> </div> </div>');
							contador++;
						}
						// Retorno das garantias da operação
						for (var i = 0; i < dataGarantias[1].length; i++) {
							$(".adicionarGarantia").append('<div class="form-group border rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4"> <label class="col-form-label pb-0">Tipo</label> <input type="text" class="form-control" name="tipoGarantia[]" value="'+dataGarantias[1][i].tipo+'"/> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control" name="descricaoGarantia[]" value="'+dataGarantias[1][i].descricao+'"/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>'); 
							contador++;
						}
						// Autocomplete de novos avalistas
						$(".avalista").autocomplete({
							source: function(request, response){
								$.ajax({
									url: "{{ route('listar.associado.credito') }}",
									data: {	term : request.term	},
									dataType: "json",
									success: function(data4){
										var resp = $.map(data4, function(obj){
											return obj.nome +" : "+ obj.documento;
										}); 
										response(resp);
									}})},
								minLength: 1
							});
						$(".avalista").autocomplete({
							change: function( event, ui ) {
								if(ui.item == null){
									$(this).val('');
								}
							}
						});
					});
					$('#modal-detalhes').modal('show');
				});
			}
		});

		// Adicionando os contratos
		$('#modal-adicionar #formAdicionar').on('submit', function(e){
			var table = $('#table').DataTable();
			$.ajax({
				url: '{{ route("adicionar.contratos.credito") }}',
				type: 'POST',
				data: $('#modal-adicionar #formAdicionar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
				},
				success: function(data){
					$('#err').html('');
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check-all" style="font-size:62px;"></i></div><p>Contrato adicionado com sucesso!</p></div>');
					setTimeout(function(){
						$('#modal-adicionar #formAdicionar').each(function(){
							this.reset();
						});
						table.row.add(data).draw(false);
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
			$(this).parents('tr').addClass('selected');
			var table = $('#table').DataTable();
			var data = table.row('tr.selected').data();
			$.ajax({
				url: '../contratos/editar/'+data.id_contrato,
				type: 'POST',
				data: $('#modal-editar #formEditar').serialize(),
				beforeSend: function(){
					$('#err').html('');
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check-all" style="font-size:62px;"></i></div><p>Informações alteradas com sucesso!</p></div>');
					setTimeout(function(){
						$('#modal-editar #formEditar').each (function(){
							this.reset();
						});
						table.row('tr.selected').remove().draw(false);
						table.row.add(data).draw(false);
						$('input').removeClass('border-bottom border-danger');
						$('.carregamento').html('');
						$('.modal-body, .modal-footer').removeClass('d-none');
						$(".modal-backdrop").remove();
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

		// Alterando os status
		$('#modal-alterar #formAlterar').on('submit', function(e){
			var table = $('#table').DataTable();
			var data = table.row('tr.selected').data();
			e.preventDefault();
			$.ajax({
				url: '../contratos/alterar/'+data.id_contrato,
				type: 'POST',
				data: $('#modal-alterar #formAlterar').serialize(),
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
					$('#modal-alterar #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check-all" style="font-size:62px;"></i></div><p>Status alterado com sucesso!</p></div>');
					setTimeout(function(){
						$('#modal-alterar #formAlterar').each (function(){
							this.reset();
						});
						if(data.status == 'vigentes'){
							table.row('tr.selected').remove().draw(false);
							table.row.add(data).draw(false);
						}else{
							table.row('tr.selected').remove().draw(false);
						}
						$('input').removeClass('border-bottom border-danger');
						$('.carregamento').html('');
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('#modal-alterar').modal('hide');
					}, 2000);
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
								$('#modal-alterar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
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

@endsection