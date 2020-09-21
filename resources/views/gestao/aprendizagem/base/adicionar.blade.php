@section('title')
Adicionar tópico
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Adicionar tópico</h4>
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Suporte</a></li>
				<li class="active"><a href="{{route('exibir.base.aprendizagem')}}">Tópicos</a></li>
				<li class="active">Adicionar</li>
			</ol>
		</div>
	</div>
	<div class="confim row col-12 p-0 mx-auto">
		@if($errors->any())
		<div class="col-sm-12 alert alert-danger font-weight-normal">
			@foreach ($errors->all() as $error)
			<p>{{ $error }}</p>
			@endforeach
		</div>
		@endif
	</div>
	
	<form class="form-sample" action="{{route('salvar.adicionar.base.aprendizagem')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
		@csrf
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row mx-auto">
							<div class="col-4">
								<div class="form-group">
									<label class="col-form-label pb-0">Fonte <span class="text-danger">*</span></label>
									<select class="form-control form-control-line gti_id_fontes" name="gti_id_fontes" required>
										<option disabled>Selecione</option>
										@foreach($fontes as $fonte)
										<option value="{{$fonte->id}}">{{$fonte->nome}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-5">
								<div class="form-group">
									<label class="col-form-label pb-0">Tipo</label>
									<div class="">
										<select class="form-control form-control-line gti_id_tipos" name="gti_id_tipos" required disabled>
											<option disabled>Selecione</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-10">
								<div class="form-group">
									<label class="col-form-label pb-0">Titulo <span class="text-danger">*</span></label>
									<div class="">
										<input class="form-control form-control-line" name="titulo" required/>
									</div>
								</div>
							</div>
							<div class="col-11">
								<div class="form-group">
									<label class="col-form-label pb-0">Sub-título <span class="text-danger">*</span></label>
									<div class="">
										<input class="form-control form-control-line" name="subtitulo" required/>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label">Descrição <span class="text-danger">*</span></label>
									<div class="">
										<textarea class="summernote" name="descricao" placeholder="Digite suas observações" required></textarea>
									</div>
								</div>
							</div>
							<hr class="col-10 mt-0">
							<div class="row col-12 justify-content-center mx-auto">
								<a href="{{route('exibir.base.aprendizagem')}}" class="btn btn-danger btn-outline col-3 d-flex align-items-center justify-content-center mx-2">
									<i class="mdi mdi-arrow-left pr-2"></i> 
									<span>Voltar</span>
								</a>
								<button type="submit" class="btn btn-success btn-outline col-3 d-flex align-items-center justify-content-center mx-2">
									<i class="mdi mdi-check pr-2"></i> 
									<span>Salvar</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection


@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		$('.summernote').summernote({
            height: 150, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

       	$('.gti_id_fontes').on('change', function(e){
			var fonte = $('.gti_id_fontes').val();
			$.ajax({
				url: "../base/tipos/"+fonte,
				type: 'GET',
				success: function(data){ 
					if(data[0]){
						$('.gti_id_tipos').removeAttr('disabled');
						$('.gti_id_tipos').html('<option></option>');
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
						$.each(data, function(count, dados){
							$('.gti_id_tipos').append('<option value='+dados.id+'>'+dados.nome+'</option>');
						});		
					}else{
						$('.gti_id_tipos').attr('disabled', 'disabled');
						$('.gti_id_tipos').html('<option>Nenhum encontrado</option>');
						$('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
					}		
				}
			});
		});
	});
</script>
@endsection