@section('title')
Dashboard PowerBi
@endsection

@include('layouts.header')

@include('layouts.preloader')
<div class="col-12 h-100 position-absolute imagem" style="background: url({{ (isset($homepage[0]) ? asset('storage/app/').'/'.$homepage->last()->endereco : asset('public/img/home.png').'?'.rand())}})"></div>
	<div class="container-fluid h-100 row justify-content-center mx-auto">
		<div class="col-12 row mx-auto px-lg-5 pt-5">
			<div class="col-lg-5 col-sm-4 col-6 px-0 row">
				<img src="{{ asset('public/img/logo.png').'?'.rand() }}" class="col-lg-4 col-sm-6 col-xl-4 col-12 px-0 h-75 h-lg-100">
			</div>
			<div class="row ml-auto dropdown pb-5 pb-lg-0">
				@if(Auth::check())
				<div class="row ml-auto pb-lg-0">
					<a href="{{route('inicio')}}" title="Início" target="_blank" class="text-white text-truncate mt-2 font-weight-normal mx-3 pr-2">
		            	<h5 class="text-white">Início</h5>
		            </a>
					<a href="{{route('homepage')}}" class="text-truncate mb-auto font-weight-normal px-3">
		            	<h5 class="text-white">
		            		<i class="mdi mdi-home-outline mdi-24px pr-1"></i>  
		            	</h5>
		            </a>
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
			    </div>
			    @else
			    	<a href="{{route('homepage')}}" class="text-truncate my-auto font-weight-normal px-4">
		            	<h5 class="text-white">
		            		<i class="mdi mdi-home-outline mdi-24px pr-1"></i>  
		            	</h5>
		            </a>
			    	<a href="{{route('login')}}" target="_blank" class="btn btn-success btn-lg px-lg-5 my-auto">
			    		<i class="mdi mdi-account pr-1 visible-xs"></i>  
		        		<span class="hidden-xs">Entrar</span>
		        	</a>
			    @endif
			</div>
	    </div>
		
		<div class="row col-12 col-sm-11 col-lg-11 mx-auto py-5 justify-content-center text-left">
			<iframe width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=11c41110-19ad-4bdc-8014-eb08f0d2f888&autoAuth=true&ctid=17664542-f665-4052-ba73-1e359bec3de0&config=eyJjbHVzdGVyVXJsIjoiaHR0cHM6Ly93YWJpLWJyYXppbC1zb3V0aC1iLXByaW1hcnktcmVkaXJlY3QuYW5hbHlzaXMud2luZG93cy5uZXQvIn0%3D" frameborder="0" allowFullScreen="true"></iframe>
		</div>	
	</div>
</div>

@include('layouts.footer')
