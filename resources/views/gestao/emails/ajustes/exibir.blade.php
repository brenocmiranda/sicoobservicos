@section('title')
Ajustes e-mails
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Ajustes dos e-mails</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li><a href="javascript:void(0)">E-mails</a></li>
				<li class="active">Ajustes</li>
			</ol>
		</div>
	</div>
	
	@if(Session::has('alteracao'))
	<p class="mx-auto col-sm-12 alert alert-{{ Session::get('alteracao')['class'] }}">
		{{ Session::get('alteracao')['mensagem'] }}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</p>
	@endif

	<div class="card">
		<div class="card-body">
			<form method="POST" class="form-sample" action="{{route('salvar.ajustes.emails')}}" enctype="multipart/form-data" autocomplete="off">
				@csrf
				<div class="col-12 grid-margin mb-0">
					<div class="row">
						<div class="col-12">
							<h5>Chamados</h5>
							<div class="col-10">
								<div class="form-group">
									<label class="col-form-label pb-0">E-mail de recebimento <span class="text-danger">*</span></label>
									<input class="form-control form-control-line" name="email_chamado" placeholder="ti@sicoobsertaominas.com.br" value="{{$chamado->email_chamado}}" required/>
								</div>
							</div>
						</div>
						<div class="col-12">
							<h5>Materiais</h5>
							<div class="col-10">
								<div class="form-group">
									<label class="col-form-label pb-0">E-mail de recebimento <span class="text-danger">*</span></label>
									<input type="email" class="form-control form-control-line" name="email_material" placeholder="administrativo@sicoobsertaominas.com.br" value="{{$material->email_material}}" required/>
								</div>
							</div>
						</div>
						<div class="col-12">
							<h5>Contratos de crédito</h5>
							<div class="col-10">
								<div class="form-group">
									<label class="col-form-label pb-0">E-mail de recebimento <span class="text-danger">*</span></label>
									<input  type="email" class="form-control form-control-line" name="email_contrato" placeholder="credito@sicoobsertaominas.com.br" value="{{$contrato->email_contrato}}" required/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mt-5 row col-12 justify-content-center">
					<button type="reset" class="btn btn-danger btn-outline col-3 mx-1 d-flex align-items-center justify-content-center">
						<i class="mdi mdi-close pr-2"></i> 
						<span>Cancelar</span>
					</button>
					<button type="submit" class="btn btn-success btn-outline col-3 mx-1 d-flex align-items-center justify-content-center">
						<i class="mdi mdi-check pr-2"></i> 
						<span>Salvar</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
