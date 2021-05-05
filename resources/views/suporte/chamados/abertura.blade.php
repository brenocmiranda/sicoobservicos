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
			<div class="col-lg-8 col-12 order-2 order-lg-1">
				<div class="card">
					<div class="card-body">
						<div class="row mx-auto">
							<div class="col-lg-6 col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Ambientes <span class="text-danger">*</span></label>
									<select class="form-control form-control-line ambientes" name="gti_id_ambientes" required>
										<option>Selecione</option>
										@foreach($ambientes as $ambiente)
										<option value="{{$ambiente->id}}">{{$ambiente->nome}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-7 col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Fontes <span class="text-danger">*</span></label>
									<select class="form-control form-control-line fontes" name="gti_id_fontes" required>
										<option></option>
									</select>
								</div>
							</div>
							<div class="col-lg-12 col-12 row mx-auto mb-4">
								<div class="form-group mb-2 col-lg-4 col-10 px-0">
									<label class="col-form-label pb-0">ID TeamViewer</label>
									<input class="form-control form-control-line teamViewer" name="teamViewer" placeholder="0 000 000 000"/>
								</div>
								<div class="col-lg-2 col-2">
									<span class="mytooltip tooltip-effect-1">
					                    <span class="tooltip-item mt-5"><i class="mdi mdi-information-outline tooltip-item"></i></span> 
				                    	<span class="tooltip-content clearfix" style="min-width: 430px;">
					                      	<img src="{{asset('public/img/teamViewer.png')}}">
					                      	<span class="tooltip-text">Para obter esse ID acesse na sua área de trabalho o atalho TeamViewer 13 Hostpot.</span> 
					                  	</span>
					                </span>
								</div>
								<div class="col-lg-12 px-0">
									<small>Preencha esse campo caso seja necessária conexão a sua máquina.</small>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Assunto <span class="text-danger">*</span></label>
									<input class="form-control form-control-line text-uppercase" name="assunto" placeholder="Resuma o seu problema"  required/>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Descrição</label>
									<textarea class="form-control form-control-line  text-uppercase" name="descricao" rows="4" placeholder="Descreva aqui mais informações..."></textarea>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label col-12 row mb-0">Selecione os anexos</label>
									<small>Todos formatos são aceitos aceitos: <b>.png</b>, <b>.jpg</b>, <b>.xls</b>, <b>.pdf</b>, <b>.doc</b>, <b>.docx</b></small>
									<div class="row col-12 mt-3 preview mx-0 p-0">
										<div class="border mx-2 rounded col-lg-2 col-4 row p-0 mb-4" style="height: 7em;">
											<i class="mdi mdi-plus mdi-36px m-auto"></i>
											<input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" id="addArquivo" title="Selecione os anexos do tópico" multiple>
										</div>
									</div> 
								</div>
							</div>
							<hr class="col-10 mt-0">
							<div class="row col-12 justify-content-center mx-auto">
								<a href="{{route('exibir.chamados')}}" class="btn btn-danger btn-outline col-lg-4 col-5 d-flex align-items-center justify-content-center mx-2">
									<i class="mdi mdi-arrow-left pr-2"></i> 
									<span>Voltar</span>
								</a>
								<button type="submit" class="btn btn-success btn-outline col-lg-4 col-6 d-flex align-items-center justify-content-center mx-2">
									<i class="mdi mdi-check pr-2"></i> 
									<span>Abrir chamado</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-12 pb-4 pt-lg-0 order-1 order-lg-2">
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
			url: "removeArquivo/"+id,
			type: 'GET',
			success: function(data){ 
				$('#PreviewImage'+id).remove();
			}
		});
	}
	$(document).ready( function (){
		$('.teamViewer').mask('00 000 000 000', {reverse: true});

		// Buscando os ambientes relacionados aquela fontes
		$('.ambientes').on('change', function(e){
			var ambientes = $('.ambientes').val();
			$.ajax({
				url: "fontes/"+ambientes,
				type: 'GET',
				success: function(data){ 
					if(data[0]){
						$('.fontes').html('<option value="">Selecione</option>');
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado o seu ambiente e a fonte do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
						$.each(data, function(count, dados){
							$('.fontes').append('<option value='+dados.id+'>'+dados.nome+'</option>');
						});		
					}else{
						$('.fontes').html('<option value="">Nenhum encontrado</option>');
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado o seu ambiente e a fonte do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
					}		
				}
			});
		});

		// Buscando possíveis soluções na base de conhecimento
		$('.fontes').on('change', function(e){
			var ambiente = $('.ambientes').val();
			var fonte = $('.fontes').val();
			$.ajax({
				url: "base/"+ambiente+'/'+fonte,
				type: 'GET',
				success: function(data){ 
					if(data[0]){
						$('#info-base').html('');
						$.each(data, function(count, dados){
							$('#info-base').fadeIn(3000).append('<div class="panel panel-default border shadow-sm"><div class="panel-heading py-4"><a href="{{url("app/suporte/base/detalhes")}}/'+dados.id+'">'+dados.titulo+'</a></div><div class="panel-wrapper collapse in"><div class="panel-body py-3"> <p>'+dados.subtitulo+'</p></div></div></div>');
						});	
					}else{
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado o seu ambiente e a fonte do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
					}
					
				}
			});
		});

		// Pré-visualização de várias imagens no navegador
		$('#addArquivo').on('change', function(event) {
			var formData = new FormData();
			formData.append('_token', '{{csrf_token()}}');

			if (this.files) {
				for (i = 0; i < this.files.length; i++) {
					formData.append('arquivos[]', this.files[i]);
				}
				$.ajax({
					url: "{{ route('adicionar.arquivos.chamados') }}",
					type: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function(data){ 
						for (i = 0; i < data.length; i++) {
							$('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 p-0 row text-center" id="PreviewImage'+data[i].id+'" style="height:7em"> <input type="hidden" name="arquivos[]" value="'+data[i].id+'"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="height: 26px; width: 26px">x</a>'+(data[i].endereco.split('.')[1] == 'docx' || data[i].endereco.split('.')[1] == 'doc' ? '<i class="mdi mdi-file-word mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'xls' || data[i].endereco.split('.')[1] == 'xlsx' || data[i].endereco.split('.')[1] == 'xlsm' || data[i].endereco.split('.')[1] == 'csv' ? '<i class="mdi mdi-file-excel mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'pdf' ? '<i class="mdi mdi-file-pdf mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : '<i class="mdi mdi-file-document mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>')))+'</div>');
						} 
						$('#addArquivo').val('');   
					}
				});
			}
		});
	});
</script>
@endsection