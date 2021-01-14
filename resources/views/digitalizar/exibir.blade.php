@section('title')
Digitalizar
@endsection

@include('layouts.header')

@include('layouts.preloader')
<div class="col-12 h-100 position-absolute imagem" style="background: url({{ (isset($homepage[0]) ? asset('storage/app/').'/'.$homepage->last()->endereco : asset('public/img/home.png').'?'.rand())}})"></div>
<div class="container-fluid h-100 row justify-content-center mx-auto">
	<div class="col-12 row mx-auto px-5 pt-4">
		<div class="row ml-auto pb-lg-0">
			<a href="{{route('homepage')}}" class="text-truncate my-auto font-weight-normal px-3">
            	<h5 class="text-white">
            		<i class="mdi mdi-home-outline mdi-24px pr-1 visible-xs"></i>  
            		<span class="hidden-xs">Homepage</span> 
            	</h5>
            </a>
	    </div>
    </div>
	<div class="col-9 col-sm-9 col-lg-9 mx-auto px-0 row pb-5 pt-3">
		<img src="{{ asset('public/img/logo.png').'?'.rand() }}" class="mx-auto mt-3 col-lg-4 col-sm-6 col-12 h-100">
	</div>
	<div class="row col-12 col-sm-12 col-lg-12 mx-auto py-5 justify-content-center text-left">
		@if(Session::has('confirm'))
		<p class="mx-auto col-sm-12 alert alert-{{ Session::get('confirm')['class'] }}">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ Session::get('confirm')['mensagem'] }}
		</p>
		@endif

		<form class="form-sample row col-12 mx-auto justify-content-center px-0" method="POST" action="{{route('digitalizar.enviar')}}" enctype="multipart/form-data" autocomplete="off">
        @csrf
	        <div class="row col-lg-4 col-12 mx-auto p-0">
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Usuario <span class="text-danger">*</span></label>
						<select class="form-control form-control-line px-3" name="usuario" style="border-radius: 10px" required>
							<option value="">Selecione</option>
							@foreach($usuarios as $usuario)
							<option value="{{$usuario->login}}">{{$usuario->login}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="col-form-label text-white">Tipo <span class="text-danger">*</span></label>
						<select class="form-control form-control-line px-3" name="pagina" style="border-radius: 10px" required>
							<option value="1"> Único</option> 
							<option value="2"> Juntar todos </option> 
						</select>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="col-form-label text-white">Orientação <span class="text-danger">*</span></label>
						<select class="form-control form-control-line px-3" name="orientacao" style="border-radius: 10px" required>
							<option value="portrait"> Retrato</option> 
							<option value="landscape"> Paisagem</option> 
						</select>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Nome da pasta <span class="text-danger">*</span></label>
						<input class="form-control form-control-line px-3" type="text" name="nomePasta" style="border-radius: 10px" onkeyup="this.value = this.value.toUpperCase();" required>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Selecione os arquivos <span class="text-danger">*</span></label>
						<div class="row totalArquivos">
							<div class="row mx-auto">
								<input type="file" name="arquivos[]" class="mb-3 text-white col-lg-11 col-10" accept=".jpg, .jpeg, .png, .svg" required>
							</div>
						</div>
					</div>
					<a href="javascript:" id="btnAdicionar"> <i class="ti-plus pr-2"></i> Adicionar mais arquivos</a>
				</div>
				
			</div>
			<div class="row col-12 col-lg-12 mt-5 text-center mx-auto justify-content-center">
				<div class="col-12 p-0">
					<div class="checkbox checkbox-success text-white">
                        <input id="checkbox-1" type="checkbox" checked required>
                        <label for="checkbox-1"> Declaro que os documentos conferem com originais. </label>
                    </div>
				</div>
				<button type="submit" class="btn btn-success mx-4 col-8 col-lg-2 d-flex align-items-center justify-content-center">
		          	<i class="mdi mdi-send pr-2"></i> 
		          	<span>Enviar</span>
		        </button>
		    </div>
        </form>
	</div>	
</div>

@section('suporte')
<script type="text/javascript">
	function remover(input){
		$(input).parent('div').remove();
	}

	$(document).ready( function (){
		$('#btnAdicionar').on('click', function(){
			$('.totalArquivos').append('<div class="row mx-auto"> <input type="file" name="arquivos[]" class="mb-3 text-white col-lg-11 col-10" accept=".jpg, .jpeg, .png, .svg" required> <a href="javascript:" title="Remover arquivos" onclick="remover(this);" class="col-1 text-danger"><i class="mdi mdi-delete"></i></a> </div>');
		});

		$('form').on('submit', function(){
			$('.preloader').fadeIn();
		});
	});
</script>
@endsection

@include('layouts.footer')
