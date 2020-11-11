@section('title')
Página inicial
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid home mx-auto">
	 <section class="section h-100">
        <div class="col-12 h-100 d-flex align-items-center">
        	<div class="col-6 m-auto">
        		<div class="mb-5 d-flex">
        			<div>
			        	<h1 class="mb-3 text-dark">Olá, {{explode(" ", ucfirst(strtolower(Auth::user()->RelationAssociado->nome)))[0]}}!</h1>
			        	<h6 class="font-weight-normal">Seja bem-vindo a plataforma <b>Sicoob Serviços</b></h6>
			        	<h6 class="font-weight-normal"><b>Último acesso:</b> {{(isset(Auth::user()->RelationAtividades) ? date_format(Auth::user()->RelationAtividades->created_at, "d/m/Y H:i:s") : '')}} - {{(isset(Auth::user()->RelationAtividades) ? @Auth::user()->RelationAtividades->created_at->subMinutes(2)->diffForHumans() : '')}}</h6>
			        </div>
		        	<div class="ml-auto">
		        		<img class="rounded-circle" id="PreviewImage" src="{{(isset(Auth::user()->RelationImagem) ? asset('storage/app/'.Auth::user()->RelationImagem->endereco) : asset('public/img/user.png'))}}" style="height: 120px;width: 120px;">
		        	</div>
		        </div>
	        	<hr>
	        	<div>
	        		<label class="font-weight-bold pb-3 d-block">Novos tópicos disponíveis:</label>
	        		<ul style="list-style: circle;" class="col-12 ml-3">
	        		@foreach($base as $b)
	        			<li class="pb-2"><a href="{{route('detalhes.base', $b->id)}}" class="text-truncate">{{$b->titulo}} <small>({{date('d/m/Y', strtotime($b->created_at))}})</small></a></li>
	        		@endforeach
	        		</ul>
	        	</div>
	        </div>
        </div>
    </section>
</div>
@endsection