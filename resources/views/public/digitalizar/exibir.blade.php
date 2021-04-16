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
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Nome da pasta <span class="text-danger">*</span></label>
						<input class="form-control form-control-line px-3 text-uppercase" type="text" name="nomePasta" style="border-radius: 10px" required>
					</div>
				</div>
				<img src="" id="ImagePrincipal">
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Documento de identificação</label>
						<div class="row">
							<div class="row col-12 justify-content-center mx-auto mb-2">
								<label for="identificacao1" class="btn btn-default col-10 px-0 border-0 pt-3" title="Selecione o arquivo" style="border-radius: 0px; border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;"><span class="my-auto">Frente</span></label>
								<input type="file" id="identificacao1" class="position-absolute col-8 ml-n5 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this, 'identificacao')">
								<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" onclick="remover(this)"><i class="mdi mdi-close"></i></a>
							</div>
							<div class="row col-12 justify-content-center mx-auto mb-2 identificao2" style="display: none;">
								<label for="identificacao2" class="btn btn-default col-10 px-0 border-0 pt-3" title="Selecione o arquivo" style="border-radius: 0px; border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;">Verso</label>
								<input type="file" name="identificacao[]" id="identificacao2" class="position-absolute offset-6 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this, 'identificacao')">
								<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" onclick="remover(this)"><i class="mdi mdi-close"></i></a>
							</div>
							<div class="col-12">
								<div class="checkbox checkbox-success text-white">
			                        <input id="checkbox-1" type="checkbox">
			                        <label for="checkbox-1"> Incluir o verso? </label>
			                    </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">CPF</label>
						<div class="row">
							<div class="row col-12 justify-content-center mx-auto mb-2">
								<label for="cpf" class="btn btn-default col-10 px-0 border-0 pt-3" title="Selecione o arquivo" style="border-radius: 0px; border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;">CPF</label>
								<input type="file" id="cpf" class="position-absolute col-8 ml-n5 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this, 'cpf')">
								<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" onclick="remover(this)"><i class="mdi mdi-close"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Comprovante de renda</label>
						<div class="row">
							<div class="row col-12 justify-content-center mx-auto mb-2">
								<label for="renda" class="btn btn-default col-10 px-0 border-0 pt-3" title="Selecione o arquivo" style="border-radius: 0px; border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;">Renda</label>
								<input type="file" id="renda" class="position-absolute col-8 ml-n5 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this, 'renda')">
								<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" onclick="remover(this)"><i class="mdi mdi-close"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Comprovante de residencia</label>
						<div class="row">
							<div class="row col-12 justify-content-center mx-auto mb-2">
								<label for="residencia" class="btn btn-default col-10 px-0 border-0 pt-3" title="Selecione o arquivo" style="border-radius: 0px; border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;">Residência</label>
								<input type="file" id="residencia" class="position-absolute col-8 ml-n5 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this, 'residencia')">
								<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" onclick="remover(this)"><i class="mdi mdi-close"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label class="col-form-label text-white">Cartão de assinatura</label>
						<div class="row">
							<div class="row col-12 justify-content-center mx-auto mb-2">
								<label for="assinatura" class="btn btn-default col-10 px-0 border-0 pt-3" title="Selecione o arquivo" style="border-radius: 0px; border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;"> Assinatura </label>
								<input type="file" id="assinatura" class="position-absolute col-8 ml-n5 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this, 'assinatura')">
								<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" onclick="remover(this)"><i class="mdi mdi-close"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="checkbox checkbox-success text-white">
	                    <input id="checkbox-2" type="checkbox">
	                    <label for="checkbox-2"> Inserir outros arquivos? </label>
	                </div>
				</div>
				<div class="row col-12 mx-auto" id="outrosArquivos" style="display: none;">
					<hr class="col-5 border-muted">
					<div class="row col-12 px-0 mx-auto">
						<div class="col-6">
							<div class="form-group">
								<label class="col-form-label text-white">Tipo</label>
								<select class="form-control form-control-line px-3" name="pagina" id="pagina" style="border-radius: 10px">
									<option value="1" checked> Único</option> 
									<option value="2"> Juntar todos </option> 
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="col-form-label text-white">Orientação</label>
								<select class="form-control form-control-line px-3" name="orientacao" style="border-radius: 10px">
									<option value="portrait"> Retrato</option> 
									<option value="landscape"> Paisagem</option> 
								</select>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label class="col-form-label text-white">Outros</label>
							<div class="row totalArquivos">
								<div class="row col-12 justify-content-center mx-auto mb-2">
									<input type="text" class="form-control col-8 px-3 h-100" name="nomeArquivos[]" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo">
									<label for="fupload1" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px"><i class="mdi mdi-file"></i></label>
									<input type="file" id="fupload1" class="position-absolute offset-6 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="outros(this, 'outros')">
									<a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;" onclick="remover(this)"><i class="mdi mdi-close"></i></a>
								</div>
							</div>
						</div>
						<a href="javascript:" id="btnAdicionar" class="text-white"> <i class="ti-plus pr-2"></i> Adicionar mais arquivos</a>
					</div>
				</div>	
			</div>	
			<div class="row col-12 col-lg-12 mt-5 text-center mx-auto justify-content-center">
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
	// Para arquivos definidos
	function arquivo(input, name){
		if(input.value){
			var formData = new FormData();
	      	formData.append('_token', '{{csrf_token()}}');

		    if (input.files) {
		        for (i = 0; i < input.files.length; i++) {
		          formData.append('arquivos[]', input.files[i]);
		        }
		        $.ajax({
		          url: "{{ route('arquivo.digitalizar.enviar') }}",
		          type: 'POST',
		          data: formData,
		          processData: false,
		          contentType: false,
		          success: function(data){ 
		            $(input).prev('label').addClass('bg-success');
		            $(input).prev('label').append('<input type="hidden" name="'+name+'[]" value="'+data+'">');
		          }
		        });
		        $(input).val('');
		    }
		}else{
			$(input).prev('label').removeClass('bg-success');
		}	
	}
	function remover(input){
		$(input).val('');
		$(input).prev().prev().removeClass('bg-success');
		$(input).prev().prev().html('<i class="mdi mdi-file"></i>');
	}

	// Para outros arquivos
	function outros(input, name){
		if(input.value){
			var formData = new FormData();
	      	formData.append('_token', '{{csrf_token()}}');

		    if (input.files) {
		        for (i = 0; i < input.files.length; i++) {
		          formData.append('arquivos[]', input.files[i]);
		        }
		        $.ajax({
		          url: "{{ route('arquivo.digitalizar.enviar') }}",
		          type: 'POST',
		          data: formData,
		          processData: false,
		          contentType: false,
		          success: function(data){ 
		          	if( !($(input).prev().prev().val()) ){
						$(input).prev().prev().val('Arquivo');
					}
					$(input).prev().html('<i class="mdi mdi-sync"></i>');
					$(input).prev().addClass('bg-success');
		            $(input).prev('label').append('<input type="hidden" name="'+name+'[]" value="'+data+'">');
		          }
		        });
		        $(input).val('');
		    }
		}else{
			$(input).prev().html('<i class="mdi mdi-file"></i>');
			$(input).prev().removeClass('bg-success');
			$(input).prev().prev().val('');
		}
	}
	function deletar(input){
		$(input).parent('div').remove();
	}

	$(document).ready( function (){
		// Inserindo verso do documento de identificação
		$('#checkbox-1').on('click', function(){
			if($(this).prop('checked')){
				$('.identificao2').fadeIn();
			}else{
				$('.identificao2').fadeOut();
			}
		});

		// Inserindo outros arquivos
		$('#checkbox-2').on('click', function(){
			if($(this).prop('checked')){
				$('#outrosArquivos').fadeIn();
			}else{
				$('#outrosArquivos').fadeOut();
			}
		});

		// Abrindo carregamento ao enviar
		$('.form-sample').on('submit', function(){
			$('.preloader').fadeIn();
		});

		var t = 1;
		$('#btnAdicionar').on('click', function(){
			if($('#pagina').val() == 1){
				t++;
				$('.totalArquivos').append('<div class="row col-12 justify-content-center mx-auto mb-2"> <input type="text" class="form-control col-8 px-3 h-100" name="nomeArquivos[]" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" required> <label for="fupload'+t+'" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px"><i class="mdi mdi-file"></i></label> <input type="file" id="fupload'+t+'" class="mb-3 text-white col-lg-11 col-10 d-none" accept=".jpg, .jpeg, .png, .svg" onchange="outros(this, "outros")" required> <a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" onclick="deletar(this)" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-close"></i></a> </div>'); 
			}else{
				t++;
				$('.totalArquivos').append('<div class="row col-12 justify-content-center mx-auto mb-2"> <input type="text" class="form-control col-8 px-3 h-100" name="nomeArquivos[]" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" disabled> <label for="fupload'+t+'" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px"><i class="mdi mdi-file"></i></label> <input type="file" id="fupload'+t+'" class="mb-3 text-white col-lg-11 col-10 d-none" accept=".jpg, .jpeg, .png, .svg"  onchange="outros(this, "outros")" required> <a href="javascript:" title="Remover arquivos" class="btn btn-danger col-2" onclick="deletar(this)" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-close"></i></a> </div>'); 
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
	});
</script>
@endsection

@include('layouts.footer')
