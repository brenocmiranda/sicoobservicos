@section('title')
Chamados
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Meus Chamados</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Suporte</a></li>
				<li class="active">Meus chamados</li>
			</ol>
		</div>
	</div>
	<div class="confim"></div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mb-4 mx-auto">
				@include('layouts.search')
				<div class="col-5 p-0 row mx-auto">
					<a href="{{route('abertura.chamados')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Abrir novo chamado">
						<i class="m-0 pr-1 mdi mdi-plus"></i> 
						<span>Novo chamado</span>
					</a>
				</div>
			</div>
			
			<section class="py-4">
				<div class="sttabs tabs-style-linetriangle">
                    <nav class="col-10 mx-auto">
						<ul>
							@foreach($statusAtivos as $status)
							<li class="{{($status->id == 1 ? 'tab-current' : '')}}">
								<a href="#section-{{$status->id}}">
									<span>{{$status->nome}}</span>
								</a>
							</li>
							@endforeach
						</ul>
					</nav>
					<div class="content-wrap">
						<?php $i=0; ?>
						@foreach($statusAtivos as $status)
						<section id="section-{{$status->id}}">
							<ul class="row col-12 m-auto">
								@foreach($chamados as $chamado)
								@if($chamado->RelationStatus->first()->id == $status->id)
								<li class="col-12 border rounded shadow-sm mb-3">
									<div class="p-3 h-100 row">
										<div class="text-left col-6">
											<a href="{{route('detalhes.chamados', $chamado->id)}}">
												<h5 class="text-uppercase mb-2 text-truncate">
													<span>{{$chamado->RelationFontes->nome}}</span> 
													<b>&#183</b> 
													<span>{{$chamado->RelationTipos->nome}}</span>
													<div class="badge mx-2" style="background: {{$chamado->RelationStatus->first()->color}}">{{$chamado->RelationStatus->first()->nome}}</div>

												</h5>
											</a>
											<label class="text-truncate d-block mb-0">
													<small class="text-dark"><b>Nº do chamado</b>: {{$chamado->id}}</small>
												</label>
											<label class="text-truncate d-block mb-0">
												<small class="text-dark"><b>Assunto</b>: {{$chamado->assunto}}</small>
											</label>
											<label class="text-truncate d-block mb-0">
												<small class="text-dark"><b>Descrição:</b> {{(isset($chamado->descricao) ? $chamado->descricao : '-')}}</small>
											</label>	
											<label class="text-truncate d-block mb-0">
												<small class="text-dark"><b>Data de abertura:</b> {{$chamado->created_at->format('d/m/Y H:i')}}</small>
											</label>
											@if($chamado->RelationStatus->first()->finish == 1)
											<label class="text-truncate d-block">
												<small class="text-dark"><b>Data de fechamento:</b> {{$chamado->RelationStatus->first()->pivot->created_at->format('d/m/Y H:i')}}</small>
											</label>	
											@endif				
										</div>
										<div class="text-right row col-3 ml-auto">
											<div class="ml-auto">
												<a href="{{route('detalhes.chamados.gti', $chamado->id)}}" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Detalhes do chamado">
													<i class="mdi mdi-comment-processing-outline"></i>
													<small>	Mais informações</small>
												</a>	
												@if($chamado->RelationStatus->first()->finish == 1)
												<a href="javascript:void(0)" data="{{route('reabertura.chamados', $chamado->id)}}" class="btn-reabrir btn btn-default btn-outline btn-rounded col-10" title="Detalhes do chamado">
													<i class="mdi mdi-comment-processing-outline"></i>
													<small>	Reabrir chamado</small>
												</a>
												@endif
												<a href="{{route('relatorio.chamados.gti', $chamado->id)}}" target="_blank" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Relatório do chamado">
													<i class="mdi mdi-cloud-print-outline"></i>
													<small>	Gerar relatório</small>
												</a>
											</div>
										</div>
									</div>
								</li>
								<?php $i++; ?>
								@endif
								@endforeach
							</ul>
							@if($i == 0)
							<p class="col-12">
								<h5 class="text-center font-weight-normal">Você não possui nenhum chamado nesse estado.</h5>
							</p>
							@else
							<?php $i=0; ?>
							@endif
						</section>
						@endforeach
					</div>
					<!-- /content -->
				</div>
				<!-- /tabs -->
			</section>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		$('.btn-reabrir').on('click', function(e){
		    // Removendo status do chamado
		    var id = this.id;
		    var url = $(this).attr('data');
		    swal({
		    	title: "Tem certeza que deseja reabrir o chamado?",
		    	icon: "warning",
		    	buttons: ["Cancelar", "Reabrir"],
		    })
		    .then((willDelete) => {
		    	if (willDelete) {
		    		$.get(url, function(data){
		    			if(data.success == true){
		    				swal("Chamado reaberto com sucesso!", {
		    					icon: "success",
		    					button: false
		    				});
		    				location.reload();
		    			}else{
		    				swal("Não foi possível reabrir o chamado!", {
		    					icon: "error",
		    				});
		    			}
		    		});
		    	} else {
		    		swal.close();
		    	}
		    });
		});
	});
</script>
@endsection