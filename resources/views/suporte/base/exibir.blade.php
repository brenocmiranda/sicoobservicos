@section('title')
Aprendizagem
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
				<li><a class="active">Aprendizagem</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 p-0">
				<div class="col-12 row mx-auto">
					<div class="col-12 col-lg-8 mx-auto">
						<input type="search" class="form-control rounded" placeholder="Encontre rapidamente o que procura :)">
					</div>
				</div>
				<div class="row col-12 mx-auto mt-5 p-0">
					@if(isset($ambientes[0]))
						<div class="vtabs customvtab w-100">
	                        <ul class="nav tabs-vertical"  id="ambientes" style="width: 30%;">
	                        	@foreach($ambientes as $ambiente)
									<li class="tab p-0 {{($ambiente->id == $ambientes->first()->id ? ' active' : '')}}">
										<a data-toggle="tab" href="#section{{$ambiente->id}}"  aria-expanded="true" class="m-0">
											<div class="border rounded shadow-sm">
												<div class="col-12 py-3">
													<div class="text-uppercase text-center">
														<h5 class="mb-2">{{$ambiente->nome}}</h5>
													</div>
												</div>
											</div>
										</a>
									</li>
								@endforeach
							</ul>
	                        <div class="tab-content">
	                        	<?php $i=0; ?> 
	                        	@foreach($ambientes as $ambiente)
		                            <div id="section{{$ambiente->id}}" class="tab-pane {{($ambiente->id == $ambientes->first()->id ? ' active' : '')}}">
		                                <div class="col-12">
		                                	<div class="mx-4">
			                                	<h4 class="mb-3">{{$ambiente->nome}}</h4> 
			                                	<label>{{(isset($ambiente->descricao) ? $ambiente->descricao : 'SEM DESCRIÇÃO CADASTRADA')}}</label>
		                                	</div>
		                                </div>
		                                <hr class="mt-3 mx-5">
		                                <div class="col-12">
		                                    <ul id="fontes">
		                                    	@foreach($fontes as $fonte)
		                                    		@if($fonte->gti_id_ambientes == $ambiente->id)
			                                    		<a href="{{route('listar.base', [$ambiente->id, $fonte->id])}}">
			                                    			<li style="list-style: disc" class="pb-3">{{$fonte->nome}}</li>
			                                    		</a>	        
			                                    		<?php $i++; ?>                            		
		                                    		@endif
		                                    	@endforeach
		                                    </ul>
		                                    @if($i == 0)
	                                    		<p class="col-12">Essa modalidade não possui nenhum item cadastrado para consulta.</p>
	                                    	@else
	                                    		<?php $i=0; ?>
	                                    	@endif
		                                </div>
		                                <div class="clearfix"></div>
		                            </div>
	                            @endforeach
	                        </div>
	                    </div>
                    @else
                    	<div class="row mx-auto w-100">
							<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i>A sua instituição não possui nenhum tópico cadastrado até o momento.</label>
						</div>
                    @endif
				</div>
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
			$("#ambientes li").css("display", "block");
			$("#ambientes li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});
	});
</script>
@endsection