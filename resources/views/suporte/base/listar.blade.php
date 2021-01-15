	@section('title')
Tópicos
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Base de conhecimento</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Suporte</a></li>
				<li><a href="{{route('exibir.base')}}">Aprendizagem</a></li>
				<li class="active">Tópicos</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body mb-4">
			<div class="col-12 px-0">
				<div class="col-12 row mx-auto">
					<div class="col-lg-8 col-12 mx-auto">
						<input type="search" class="form-control rounded" placeholder="Encontre rapidamente o que procura :)">
					</div>
				</div>
				<div class="row col-12 mx-4 pt-4">
					<h4>{{$fonte->nome}} &#183 <h5 class="pl-2 my-auto">{{$tipo->nome}}</h5></h4>
				</div>
				<hr class="mx-5 mt-1">
				@if(!empty($todos[0]))
					<ul class="row col-12 m-auto p-0 " id="tipos">
						@foreach($todos as $todos)
							<li class="col-12 px-0 px-lg-5">
								<a href="{{route('detalhes.base', $todos->id)}}">
									<div class="row col-12 m-2">
										<div class="col-2 col-lg-1 py-2 px-3 my-auto border rounded text-center">
											<i class="mdi mdi-bookmark-outline mdi-24px"></i>
										</div>
										<div class="col-10 pl-3 my-auto">
											<h5 class="mb-1 text-primary">{{$todos->titulo}}</h5>
											<small>{{$todos->subtitulo}}</small>
										</div>								
									</div>
								</a>
							</li>
						@endforeach
					</ul>
					<div class="row mx-auto col-12 mt-4">
						<a href="javascript:history.back()" class="btn btn-outline btn-danger col-lg-3 col-6 mx-auto mt-4">
							<i class="mdi mdi-arrow-left"></i>
							<span>Voltar</span>
						</a>
					</div>
				@else
					<div class="row mx-auto col-12 p-0">
						<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> A sua instituição não possui nenhum tópico cadastrado para essa fonte.</label>
					</div>
					<hr>
					<div class="row mx-auto col-12">
						<a href="javascript:history.back()" class="btn btn-outline btn-danger col-lg-3 col-6 mx-auto">
							<i class="mdi mdi-arrow-left"></i>
							<span>Voltar</span>
						</a>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#tipos li").css("display", "block");
			$("#tipos li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});
	});
</script>
@endsection