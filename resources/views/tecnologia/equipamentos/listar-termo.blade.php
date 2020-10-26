@section('title')
Termo de responsabilidade
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Termo de responsabilidade</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.gti')}}">Tecnologia</a></li>
				<li><a href="javascript:void(0)">Inventário</a></li>
				<li class="active">Termo</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<form class="form-sample" target="_blank" action="{{route('gerar.termo.equipamentos')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
				@csrf
				<div class="row col-12 mx-auto justify-content-center">
					<div class="col-8">
						<div class="form-group">
							<label class="col-form-label pb-0">Usuários</label>
							<div class="">
								<select class="form-control form-control-line" name="usuario" required>
									<option value="">Selecione</option>
									@foreach($usuarios as $usuario)
									<option value="{{$usuario->id}}">{{$usuario->nome}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<hr class="col-10">
					<div class="row col-12 justify-content-center mx-auto">
						<button type="submit" class="btn btn-success btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
							<i class="mdi mdi-printer pr-2"></i> 
							<span>Gerar termo</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
