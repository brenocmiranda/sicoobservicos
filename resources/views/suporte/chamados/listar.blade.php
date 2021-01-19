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
				<div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
					<a href="{{route('abertura.chamados')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Abrir novo chamado">
						<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
						<span class="hidden-xs">Novo chamado</span>
					</a>
				</div>
			</div>
			
			<section class="py-4">
				<div class="sttabs tabs-style-linetriangle row justify-content-center mx-auto">
                    <nav class="col-lg-8 col-12 mx-auto px-0">
						<ul>
							@foreach($statusAtivos as $status)
							<li class="{{($status->id == 1 ? 'tab-current' : '')}}">
								<a href="#section-{{$status->id}}">
									<span class="font-weight-bold d-block">{{$status->nome}}</span>
								</a>
							</li>
							@endforeach
						</ul>
					</nav>
					<div class="content-wrap col-12 p-0">
						<?php $i=0; ?>
						@foreach($statusAtivos as $status)
						<section id="section-{{$status->id}}" class="px-0 px-lg-5">
							<ul class="row col-12 m-auto px-0">
								@foreach($chamados as $chamado)
								@if($chamado->RelationStatus->first()->id == $status->id)
								<li class="col-12 border rounded shadow-sm mb-3">
									<div class="p-3 h-100 row">
										<div class="text-left col-lg-6 col-8">
											<a href="{{route('detalhes.chamados', $chamado->id)}}">
												<h5 class="text-uppercase mb-2 text-truncate">
													<span>{{$chamado->RelationAmbientes->nome}}</span> 
													<b>&#183</b> 
													<span>{{$chamado->RelationFontes->nome}}</span>
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
										<div class="text-right row col-lg-3 col-4 ml-auto">
											<div class="ml-auto">
												<a href="{{route('detalhes.chamados', $chamado->id)}}" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Detalhes do chamado">
													<i class="mdi mdi-comment-processing-outline"></i>
													<small class="hidden-xs">Mais informações</small>
												</a>	
												@if($chamado->RelationStatus->first()->finish == 1)
												<a href="javascript:void(0)" id="{{$chamado->id}}" class="btn-reabrir btn btn-default btn-outline btn-rounded col-10 mb-2" title="Detalhes do chamado">
													<i class="mdi mdi-comment-processing-outline"></i>
													<small class="hidden-xs">Reabrir chamado</small>
												</a>
												@endif
												<a href="{{route('relatorio.chamados', $chamado->id)}}" target="_blank" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Relatório do chamado">
													<i class="mdi mdi-cloud-print-outline"></i>
													<small class="hidden-xs">Gerar relatório</small>
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
								<h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhum chamado nesse estado.</h5>
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

@section('modal')
  @include('suporte.chamados.reabertura')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		$('.btn-reabrir').on('click', function(e){
		    $('#modal-reabertura .identificador').val($(this).attr('id'));
		    $('#modal-reabertura').modal('show');		    
		});

		$('#modal-reabertura #formReabertura').on('submit', function(e){
	      // Finalizar chamado
	      e.preventDefault();
	      $.ajax({
	        url: 'chamados/reabrir/'+$('#modal-reabertura .identificador').val(),
	        type: 'POST',
	        data: $('#modal-reabertura #formReabertura').serialize(),
	        beforeSend: function(){
	          $('.modal-body, .modal-footer').addClass('d-none');
	          $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
	          $('#modal-reabertura #err').html('');
	        },
	        success: function(data){
	          $('.modal-body, .modal-footer').addClass('d-none');
	          $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
	          setTimeout(function(){
	            location.reload();
	          }, 1000);
	        }, error: function (data) {
	          setTimeout(function(){
	            $('.modal-body, .modal-footer').removeClass('d-none');
	            $('.carregamento').html('');
	            if(!data.responseJSON){
	              console.log(data.responseText);
	              $('#modal-reabertura #err').html(data.responseText);
	            }else{
	              $('#modal-reabertura #err').html('');
	              $('input').removeClass('border-bottom border-danger');
	              $.each(data.responseJSON.errors, function(key, value){
	                $('#modal-reabertura #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
	                $('input[name="'+key+'"]').addClass('border-bottom border-danger');
	              });
	            }
	          }, 2000);
	        }
	      });
	    });
	});
</script>
@endsection