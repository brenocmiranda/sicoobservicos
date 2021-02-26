@section('title')
Página inicial
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid home mx-auto">
	 <section class="section h-100">
        <div class="col-12 h-100 row mx-auto align-items-center">
        	<div class="col-lg-6 col-12 m-auto">
        		<div class="mb-5 d-flex">
        			<div>
			        	<h1 class="mb-3 text-dark">Olá, {{explode(" ", ucfirst(strtolower(Auth::user()->RelationAssociado->nome)))[0]}}!</h1>
			        	<h6 class="font-weight-normal">Seja bem-vindo a plataforma <b>Sicoob Serviços</b></h6>
			        	<h6 class="font-weight-normal"><b>Último acesso:</b> {{(isset(Auth::user()->RelationAtividades) ? date_format(Auth::user()->RelationAtividades->created_at, "d/m/Y H:i:s") : '')}} - {{(isset(Auth::user()->RelationAtividades) ? @Auth::user()->RelationAtividades->created_at->subMinutes(2)->diffForHumans() : '')}}</h6>
			        </div>
		        	<div class="ml-auto d-none d-lg-block d-sm-block">
		        		<img class="rounded-circle shadow" id="PreviewImage" src="{{(isset(Auth::user()->RelationImagem) ? asset('storage/app/'.Auth::user()->RelationImagem->endereco) : asset('public/img/user.png'))}}" style="height: 120px;width: 120px;">
		        	</div>
		        </div>
	        	<hr>
	        	<div>
	        		<label class="font-weight-bold pb-3 d-block">Novos tópicos disponíveis &#183 <a href="{{route('exibir.base')}}"><small>Saiba mais!</small></a></label>
	        		@if(isset($base[0]))
	        			<ul class="col-12 ml-3">
	        				@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
				        		@foreach($base as $b)
				        			<li class="pb-2" style="list-style: disc;" >
				        				<a href="{{route('detalhes.base', $b->id)}}">
				        					<span class="text-truncate d-block">
				        						<small>{{(date('Y-m-d H:i:s', strtotime('+15 days')) <= $b->created_at ? date('d/m/Y', strtotime($b->created_at)) : date('d/m/Y', strtotime($b->updated_at)))}} &#183</small>
				        						<span>{{$b->titulo}}</span>
				        					</span> 
				        				</a>
				        			</li>
				        		@endforeach
				        	@else
				        		@if(count($base->where('tipo', 'externo')) > 0)
					        		@foreach($base->where('tipo', 'externo') as $b)
					        			<li class="pb-2" style="list-style: disc;" >
					        				<a href="{{route('detalhes.base', $b->id)}}">
					        					<span class="text-truncate d-block">
					        						<small>{{(date('Y-m-d H:i:s', strtotime('+15 days')) <= $b->created_at ? date('d/m/Y', strtotime($b->created_at)) : date('d/m/Y', strtotime($b->updated_at)))}} &#183</small>
					        						<span>{{$b->titulo}}</span>
					        					</span> 
					        				</a>
					        			</li>
					        		@endforeach
					        	@else
									<label>Opss! Nenhum novo tópico cadastrado.</label>
					        	@endif
				        	@endif
			        	</ul>
		        	@else
		        		<label>Opss! Nenhum novo tópico cadastrado.</label>
		        	@endif
	        	</div>
	        </div>
        </div>
    </section>
</div>
@endsection