@section('title')
Disposição
@endsection

@section('caminho')
<small class="section-header-breadcrumb d-flex">
	<div class="breadcrumb-item">
		<a href="javascript:void(0)" class="p-0 d-block">Credito</a>
	</div>
	<div class="breadcrumb-item d-flex active p-0">
		<a href="{{ route('exibir.disposicao.credito') }}" class="p-0 d-block text-primary">Disposição</a>
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
						<h3>Disposição dos armários</h3>
						<h6>Listagem com todos os armários cadastrados na plataforma.</h6>
					</div>
					<div class="ml-auto">
						<button class="btn btn-outline-success px-2 mx-2" id="adicionar" name="adicionar" title="Adicionar novo armário" data-toggle="modal" data-target="#modal-adicionar"><i class="mx-0 mdi mdi-plus"></i> Novo contrato </button>
						<a href="{{route('imprimir.disposicao.credito')}}" target="_blank" class="btn btn-outline-success px-2" id="imprimir" name="imprimir" title="Imprimir relação"><i class="mx-0 mdi mdi-printer"></i> Imprimir </a>
					</div>
				</div>
			</div>
			<hr>
			<div class="mx-2 row justify-content-left" id="disposicao">
				<?php $i=0;?>

				@for($j=0; $j < count($armarios); $j=$j+4)
				<div class="col-3 p-3 bg-secondary" style="border: 8px solid white; border-radius: 20px; font-size: 13px">
					@while($i < count($armarios))
						<a href="{{route('exibir.gaveta.credito', $armarios[$i]->id_armario)}}" class="text-dark  border-bottom">
							<div class="p-2 text-center bg-white rounded mb-2">
								<b>{{$armarios[$i]->referencia}}</b>
								<br>
								{{$armarios[$i]->nome}}
							</div>
						</a>
						@if($i % 3 === 0 && $i != 0)
							<?php $i++; ?>
							@break
						@else
							<?php $i++; ?>
						@endif	
					@endwhile
				</div>
				@endfor

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
	});
</script>
@endsection