@section('title')
Meu perfil
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Meu perfil</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('inicio')}}">Home</a></li>
				<li class="active">Perfil</li>
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

	<ul class="nav customtab nav-tabs px-2" role="tablist">
        <li role="presentation" class="active">
        	<a href="#geral" aria-controls="geral" role="tab" data-toggle="tab" aria-expanded="true">
        		<span class="visible-xs">
        			<i class="ti-home"></i>
        		</span>
        		<span class="hidden-xs">Geral</span>
        	</a>
        </li>
        <li role="presentation" class="">
        	<a href="#admin" aria-controls="admin" role="tab" data-toggle="tab" aria-expanded="false">
        		<span class="visible-xs">
        			<i class="ti-user"></i>
        		</span> 
        		<span class="hidden-xs">Administrativo</span>
        	</a>
        </li>
    </ul>

	<form class="form-sample" method="POST" action="{{ route('perfil.salvar') }}" enctype="multipart/form-data" autocomplete="off">
		@csrf
		<div class="row">

			<div class="col-7">
				<div class="card">
					<div class="card-body">
						<div class="tab-content mt-0">
	                        <div role="tabpanel" class="tab-pane fade active in" id="geral">
	                            <div class="col-12">
									<div class="form-group">
										<label class="col-12 col-form-label">Nome:</label>
										<div class="col-12">
											<input class="nome form-control form-control-line" value="{{$usuario->RelationAssociado->nome}}" name="nome" disabled/>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label class="col-12 col-form-label">CPF:</label>
										<div class="col-7">
											<input class="cpf form-control form-control-line" name="cpf" placeholder="000.000.000-00" value="{{$usuario->RelationAssociado->documento}}" disabled/>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label class="col-12 col-form-label">E-mail <i class="text-danger">*</i></label>
										<div class="col-12">
											<input type="email" class="form-control form-control-line" name="email" placeholder="ti@sicoobsertaominas.com.br" value="{{ @$usuario->email }}" autocomplete="off" required/>
										</div>
									</div>
								</div>
								<div class="col-8">
									<div class="form-group">
										<label class="col-12 col-form-label">Login <i class="text-danger">*</i></label>
										<div class="col-12">
											<input type="text" class="form-control form-control-line" name="login" value="{{$usuario->login}}" autocomplete="off" disabled/>
									
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label class="col-12 col-form-label">Telefone <i class="text-danger">*</i></label>
										<div class="col-12">
											<input type="text" class="telefone form-control form-control-line" name="telefone" placeholder="(99) 99999-9999" value="{{ @$usuario->telefone }}"/>
										</div>
									</div>
								</div>

								<div class="col-12 mx-4">
									<a href="javascript:void(0)" id="password"> 
										<span>Alterar senha</span>
										<i class="ti-angle-down"></i>
									</a>
								</div>
								
								<div class="row col row-none d-none mt-3">
									<hr class="col-12">
									<div class="col-8">
										<div class="form-group">
											<label class="col-12 col-form-label">Senha <i class="text-danger">*</i></label>
											<div class="col-12">
												<div class="input-group">
													<input type="password" class="form-control form-control-line" name="password" placeholder="*********" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" />
												</div>
											</div>
										</div>
									</div>
									<div class="col-8">
										<div class="form-group">
											<label class="col-12 col-form-label">Confirmação de senha <i class="text-danger">*</i></label>
											<div class="col-12">
												<div class="input-group">
													<input type="password" class="form-control form-control-line" name="password_confirmation" placeholder="*********" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" />
												</div>
											</div>
										</div>
									</div>
								</div>
	                        </div>

	                        <div role="tabpanel" class="tab-pane fade" id="admin">
	                            <div class="col-12">
									<div class="form-group">
										<label class="col-12 col-form-label">Instituição:</label>
										<div class="col-12">
											<input class="form-control form-control-line" value="{{$usuario->RelationInstituicao->nome}}" name="nome" disabled/>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label class="col-12 col-form-label">Unidade:</label>
										<div class="col-10">
											<input class="form-control form-control-line" value="{{$usuario->RelationUnidade->nome}}" name="nome" disabled/>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label class="col-12 col-form-label">Setor:</label>
										<div class="col-8">
											<input class="form-control form-control-line" value="{{$usuario->RelationSetor->nome}}" name="nome" disabled/>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label class="col-12 col-form-label">Função:</label>
										<div class="col-7">
											<input class="form-control form-control-line" value="{{$usuario->RelationFuncao->nome}}" name="nome" disabled/>
										</div>
									</div>
								</div>
	                        </div>
	                    </div>

						<div class="col-lg-12 text-center my-4">
							<button type="submit" class="btn btn-success btn-lg col-4">
								<span>Atualizar</span>
								
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-5 pl-0">
				<div class="card p-0">
					<div class="card-body p-0">
						<div class="row mx-auto rounded">
							<img src="{{asset('public/img/fundo-dark.png').'?'.rand()}}" class="w-100 rounded position-absolute" height="350" style="filter: brightness(0.5);">
							<div class="col-sm-12 text-center mx-auto h-100">
								<div class="mt-5 col-sm-12">
									<img src="{{(isset(Auth::user()->RelationImagem) ? asset('storage/app/'.Auth::user()->RelationImagem->endereco).'?'.rand() : asset('public/img/user.png').'/'.rand())}}" class="mt-5 rounded-circle" id="PreviewImage" width="130" height="130">
									<div class="mx-auto btn-image rounded-circle position-relative">
										<input type="file" class="px-0 position-absolute m-auto" accept=".png, .jpg, .jpeg" name="upload_img" id="upload_img" onchange="image(this);">
									</div>
								</div>
								<div class="col-sm-12">
									<h4 class="text-white font-weight-bolder mb-2">{{$usuario->RelationAssociado->nome}}</h4>
									<h6 class="text-white my-2">{{$usuario->RelationInstituicao->nome}}</h6>
									<small class="designation text-white">{{ $usuario->RelationUnidade->nome }}</small>
								</div>
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
		$('#password').on('click', function(){
			if($('.row-none').hasClass('d-none')){
				$('.row-none').removeClass('d-none');
			}else{
				$('.row-none').addClass('d-none');
			}
		});
		$('.cpf').mask('000.000.000-00', {reverse: true});
		$('.telefone').mask('(00) 00000-0000');
	});
</script>
@endsection