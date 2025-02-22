@section('title')
Homepage
@endsection

@include('layouts.header')
<div class="col-12 h-100 position-absolute imagem" style="background: url({{ (isset($wallpapers[0]) ? asset('storage/app/').'/'.$wallpapers->last()->endereco : asset('public/img/home.png').'?'.rand())}})"></div>
<div class="container-fluid h-100 row justify-content-center mx-auto">
	<div class="col-12 row mx-auto px-5 pt-4">
		<div class="pt-3 row ml-auto dropdown pb-5 pb-lg-0" data-aos="fade-left">
			@if(Auth::check())
			<a href="{{route('inicio')}}" title="Início" target="_blank" class="text-white text-truncate my-auto font-weight-normal mx-3 pr-3">
            	<h5 class="text-white">Início</h5>
            </a>
            <a href="{{route('telefones')}}" title="Telefones" target="_blank" class="text-white text-truncate my-auto font-weight-normal mx-3">
            	<i class="mdi mdi-phone mdi-24px"></i>
            </a>
            <a href="{{route('digitalizar')}}" title="Digitalização" target="_blank" class="text-white text-truncate my-auto font-weight-normal mx-3">
            	<i class="mdi mdi-camera-party-mode mdi-24px pr-lg-1 px-3"></i>
            </a>
			<div class="dropdown dropdown-home mx-3 px-3">
				<a href="javascript::void(0)" title="Menu" class="dropdown-toggle my-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<h5 class="text-white">
						<i class="mdi mdi-apps mdi-24px"></i>
					</h5>
				</a>
				<ul class="dropdown-menu dropdown-menu-right animated flipInY text-center row p-4" style="width: 330px;border-radius: 5px;">
					@if(Auth::user()->RelationFuncao->ver_administrativo)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('dashboard.administrativo')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-city mdi-36px d-block"></i>
		                	<label class="text-truncate">Administrativo</label>
		                </a>
		            </li>
		            @endif
					<li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.base')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-book-open-page-variant mdi-36px d-block"></i>
		                	<label class="text-truncate">Aprendizagem</label>
		                </a>
		            </li>
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.painel.atendimento')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-account-outline mdi-36px d-block"></i>
		                	<label class="text-truncate">Atendimento</label>
		                </a>
		            </li>
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.chamados')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-hangouts mdi-36px d-block"></i>
		                	<label class="text-truncate">Chamados</label>
		                </a>
		            </li>	
		            @if(Auth::user()->RelationFuncao->ver_configuracoes)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('configuracoes')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-settings mdi-36px d-block"></i>
		                	<label class="text-truncate">Configurações</label>
		                </a>
		            </li>
		            @endif
		            @if(Auth::user()->RelationFuncao->ver_credito)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('dashboard.credito')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-currency-usd mdi-36px d-block"></i>
		                	<label class="text-truncate">Crédito</label>
		                </a>
		            </li>
		            @endif 
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.documentos')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-file-outline mdi-36px d-block"></i>
		                	<label class="text-truncate">Documentos</label>
		                </a>
		            </li>			
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('exibir.solicitacoes.materiais')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-cube-outline mdi-36px d-block"></i>
		                	<label class="text-truncate">Materiais</label>
		                </a>
		            </li>
		            @if(Auth::user()->RelationFuncao->ver_gti)
		            <li class="col-4 p-0 float-left">
		                <a href="{{route('dashboard.gti')}}" target="_blank" class="text-secondary px-2">
		                	<i class="mdi mdi-dns mdi-36px d-block"></i>
		                	<label class="text-truncate">Tecnologia</label>
		                </a>
		            </li>
		            @endif
	            </ul>
            </div>
            <div class="dropdown mx-3">
				<a href="javascript::void(0)" title="{{ (Auth::check() ? Auth::user()->nome : 'Faça seu login' )}}" class="dropdown-toggle my-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
		                <a href="{{route('perfil')}}" target="_blank">
		                    <i class="ti-user pr-2"></i> Meu perfil
		                </a>
		            </li>
		            <li>
		                <a href="{{route('atividades')}}" target="_blank" >
		                <i class="ti-layers-alt pr-2"></i> Minhas atividades
		                </a>
		            </li>
		            <li>
		                <a href="#" target="_blank">
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
			    <a href="{{route('telefones')}}" title="Telefones" target="_blank" class="text-white text-truncate my-auto font-weight-normal mx-3 pr-2">
	            	<i class="mdi mdi-phone mdi-24px px-3"></i>
	            </a>
	            <a href="{{route('digitalizar')}}" title="Digitalização" target="_blank" class="text-white text-truncate my-auto font-weight-normal mx-3 pr-2">
	            	<i class="mdi mdi-camera-party-mode mdi-24px pr-4"></i>
	            </a>
			    <a href="{{route('login')}}" target="_blank" class="btn btn-success btn-lg px-lg-5 my-auto">
		    		<i class="mdi mdi-account pr-1 visible-xs"></i>  
	        		<span class="hidden-xs">Entrar</span>
	        	</a>
	        @endif
	    </div>
    </div>
	<div class="col-12 col-sm-12 col-lg-12 mx-auto px-0 row pb-5">
		<img src="{{ asset('public/img/logo.png').'?'.rand() }}" class="mx-auto mt-3 col-lg-3 col-sm-5 col-10 h-100">
		<div class="row position-absolute text-white justify-content-end col-12 ml-auto mt-5 hidden-xs">
			@foreach($aniversariantes as $aniversariante)
				<div class="col-12 ml-auto justify-content-end text-right">
					<span class="mdi mdi-cake-variant"></span>
					<small>{{$aniversariante->nome}} &#183 {{date('d/m', strtotime($aniversariante->data_nascimento))}}</small>
				</div>
			@endforeach
		</div>
	</div>
	<div class="col-12 col-sm-12 col-lg-12 mx-auto py-5">
		<div class="col-sm-12 col-lg-8 mx-auto input-group input-search">
			<span class="input-group-addon bg-white" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
        	 	<i class="mdi mdi-magnify mdi-24px mdi-dark"></i>
        	 </span>
        	 <input type="text" class="form-control border-0"
        	  style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;padding: 21px;" placeholder="Encontre aqui o procura :)" id="txtBusca">
      	</div>
	</div>	
	<div class="col-12 col-sm-12 col-lg-10 mx-auto px-0 text-uppercase pt-4">
		<ul class="row justify-content-center h-100 pt-4 pl-0 p-lg-0 mb-0"  data-aos="fade-up" data-aos-easing="ease">
			@foreach($atalhos as $atalho)
			<li class="mb-5" style="height: 110px;width: 132px;">
				<a href="{{ url($atalho->endereco) }}" target="_blank" class="text-center">
					<div class="pb-3">
						<img src="{{ asset('storage/app/'.$atalho->RelationImagem->endereco) }}" class="rounded-circle bg-light p-2 mx-auto" style="height: 60px;width: 60px;">
					</div>
					<div>
						<label class="text-white font-weight-bold mb-0">{{$atalho->titulo}}</label>
					</div>
					<div>
						<label class="text-white">{{$atalho->subtitulo}}</label>
					</div>
				</a>
			</li>
			@endforeach
		</ul>
	</div>
	<div class="col-12 text-lg-right text-center position-absolute px-5 mx-lg-4 mx-auto py-4 hidden-xs" style="bottom: 0; right: 0;">
		<h5 class="text-weight-normal" style="font-family: system-ui;color: #9e9e9e !important;">{{str_replace('.sicoob.coop', '', gethostbyaddr($_SERVER['REMOTE_ADDR']))}}</h5>
		<h5 class="text-weight-normal" style="font-family: system-ui;color: #9e9e9e !important;">{{$_SERVER['REMOTE_ADDR']}}</h5>
	</div>
	<div class="col-12 text-lg-right text-center px-5 mx-lg-4 mx-auto visible-xs" style="bottom: 0; right: 0;">
		<h5 class="text-weight-normal" style="font-family: system-ui;color: #9e9e9e !important;">{{str_replace('.sicoob.coop', '', gethostbyaddr($_SERVER['REMOTE_ADDR']))}}</h5>
		<h5 class="text-weight-normal" style="font-family: system-ui;color: #9e9e9e !important;">{{$_SERVER['REMOTE_ADDR']}}</h5>
	</div>
</div>

@include('layouts.footer')

<script type="text/javascript">
	$(function(){
		AOS.init();
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

