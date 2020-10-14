@section('title')
Contratos
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Contratos de crédito</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.credito')}}">Crédito</a></li>
				<li><a class="active">Contratos</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			
			<div class="row justify-content-center">
				<div class="col-12 row">
					<div class="col-12 text-center">
						<h5>Seus estados disponíveis</h5>
						<hr class="col-6 mt-1">
					</div>
					<div class="col-12 row position-absolute">
						<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo contrato" data-toggle="modal" data-target="#modal-adicionar">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Novo contrato</span>
						</button>
					</div>
				</div>
				<div class="col-3 border rounded shadow-sm m-3 p-3">
					<a href="{{ route('exibir.vigente.credito') }}" class="button-size">
						<div class="px-4 m-auto text-center">
							<i class="mdi mdi-package-variant mdi-36px"></i>
						</div> 
						<div class="m-auto text-center">
							<h5 class="mb-3"> Contratos Vigentes </h5>
						</div>
					</a>
				</div>
				<div class="col-3 border rounded shadow-sm m-3 p-3">
					<a href="{{ route('exibir.quitado.credito') }}" class="button-size">
						<div class="px-4 m-auto text-center">
							<i class="mdi mdi-package-variant-closed mdi-36px"></i>
						</div>
						<div class="m-auto text-center">
							<h5 class="mb-3"> Contratos Quitados </h5>
						</div>
					</a>
				</div>
				<div class="col-3 border rounded shadow-sm m-3 p-3">
					<a href="{{ route('exibir.prejuizo.credito') }}" class="button-size">
						<div class="px-4 m-auto text-center">
							<i class="mdi mdi-minus-circle-outline mdi-36px"></i>
						</div>
						<div class="m-auto text-center">
							<h5 class="mb-3"> Contratos em Prejuízo </h5>
						</div>
					</a>
				</div>
				<div class="col-12 mb-4">
					<div class="p-0 input-group row">
						<div class="col-12 text-center my-4">
							<label>Você também pode localizar seus contratos pelo nome do associado, número do contrato, modalidade ou a sua situação.</label>
						</div>
						<div class="col-8 px-2 mx-auto">
							<form id="formPesquisar" enctype="multipart/form-data" autocomplete="off">
								@csrf
								<input type="search" class="form-control" placeholder="Buscar..." aria-controls="table" name="pesquisar" id="pesquisar" style="border-radius: 20px">
							</form>
						</div>
					</div>
				</div>			
				<div class="m-4 col-12 processing-off d-none">
					<table class="table text-center color-table muted-table rounded" id="table">
						<thead>
							<th> Nº contrato </th>
							<th> Associado </th>
							<th> Produto </th>
							<th> Valor do contrato </th>
							<th> Localização </th>
							<th> Status </th>
							<th> Ações </th>
						</thead>
					</table>
				</div>
				<div class="col-12 text-center processing-in d-none">
					<div class="spinner-border text-primary my-3" role="status">
					  <span class="sr-only">Loading...</span>
					</div>
					<h6>Pesquisando as informações...</h6>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

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

		// Formatação de campos
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
			$(".adicionarAvalista").append('<div class="form-group rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"> <input type="text" name="avalista[]" class="avalista form-control form-control-line mr-2" required> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirAvalista('+contador+');">Remover</a> </div> </div> </div>');
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
			$(".adicionarGarantia").append('<div class="form-group rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4"> <label class="col-form-label pb-0">Tipo</label> <select class="form-control form-control-line" name="tipoGarantia[]" required> <option value=""> Selecione </option> <option value="Cessão de direitos creditórios">Cessão de direitos creditórios</option> <option value="Equipamento">Equipamento</option> <option value="Imóvel">Imóvel</option> <option value="Terreno">Terreno</option> <option value="Usina">Usina</option> <option value="Veículo">Veículo</option> <option value="Outros">Outros</option> </select> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control form-control-line" name="descricaoGarantia[]" required/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>');
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

		// Campo de pesquisa e criação da datatables
		$('#pesquisar').on('keyup', function(){
			if(this.value != ""){
				$.ajax({
					url: "{{ route('pesquisar.contratos.credito') }}",
					type: 'POST',
					data: $('#formPesquisar').serialize(),
					beforeSend: function(){
						$('.processing-in').removeClass('d-none');
						$('.processing-off').addClass('d-none');
						$('.button-size').fadeIn("slow").addClass('d-flex');
						$('.button-size').fadeIn("slow").parent().removeClass('p-3');
					},
					success: function(result){
						$('#table').DataTable({
							order: [ 1, "asc" ],
							processing: true,
							paging: false,
							select: true,
							destroy: true,
							searching: false,
							deferRender: true,
							info: false,
							data: result,
							"columns": [ 
							{ "data": "num_contrato","name":"num_contrato", "width": "15%"},
							{ "data": "associado.nome", "name":"associado.nome", "width": "20%"},
							{ "data": "produto.nome","name":"produto.nome", "width": "15%"},
							{ "data": "valor_contrato1","name":"valor_contrato1", "width": "15%"},
							{ "data": "armario.referencia","name":"armario.referencia", "width": "15%"},
							{ "data": "status1","name":"status1", "width": "10%"},
							{ "data": "acoes","name":"acoes", "width": "15%"},
							],
						});

					// Carregamento de dados
					$('.processing-in').addClass('d-none');
					$('.processing-off').removeClass('d-none');

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
						$('#myTab li:first-child a').tab('show');
						$('.adicionarAvalista').html('');
						$('.adicionarGarantia').html('');

						// Retornando as informações na tabela
						var table = $('#table').DataTable();
						table.$('tr.active').removeClass('active');
						$(this).parents('tr').addClass('active');
						$(this).parent('tr').addClass('active');
						var data = table.row('tr.active').data();
						$('.modal .num_contrato').val(data.num_contrato);
						$('.modal .cli_id_associado').val(data.associado.nome+" : "+data.associado.documento);
						$('.modal .cre_id_produtos').val(data.produto.id);
						$('.modal .cre_id_modalidades').val(data.modalidade.id);
						$('.modal .data_operacao').val(data.data_operacao);
						$('.modal .data_vencimento').val(data.data_vencimento);
						$('.modal .valor_contrato').val(data.valor_contrato);
						$('.modal .cre_id_armarios').val(data.cre_id_armarios);
						$('.modal .cre_id_finalidades').val((data.finalidade ? data.finalidade.id : null));
						$('.modal .nivel_risco').val(data.nivel_risco);
						$('.modal .qtd_parcelas').val(data.qtd_parcelas);
						$('.modal .qtd_parcelas_pagas').val(data.qtd_parcelas_pagas);
						$('.modal .taxa_operacao').val(data.taxa_operacao);
						$('.modal .taxa_mora').val(data.taxa_mora);
						$('.modal .taxa_multa').val(data.taxa_multa);
						$('.modal .observacoes').val(data.observacoes);
						$('.modal .status').val(data.status);
						if (data.renegociacao == 1){
							$('.modal .renegociacao1').attr('checked', 'checked');
							$('.modal .renegociacao_contrato').removeAttr('disabled');
							$('.modal .renegociacao_contrato').val(data.renegociacao_contrato);
						}else{
							$('.modal .renegociacao2').attr('checked', 'checked');
						}
						// Função para retorno das garantias
						$.get("contratos/garantias/"+data.id, function(dataGarantias){
							// Retorno dos avalistas da operação
							for (var i = 0; i < dataGarantias[0].length; i++) {
								$(".adicionarAvalista").append('<div class="form-group rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"> <input type="text" name="avalista[]" class="avalista form-control form-control-line mr-2" value="'+dataGarantias[0][i].nome+" : "+dataGarantias[0][i].documento+'" required> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirAvalista('+contador+');">Remover</a> </div> </div> </div>');
								contador++;
							}
							// Retorno das garantias da operação
							for (var i = 0; i < dataGarantias[1].length; i++) {
								$(".adicionarGarantia").append('<div class="form-group rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4"> <label class="col-form-label pb-0">Tipo</label> <select class="form-control form-control-line" name="tipoGarantia[]" required> <option value=""> Selecione </option> <option value="Cessão de direitos creditórios" '+(dataGarantias[1][i].tipo == 'Cessão de direitos creditórios' ? 'selected' : '')+'>Cessão de direitos creditórios</option> <option value="Equipamento" '+(dataGarantias[1][i].tipo == 'Equipamento' ? 'selected' : '')+'>Equipamento</option> <option value="Imóvel" '+(dataGarantias[1][i].tipo == 'Imóvel' ? 'selected' : '')+'>Imóvel</option> <option value="Terreno" '+(dataGarantias[1][i].tipo == 'Terreno' ? 'selected' : '')+'>Terreno</option> <option value="Usina" '+(dataGarantias[1][i].tipo == 'Usina' ? 'selected' : '')+'>Usina</option> <option value="Veículo" '+(dataGarantias[1][i].tipo == 'Veículo' ? 'selected' : '')+'>Veículo</option> <option value="Outros" '+(dataGarantias[1][i].tipo == 'Outros' ? 'selected' : '')+'>Outros</option> </select> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control form-control-line" name="descricaoGarantia[]" value="'+dataGarantias[1][i].descricao+'" required/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');">Remover</a> </div> </div>');
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
					$('#table tbody').on('click', 'button#alterar', function (){
						// Retornando as informações na tabela
						var table = $('#table').DataTable();
						table.$('tr.active').removeClass('active');
						$(this).parents('tr').addClass('active');
						$(this).parent('tr').addClass('active');
						var data = table.row('tr.active').data();
						$('.modal .status').html(data.status);
						$('#modal-alterar').modal('show');	
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
						$('#myTab li:first-child a').tab('show');
						$('.adicionarAvalista').html('');
						$('.adicionarGarantia').html('');

						// Retornando as informações na tabela
						var table = $('#table').DataTable();
						var data = table.row(this).data();
						$(this).addClass('active');
						$('.modal .num_contrato').val(data.num_contrato);
						$('.modal .cli_id_associado').val(data.associado.nome+" : "+data.associado.documento);
						$('.modal .cre_id_produtos').val(data.produto.id);
						$('.modal .cre_id_modalidades').val(data.modalidade.id);
						$('.modal .data_operacao').val(data.data_operacao);
						$('.modal .data_vencimento').val(data.data_vencimento);
						$('.modal .valor_contrato').val(data.valor_contrato);
						$('.modal .cre_id_armarios').val(data.cre_id_armarios);
						$('.modal .cre_id_finalidades').val((data.finalidade ? data.finalidade.id : null));
						$('.modal .nivel_risco').val(data.nivel_risco);
						$('.modal .qtd_parcelas').val(data.qtd_parcelas);
						$('.modal .qtd_parcelas_pagas').val(data.qtd_parcelas_pagas);
						$('.modal .taxa_operacao').val(data.taxa_operacao);
						$('.modal .taxa_mora').val(data.taxa_mora);
						$('.modal .taxa_multa').val(data.taxa_multa);
						$('.modal .observacoes').val(data.observacoes);
						$('.modal .status').val(data.status);
						if (data.renegociacao == 1){
							$('.modal .renegociacao1').attr('checked', 'checked');
							$('.modal .renegociacao_contrato').val(data.renegociacao_contrato);
						}else{
							$('.modal .renegociacao2').attr('checked', 'checked');
						}
						// Função para retorno das garantias
						$.get("contratos/garantias/"+data.id, function(dataGarantias){
							// Retorno dos avalistas da operação
							for (var i = 0; i < dataGarantias[0].length; i++) {
								$(".adicionarAvalista").append('<div class="form-group rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"> <input type="text" name="avalista[]" class="avalista form-control form-control-line mr-2" value="'+dataGarantias[0][i].nome+" : "+dataGarantias[0][i].documento+'" disabled> </div> </div> </div>');
								contador++;
							}
							// Retorno das garantias da operação
							for (var i = 0; i < dataGarantias[1].length; i++) {
									$(".adicionarGarantia").append('<div class="form-group rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4"> <label class="col-form-label pb-0">Tipo</label> <select class="form-control form-control-line" name="tipoGarantia[]" disabled> <option value=""> Selecione </option> <option value="Cessão de direitos creditórios" '+(dataGarantias[1][i].tipo == 'Cessão de direitos creditórios' ? 'selected' : '')+'>Cessão de direitos creditórios</option> <option value="Equipamento" '+(dataGarantias[1][i].tipo == 'Equipamento' ? 'selected' : '')+'>Equipamento</option> <option value="Imóvel" '+(dataGarantias[1][i].tipo == 'Imóvel' ? 'selected' : '')+'>Imóvel</option> <option value="Terreno" '+(dataGarantias[1][i].tipo == 'Terreno' ? 'selected' : '')+'>Terreno</option> <option value="Usina" '+(dataGarantias[1][i].tipo == 'Usina' ? 'selected' : '')+'>Usina</option> <option value="Veículo" '+(dataGarantias[1][i].tipo == 'Veículo' ? 'selected' : '')+'>Veículo</option> <option value="Outros" '+(dataGarantias[1][i].tipo == 'Outros' ? 'selected' : '')+'>Outros</option> </select> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control form-control-line" name="descricaoGarantia[]" value="'+dataGarantias[1][i].descricao+'" disabled/> </div> </div> </div>');
								contador++;
							}
						});
						$('#modal-detalhes').modal('show');
					});
				}});	
			}else{
				// Carregamento de dados
				$('.processing-in').addClass('d-none');
				$('.processing-off').addClass('d-none');
				$('.button-size').fadeIn("slow").removeClass('d-flex');
				$('.button-size').fadeIn("slow").parent().addClass('p-3');
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
		$(this).parents('tr').addClass('active');
		var table = $('#table').DataTable();
		var data = table.row('tr.active').data();
		$.ajax({
			url: 'contratos/editar/'+data.id,
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
					table.row('tr.active').remove().draw(false);
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
		var data = table.row('tr.active').data();
		e.preventDefault();
		$.ajax({
			url: 'contratos/alterar/'+data.id,
			type: 'POST',
			data: $('#modal-alterar #formAlterar').serialize(),
			beforeSend: function(){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
				$('#modal-alterar #err').html('');
			},
			success: function(data){
				$('.modal-body, .modal-footer').addClass('d-none');
				$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Status alterado com sucesso!</label></div>');
				setTimeout(function(){
					$('#modal-alterar #formAlterar').each (function(){
						this.reset();
					});
					table.row('tr.active').remove().draw(false);
					table.row.add(data).draw(false);
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