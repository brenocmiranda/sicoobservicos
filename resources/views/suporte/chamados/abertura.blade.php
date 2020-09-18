@section('title')
Abertura de chamado
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Abertura de chamado</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">GTI</a></li>
				<li class="active"><a href="{{route('exibir.chamados')}}">Chamados</a></li>
				<li class="active">Abertura</li>
			</ol>
		</div>
	</div>
	<div class="confim"></div>
	
	<form class="form-sample" action="{{route('abertura.chamados.enviar')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
		@csrf
		<div class="row">
			<div class="col-8">
				<div class="card">
					<div class="card-body">
						<div class="row mx-auto">
							<div class="col-6">
								<div class="form-group">
									<label class="col-form-label pb-0">Fontes <span class="text-danger">*</span></label>
									<select class="form-control form-control-line fontes" name="fontes" required>
										<option>Selecione</option>
										@foreach($fontes as $fonte)
										<option value="{{$fonte->id}}">{{$fonte->nome}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-7">
								<div class="form-group">
									<label class="col-form-label pb-0">Tipos <span class="text-danger">*</span></label>
									<select class="form-control form-control-line tipos" name="tipos" required disabled>
										<option></option>
									</select>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Assunto <span class="text-danger">*</span></label>
									<input class="form-control form-control-line" name="assunto" placeholder="Resuma o seu problema" required/>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Descrição</label>
									<textarea class="form-control form-control-line" name="descricao" onkeyup="this.value = this.value.toUpperCase();" rows="4" placeholder="Descreva aqui mais informações..."></textarea>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label col-12 row mb-0">Selecione as imagens</label>
									<small>Formatos de imagem aceitos: <b>.png</b>, <b>.jpg</b> ou <b>.svg</b></small>
									<div class="row col-12 mt-3 preview mx-0 p-0">
										<div class="border mx-2 rounded col-2 row p-0 mb-4" style="height: 7em;">
											<i class="mdi mdi-plus mdi-36px m-auto"></i>
											<input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" id="addFotoGaleria" accept="image/*" title="Selecione as imagens do problema" multiple>
										</div>
									</div> 
								</div>
							</div>
							<hr class="col-10 mt-0">
							<div class="row col-12 justify-content-center mx-auto">
								<a href="{{route('exibir.chamados')}}" class="btn btn-danger btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
									<i class="mdi mdi-arrow-left pr-2"></i> 
									<span>Voltar</span>
								</a>
								<button type="submit" class="btn btn-success btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
									<i class="mdi mdi-check pr-2"></i> 
									<span>Abrir chamado</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-4">
				<h5 class="text-center">Base do conhecimento</h5>
				<hr class="mt-2">
				<div id="info-base">
					<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>
				</div>
			</div>	
		</div>
	</form>
</div>
@endsection


@section('suporte')
<script type="text/javascript">
	function removeImagem(id){
		$.ajax({
			url: "removeImagem/"+id,
			type: 'GET',
			success: function(data){ 
				$('#PreviewImage'+id).remove();
			}
		});
	}
	$(document).ready( function (){
		// Buscando os tipos relacionados aquela fonte
		$('.fontes').on('change', function(e){
			var fonte = $('.fontes').val();
			$.ajax({
				url: "tipos/"+fonte,
				type: 'GET',
				success: function(data){ 
					if(data[0]){
						$('.tipos').removeAttr('disabled');
						$('.tipos').html('<option></option>');
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
						$.each(data, function(count, dados){
							$('.tipos').append('<option value='+dados.id+'>'+dados.nome+'</option>');
						});		
					}else{
						$('.tipos').attr('disabled', 'disabled');
						$('.tipos').html('<option>Nenhum encontrado</option>');
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
					}		
				}
			});
		});

		// Buscando possíveis soluções na base de conhecimento
		$('.tipos').on('change', function(e){
			var fonte = $('.fontes').val();
			var tipo = $('.tipos').val();
			$.ajax({
				url: "base/"+fonte+'/'+tipo,
				type: 'GET',
				success: function(data){ 
					if(data[0]){
						$('#info-base').html('');
						$.each(data, function(count, dados){
							$('#info-base').fadeIn(3000).append('<div class="panel panel-default border shadow-sm"><div class="panel-heading py-4"><a href="{{url("app/suporte/base/detalhes")}}/'+dados.id+'">'+dados.titulo+'</a></div><div class="panel-wrapper collapse in"><div class="panel-body py-3"> <p>'+dados.subtitulo+'</p></div></div></div>');
						});	
					}else{
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
					}
					
				}
			});
		});

		// Pré-visualização de várias imagens no navegador
		$('#addFotoGaleria').on('change', function(event) {
			var formData = new FormData();
			formData.append('_token', '{{csrf_token()}}');

			if (this.files) {
				for (i = 0; i < this.files.length; i++) {
					formData.append('imagens[]', this.files[i]);
				}
				$.ajax({
					url: "{{ route('adicionar.imagens.chamados') }}",
					type: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function(data){ 
						for (i = 0; i < data.length; i++) {
							$('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 d-flex p-0" id="PreviewImage'+data[i].id+'"> <input type="hidden" name="imagens[]" value="'+data[i].id+'"> <img class="p-3 w-100" src="{{asset("storage/app")}}/'+data[i].endereco+'" style="height: 7em;"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n3 border btn-xs" style="height: 26px;">x</a> </div>');
						} 
						$('#addFotoGaleria').val('');   
					}
				});
			}
		});	
	});
</script>
@endsection