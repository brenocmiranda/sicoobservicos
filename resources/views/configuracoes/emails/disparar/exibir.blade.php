@section('title')
Enviar e-mails
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Enviar e-mails</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li><a href="javascript:void(0)">E-mails</a></li>
				<li class="active">Mensagens</li>
			</ol>
		</div>
	</div>
	
	<form method="POST" class="form-sample" action="{{route('enviar.disparo.emails')}}" enctype="multipart/form-data" autocomplete="off">
	@csrf
		@if(Session::has('envio'))
		<p class="mx-auto col-sm-12 alert alert-{{ Session::get('envio')['class'] }}">
			{{ Session::get('envio')['mensagem'] }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</p>
		@endif
		<div class="card mb-4">
			<div class="card-body">
				<div class="col-12 grid-margin mb-0">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Destinatário <span class="text-danger">*</span></label>
								<select class="form-control form-control-line from" name="from" required>
									<option value="">Selecione</option>
									@foreach($usuarios as $usuario)
										<option value="{{$usuario->id}}">{{$usuario->RelationAssociado->nome}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-12">
							<div class="checkbox checkbox-success mt-0">
	                            <input id="checkbox" type="checkbox" name="enviarTodos">
	                            <label for="checkbox"> Enviar para todos </label>
	                        </div>
						</div>
						<div class="col-lg-10 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Assunto <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="assunto" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label pb-2"> Mensagem <span class="text-danger">*</span></label>
								<textarea class="summernote" name="mensagem"></textarea>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="mt-5 row col-12 justify-content-center mx-auto">
			<a href="javascript:void()" onclick="location.reload()" class="btn btn-danger col-lg-3 col-5 mx-2 d-flex align-items-center justify-content-center">
				<i class="mdi mdi-close pr-2"></i> 
				<span>Cancelar</span>
			</a>
			<button type="submit" class="btn btn-success col-lg-3 col-5 mx-2 d-flex align-items-center justify-content-center">
				<i class="mdi mdi-send pr-2"></i> 
				<span>Enviar</span>
			</button>
		</div>

	</form>

</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready(function() {
        $('.summernote').summernote({
            height: 120, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('#checkbox').on('click', function(){
        	if($(this).prop("checked")){
        		$('.from').val('');
        		$('.from').attr('disabled', 'disabled');
        	}else{
        		$('.from').removeAttr('disabled');
        	}
        });
    });
</script>
@endsection