@section('title')
Plataforma
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Plataforma</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li class="active">Plataforma</li>
			</ol>
		</div>
	</div>

	<form class="form-sample" method="POST" action="{{ route('salvar.plataforma') }}" enctype="multipart/form-data" autocomplete="off">
		@csrf

		@if(Session::has('alteracao'))
		<p class="mx-auto col-sm-12 alert alert-{{ Session::get('alteracao')['class'] }}">
			{{ Session::get('alteracao')['mensagem'] }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</p>
		@endif

		<div class="card mb-5">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white"> Homepage</h5>
			</div>
			<div class="card-body">
				<div class="col-12">
					<div class="form-group">
						<div class="row col-12 mt-3 mx-0 p-0">
							<div class="border mx-2 rounded col-lg-3 col-12 row p-0 mb-4" style="height: 15em;">
								<img class="w-100 h-100 p-3" id="PreviewImage1" src="{{ (isset($homepage[0]) ? asset('storage/app/').'/'.$homepage->last()->endereco : asset('public/img/image.png').'?'.rand())}}">
							</div>
							<div class="col-lg-8 col-12">
								<h5>Imagem de fundo</h5>
								<hr class="mt-2 col-12">
								<input type="file" accept=".png, .jpg, .jpeg .svg" class="pb-4" name="homepage_principal" accept="image/*" title="Selecione a imagem principal" onchange="image1(this)">
								<small class="p-2">* Formatos de imagem aceitos: <b>.png</b>, <b>.jpg</b>, <b>.jpeg</b> ou <b>.svg</b></small>
							</div>
						</div> 
						
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white"> Tela de login</h5>
			</div>
			<div class="card-body">
				<div class="col-12">
					<div class="form-group">
						<div class="row col-12 mt-3 mx-0 p-0">
							<div class="border mx-2 rounded col-lg-3 col-12 row p-0 mb-4" style="height: 15em;">
								<img class="w-100 h-100 p-3" id="PreviewImage2" src="{{ (isset($login[0]) ? asset('storage/app/').'/'.$login->last()->endereco : asset('public/img/image.png').'?'.rand())}}">
							</div>
							<div class="col-lg-8 col-12">
								<h5>Imagem de fundo</h5>
								<hr class="mt-2 col-12">
								<input type="file" class="pb-4" accept=".png, .jpg, .jpeg .svg" name="login_principal" accept="image/*" title="Selecione a imagem principal" onchange="image2(this)">
								<small class="p-2">* Formatos de imagem aceitos: <b>.png</b>, <b>.jpg</b>, <b>.jpeg</b> ou <b>.svg</b></small>
							</div>
						</div> 

					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row col-12 mx-auto justify-content-center text-center mt-5">
			<button type="submit" class="btn btn-success btn-lg col-lg-4 col-8">
				<i class="mdi mdi-check mdi-18px pr-2"></i>
				<span>Salvar alterações</span>
			</button>
		</div>
	</form>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	function image1(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function (oFREvent){
				$('#PreviewImage1').attr('src', oFREvent.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function image2(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function (oFREvent){
				$('#PreviewImage2').attr('src', oFREvent.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection