@section('title')
Disposição
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Disposição de armários</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.credito')}}">Crédito</a></li>
				<li><a class="active">Disposição</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12">
				<div class="col-12 row mb-4 mx-auto">
					@include('layouts.search')
					<div class="col-5 p-0 row mx-auto">
						<button class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo contrato" data-toggle="modal" data-target="#modal-adicionar">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Novo contrato</span>
						</button>
					</div>
				</div>

				<ul class="row col-12 p-0 mx-auto my-5" id="arquivos">
					<div class="row col-12 mx-auto justify-content-left">
						@foreach($armarios as $key => $armario)
							@if(($key+1) % 4 == 1)
								<li class="col-3 p-2 rounded" style="border: 8px solid white; padding-bottom: 20px !important; background-color: #edf1f5; border-radius: 18px !important">
							@endif
								<a href="{{route('exibir.gaveta.credito', $armario->id)}}" class="text-dark border-bottom">
									<div class="p-2 text-center bg-white rounded mb-2 h-25">
										<h5>{{$armario->referencia}}</h5>
										<label>{{$armario->nome}}</label>
									</div>
								</a>
							@if( ($key+1) % 4 == 0)
								</li>
							@endif
						@endforeach
					</div>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('credito.contratos.adicionar')
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

		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#arquivos li").css("display", "block");
			$("#arquivos li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});
		
		// Formatação de campos
		$('.nivel_risco').mask('SSSS');
		$('.quantidade_parcelas').mask('000', {reverse: true});
		$('.taxa_operacao').mask('000,00', {reverse: true});
		$('.taxa_mora').mask('000,00', {reverse: true});
		$('.taxa_multa').mask('000,00', {reverse: true});
		$('.money').mask('000.000.000.000.000,00', {reverse: true});
		
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
			$(".adicionarAvalista").append('<div class="form-group rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"><input type="text" name="avalista[]" class="avalista form-control form-control-line mr-2" placeholder="Pesquise o associado" required> <a href="javascript:void(0)" class="badge badge-danger my-auto" title="Remover" onclick="excluirAvalista('+contador+');"><i class="mdi mdi-delete"></i></a> </div> </div> </div>');
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
			$(".adicionarGarantia").append('<div class="form-group rounded" id="garantia'+contador+'"> <div class="d-flex"> <div class="col-4"> <label class="col-form-label pb-0">Tipo</label> <input type="text" class="form-control form-control-line" name="tipoGarantia[]"/> </div> <div class="col-7"> <label class="col-form-label pb-0">Descrição</label> <input type="text" class="form-control form-control-line" name="descricaoGarantia[]"/> </div> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirGarantia('+contador+');"><i class="mdi mdi-delete"></i></a> </div> </div>'); 
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
	});
</script>
@endsection