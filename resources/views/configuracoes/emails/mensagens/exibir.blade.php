@section('title')
Mensagens e-mails
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Mensagens dos e-mails</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li><a href="javascript:void(0)">E-mails</a></li>
				<li class="active">Mensagens</li>
			</ol>
		</div>
	</div>
	
	<form method="POST" class="form-sample" action="{{route('salvar.mensagens.emails')}}" enctype="multipart/form-data" autocomplete="off">
	@csrf
		@if(Session::has('alteracao'))
		<p class="mx-auto col-sm-12 alert alert-{{ Session::get('alteracao')['class'] }}">
			{{ Session::get('alteracao')['mensagem'] }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</p>
		@endif

		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white col">Chamados</h5>
			</div>
			<div class="card-body">
				<div class="col-12 grid-margin mb-0">
					<div class="row">
						<div class="col-lg-10 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Assunto de abertura</label>
								<input class="form-control form-control-line" name="assunto_abertura_chamado" placeholder="ti@sicoobsertaominas.com.br" value="{{$chamado->assunto_abertura_chamado}}" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label pb-2"> Mensagem de abertura </label>
								<textarea class="summernote" name="abertura_chamado">{{$chamado->abertura_chamado}}</textarea>
							</div>
						</div>
						<hr class="col-12 row">
						<div class="col-10">
							<div class="form-group">
								<label class="col-form-label pb-0">Assunto de fechamento</label>
								<input class="form-control form-control-line" name="assunto_fechamento_chamado" placeholder="ti@sicoobsertaominas.com.br" value="{{$chamado->assunto_fechamento_chamado}}" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label pb-2"> Mensagem de fechamento </label>
								<textarea class="summernote" name="fechamento_chamado">{{$chamado->fechamento_chamado}}</textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white col">Solicitação de materiais</h5>
			</div>
			<div class="card-body">
				<div class="col-12 grid-margin mb-0">
					<div class="row">
						<div class="col-lg-10 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Assunto de abertura</label>
								<input class="form-control form-control-line" name="assunto_abertura_material" placeholder="ti@sicoobsertaominas.com.br" value="{{$material->assunto_abertura_material}}" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label pb-2"> Mensagem de abertura </label>
								<textarea class="summernote" name="abertura_solicitacao_material">{{$material->abertura_solicitacao_material}}</textarea>
							</div>
						</div>
						<hr class="col-12 row">
						<div class="col-10">
							<div class="form-group">
								<label class="col-form-label pb-0">Assunto de fechamento</label>
								<input class="form-control form-control-line" name="assunto_fechamento_material" placeholder="ti@sicoobsertaominas.com.br" value="{{$material->assunto_fechamento_material}}" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label pb-2"> Mensagem de fechamento </label>
								<textarea class="summernote" name="fechamento_solicitacao_material">{{$material->fechamento_solicitacao_material}}</textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white col">Solicitação de contratos de crédito</h5>
			</div>
			<div class="card-body">
				<div class="col-12 grid-margin mb-0">
					<div class="row">
						<div class="col-lg-10 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Assunto de abertura</label>
								<input class="form-control form-control-line" name="assunto_abertura_contrato" placeholder="ti@sicoobsertaominas.com.br" value="{{$contrato->assunto_abertura_contrato}}" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label pb-2"> Mensagem de abertura </label>
								<textarea class="summernote" name="abertura_solicitacao_contrato">{{$contrato->abertura_solicitacao_contrato}}</textarea>
							</div>
						</div>
						<hr class="col-12 row">
						<div class="col-10">
							<div class="form-group">
								<label class="col-form-label pb-0">Assunto de fechamento</label>
								<input class="form-control form-control-line" name="assunto_fechamento_contrato" placeholder="ti@sicoobsertaominas.com.br" value="{{$contrato->assunto_fechamento_contrato}}" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label pb-2"> Mensagem de fechamento </label>
								<textarea class="summernote" name="fechamento_solicitacao_contrato">{{$contrato->fechamento_solicitacao_contrato}}</textarea>
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
				<i class="mdi mdi-check pr-2"></i> 
				<span>Salvar</span>
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
    });
</script>
@endsection