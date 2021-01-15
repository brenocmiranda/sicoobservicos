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
						<select class="form-control form-control-line px-3" name="pagina" id="pagina" style="border-radius: 10px" required>
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
							<div class="row col-12 justify-content-center mx-auto mb-2">
								<input type="text" class="form-control col-8 px-3 h-100" name="nomeArquivos[]" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" required>
								<label for="fupload1" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px"><i class="mdi mdi-file"></i></label>
								<input type="file" name="arquivos[]" id="fupload1" class="position-absolute offset-6 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this)" required>
								<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" disabled><i class="mdi mdi-close"></i></a>
							</div>
						</div>
					</div>
					<a href="javascript:" id="btnAdicionar" class="text-white"> <i class="ti-plus pr-2"></i> Adicionar mais arquivos</a>
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

	function arquivo(input){
		if(input.value){
			if( !($(input).prev().prev().val()) ){
				$(input).prev().prev().val(input.value.replace("C:\\fakepath\\", "").split('.')[0].toUpperCase());
			}
			$(input).prev().html('<i class="mdi mdi-sync"></i>');
			$(input).prev().addClass('bg-success');
		}else{
			$(input).prev().html('<i class="mdi mdi-file"></i>');
			$(input).prev().removeClass('bg-success');
			$(input).prev().prev().val('');
		}
		
	}

	$(document).ready( function (){
		var t = 1;
		$('#btnAdicionar').on('click', function(){
			if($('#pagina').val() == 1){
				t++;
				$('.totalArquivos').append('<div class="row col-12 justify-content-center mx-auto mb-2"> <input type="text" class="form-control col-8 px-3 h-100" name="nomeArquivos[]" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" required> <label for="fupload'+t+'" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px"><i class="mdi mdi-file"></i></label> <input type="file" name="arquivos[]" id="fupload'+t+'" class="mb-3 text-white col-lg-11 col-10 d-none" accept=".jpg, .jpeg, .png, .svg" onchange="arquivo(this)" required> <a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" onclick="remover(this)" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-close"></i></a> </div>'); 
			}else{
				t++;
				$('.totalArquivos').append('<div class="row col-12 justify-content-center mx-auto mb-2"> <input type="text" class="form-control col-8 px-3 h-100" name="nomeArquivos[]" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" disabled> <label for="fupload'+t+'" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px"><i class="mdi mdi-file"></i></label> <input type="file" name="arquivos[]" id="fupload'+t+'" class="mb-3 text-white col-lg-11 col-10 d-none" accept=".jpg, .jpeg, .png, .svg"  onchange="arquivo(this)" required> <a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" onclick="remover(this)" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-close"></i></a> </div>'); 
			}
			
		});

		$('#pagina').on('change', function(){
			if(this.value == 2){
				$('.totalArquivos input[type=text]').attr('disabled', 'disabled');
				$('.totalArquivos input[type=text]').val('');
			}else{
				$('.totalArquivos input[type=text]').removeAttr('disabled');
			}
		});

		$('form').on('submit', function(){
			$('.preloader').fadeIn();
		});
	});
</script>
@endsection

@include('layouts.footer')
