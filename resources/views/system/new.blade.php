@include('layouts.header')

@section('title')
Primeiro acesso
@endsection

<div class="col-12 h-100 position-absolute imagem" style="background: url({{asset('public/img/fundo-white.png')}}); filter: none;"></div>
<div class="container-fluid h-100">
	<div class="absolute-center text-center m-auto" style="width: 500px !important;">
		<div class="py-5">
			<img src="{{ asset('public/img/logo.png') }}" alt="logo" width="200" class="position-relative">
		</div>
		<div class="px-5">
			<div class="card shadow mb-4 border-0">
				<div class="card-header">
					<h4 class="mx-auto my-auto text-white py-3 font-weight-normal">Seu primeiro acesso</h4>
				</div>
				<div class="card-body text-left">
					<form method="POST" enctype="multipart/form-data" action="{{route('salvar.primeiro.acesso')}}">
						@csrf
						<div class="text-center mx-3">
							<h6 class="my-2">Seja bem-vindo, {{explode(" ", ucfirst(strtolower(Auth::user()->RelationAssociado->nome)))[0]}}!</h6>
							<label>Detectamos que este é seu primeiro acesso, sendo assim é necessário que cadastre sua nova senha para acessar a plataforma.</label>
						</div>							
						<div class="col-12 my-3">
							<label><b>Nova senha:</b></label>
							<input type="password" class="password form-control form-control-line" placeholder="******" name="password" minlength="6">
						</div>
						<div class="col-12 my-3">
							<label><b>Confirme a senha:</b></label>
							<input type="password" class="confirmpassword form-control form-control-line" placeholder="******" name="confirmpassword" minlength="6">
							<input type="hidden" name="id" value="{{Auth::user()->id}}">
						</div>
						<div id="err"></div>
						<div class="col-12 mt-4 mb-3 text-center">
							<button type="submit" class="btn btn-secondary btn-lg btn-icon icon-left col-5 mx-1 shadow-none" id="submit" disabled>
								<span>Salvar</span>
								<i class="mdi mdi-check"></i> 
							</button>
						</div>
						
					</form>
				</div>
			</div>
		</div>
		<div class="col-12">
			<label>2020 © GTI Sicoob Sertão Minas <b>&#183</b> v.1.1</label>
			<br>
			<a href="{{route('login')}}" target="_blank">Login</a> 
			<b>&#183</b>
			<a href="{{route('homepage')}}" target="_blank">Homepage</a> 
		</div>
	</div>
</div>

@section('suporte')
<script type="text/javascript">
	$(document).ready(function (){
		$('.password, .confirmpassword').on('keyup', function(){
			$('#err').html('');
			if($('.password').val() == $('.confirmpassword').val()){
				if($('.password').val().length >= 6 && $('.confirmpassword').val().length >= 6){
					$('#submit').removeAttr('disabled');
					$('#submit').addClass('btn-success');
				}else{
					$('#err').html('<div class="text-danger text-center col"> São necessários no mínimo 6 caracteres.</div>');
				}
			}else{
				$('#err').html('<div class="text-danger text-center col">As senhas não conferem.</div>')
				$('#submit').attr('disabled', 'disabled');
				$('#submit').removeClass('btn-success');
			}
		});
	});
</script>
@endsection

@include('layouts.footer')