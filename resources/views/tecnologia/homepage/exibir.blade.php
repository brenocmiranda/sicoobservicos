@section('title')
Homepage
@endsection

@include('layouts.header')
<div class="col-12 h-100 position-absolute imagem" style="background: url({{ (isset($homepage[0]) ? asset('storage/app/').'/'.$homepage->last()->endereco : asset('public/img/home.png').'?'.rand())}})"></div>
<div class="container-fluid h-100 row justify-content-center mx-auto">
	<div class="col-12 row mx-auto px-5 pt-4">
		<div class="pt-3 row ml-auto dropdown pb-5 pb-lg-0">
			@if(Auth::check())
			<a href="{{route('inicio')}}" class="text-white text-truncate my-auto font-weight-normal mx-3">
            	<h5 class="text-white">Início</h5>
            </a>
			<div class="dropdown dropdown-home mx-3 px-3">
				<a href="javascript::void(0)" class="dropdown-toggle my-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<h5 class="text-white">
						<i class="mdi mdi-apps mdi-24px"></i>
					</h5>
				</a>
				<ul class="dropdown-menu dropdown-menu-right animated flipInY text-center row p-4" style="width: 330px;border-radius: 5px;">
					@if(Auth::user()->RelationFuncao->ver_administrativo)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('dashboard.administrativo')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-city mdi-36px d-block"></i>
		                	<label class="text-truncate">Administrativo</label>
		                </a>
		            </li>
		            @endif
					<li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.base')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-book-open-page-variant mdi-36px d-block"></i>
		                	<label class="text-truncate">Aprendizagem</label>
		                </a>
		            </li>
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.painel.atendimento')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-account-outline mdi-36px d-block"></i>
		                	<label class="text-truncate">Atendimento</label>
		                </a>
		            </li>
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.chamados')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-hangouts mdi-36px d-block"></i>
		                	<label class="text-truncate">Chamados</label>
		                </a>
		            </li>	
		            @if(Auth::user()->RelationFuncao->ver_configuracoes)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('configuracoes')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-settings mdi-36px d-block"></i>
		                	<label class="text-truncate">Configurações</label>
		                </a>
		            </li>
		            @endif
		            @if(Auth::user()->RelationFuncao->ver_credito)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('dashboard.credito')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-currency-usd mdi-36px d-block"></i>
		                	<label class="text-truncate">Crédito</label>
		                </a>
		            </li>
		            @endif 
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.documentos')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-file-outline mdi-36px d-block"></i>
		                	<label class="text-truncate">Documentos</label>
		                </a>
		            </li>			
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.solicitacoes.materiais')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-cube-outline mdi-36px d-block"></i>
		                	<label class="text-truncate">Materiais</label>
		                </a>
		            </li>
		            @if(Auth::user()->RelationFuncao->ver_gti)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('dashboard.gti')}}" class="text-secondary px-2">
		                	<i class="mdi mdi-dns mdi-36px d-block"></i>
		                	<label class="text-truncate">Tecnologia</label>
		                </a>
		            </li>
		            @endif
	            </ul>
            </div>
            <div class="dropdown mx-3">
				<a href="javascript::void(0)" class="dropdown-toggle my-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
					<img src="{{ (Auth::check() ? asset('storage/app/'.Auth::user()->RelationImagem->endereco).'?'.rand() : asset('public/img/user.png').'?'.rand() )}}" alt="{{ (Auth::check() ? Auth::user()->nome : 'Faça seu login' )}}" width="46" height="46" class="img-circle">
			    </a>
			    <ul class="dropdown-menu dropdown-user dropdown-menu-right animated flipInY" style="width: 300px;border-radius: 5px;">
		            <li>
		                <div class="dw-user-box row col-12 mx-auto my-4">
		                    <div class="col-4 p-0 u-img"><img src="{{ asset('storage/app/'.Auth::user()->RelationImagem->endereco) }}" alt="user" width="80" class="rounded" /></div>
		                    <div class="col-8 pr-0 pl-2 u-text">
		                        <h4 class="text-capitalize text-truncate">{{explode(" ", Auth::user()->RelationAssociado->nome)[0]}}</h4>
		                        <p class="text-muted mb-0">{{ strtolower(Auth::user()->login) }}</p>
		                    </div>
		                </div>
		            </li>
		            <li role="separator" class="divider"></li>
		            <li>
		                <a href="{{route('perfil')}}">
		                    <i class="ti-user pr-2"></i> Meu perfil
		                </a>
		            </li>
		            <li>
		                <a href="#">
		                <i class="ti-layers-alt pr-2"></i> Minhas atividades
		                </a>
		            </li>
		            <li>
		                <a href="#">
		                <i class="ti-comment-alt pr-2"></i> Minhas notificações
		                </a>
		            </li>            

		            <li role="separator" class="divider"></li>

		            <li>
		                <a href="javascript:void(0)" class="logout">
		                    <i class="fa fa-power-off pr-2"></i> Sair
		                </a>
		            </li>
		        </ul>    
		    </div>
		    @else
	        	<a href="{{route('login')}}" class="btn btn-success rounded btn-lg px-5">
	        		<span>Fazer login</span>
	        	</a>
	        @endif
	    </div>
    </div>
	<div class="col-9 col-sm-9 col-lg-9 mx-auto px-0 row pb-5">
		<img src="{{ asset('public/img/logo.png').'?'.rand() }}" class="mx-auto mt-3 w-100 col-lg-4 col-sm-6 col-12 w-100">
	</div>
	<div class="col-12 col-sm-12 col-lg-12 mx-auto py-5">
		<div class="col-sm-12 col-lg-8 mx-auto input-group input-search">
			<span class="input-group-addon bg-white" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
        	 	<i class="mdi mdi-magnify mdi-24px mdi-dark"></i>
        	 </span>
        	 <input type="email" class="form-control border-0"
        	  style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;padding: 21px;" placeholder="Pesquise..." id="txtBusca">
      	</div>
	</div>	
	<div class="col-12 col-sm-12 col-lg-10 mx-auto px-0 text-uppercase pt-4">
		<ul class="row justify-content-center h-100 pt-4 pl-0 p-lg-0 mb-0">
			@foreach($homepages as $homepage)
			<li class="mb-5" style="height: 110px;width: 132px;">
				<a href="{{ url($homepage->endereco) }}" target="_blank" class="text-center">
					<div class="pb-3">
						<img src="{{ asset('storage/app/'.$homepage->RelationImagem->endereco) }}" class="rounded-circle bg-light p-2" style="height: 60px;width: 60px;">
					</div>
					<div>
						<label class="text-white font-weight-bold mb-0">{{$homepage->titulo}}</label>
					</div>
					<div>
						<label class="text-white">{{$homepage->subtitulo}}</label>
					</div>
				</a>
			</li>
			@endforeach
		</ul>
	</div>
</div>

@include('layouts.footer')

<script type="text/javascript">
	$(function(){
	    $("#txtBusca").keyup(function(){
	        var texto = $(this).val().toUpperCase();
	         
	        $("ul li").css("display", "block");
	        $("ul li").each(function(){
	            if($(this).text().indexOf(texto) < 0)
	               $(this).css("display", "none");
	        });
	    });
	});
</script>

