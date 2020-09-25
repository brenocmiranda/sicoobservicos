@section('title')
Solicitações
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Solicitações de suporte</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">GTI</a></li>
				<li class="active">Solicitações</li>
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
			
			@if(!empty($chamados[0]))
			<section class="py-4">
				<div class="sttabs tabs-style-linebox">
                    <nav>
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
                        <section id="section-{{$status->id}}" class="{{($status->id == 1 ? 'content-current' : '')}}">
                            <ul class="row col-12 m-auto">
								@foreach($chamados as $chamado)
									@if($chamado->RelationStatus->first()->id == $status->id)
									<li class="col-12 border rounded shadow-sm mb-3">
										<div class="p-3 h-100 row">
											<div class="text-left col-6">
												<a href="{{route('detalhes.chamados.gti', $chamado->id)}}">
													<h5 class="text-uppercase mb-2 text-truncate">
														<span>{{$chamado->RelationFontes->nome}}</span> 
														<b>&#183</b> 
														<span>{{$chamado->RelationTipos->nome}}</span>
														<div class="badge" style="background: {{$chamado->RelationStatus->first()->color}}">{{$chamado->RelationStatus->first()->nome}}</div>
													</h5>
												</a>
												<label class="text-capitalize d-block text-primary">
													{{$chamado->RelationUsuario->RelationAssociado->nome}}
												</label>
												<label class="text-truncate d-block mb-0">
													<small class="text-dark"><b>Assunto</b>: {{$chamado->assunto}}</small>
												</label>
												<label class="text-truncate d-block mb-0">
													<small class="text-dark"><b>Descrição:</b> {{(isset($chamado->descricao) ? $chamado->descricao : '-')}}</small>
												</label>
												<label class="text-truncate d-block">
													<small class="text-dark"><b>Data de abertura:</b> {{$chamado->created_at->format('d/m/Y H:i')}}</small>
												</label>					
											</div>
											<div class="text-right row col-3 ml-auto">
												<div class="ml-auto">
													<a href="{{route('relatorio.chamados.gti', $chamado->id)}}" target="_blank" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Relatório do chamado">
														<i class="mdi mdi-cloud-print-outline"></i>
														<small> Gerar relatório</small>
													</a>	
													@if($chamado->RelationStatus->first()->finish != 1)
													<a class="status btn btn-default btn-outline btn-rounded col-10 mb-2" id="{{$chamado->id}}" onclick="$('#modal-alterar .idChamado').val(this.id);" data-toggle="modal" data-target="#modal-alterar" title="Alterar status">
														<i class="mdi mdi-cached"></i>
														<small>	Atualizar status</small>
													</a>
													@endif
													<a href="{{route('detalhes.chamados.gti', $chamado->id)}}" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Detalhes do chamado">
														<i class="mdi mdi-comment-processing-outline"></i>
														<small> Mais informações</small>
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
            @else
            <div class="row mx-auto pt-4">
				<label class="alert alert-secondary col-12 rounded">Você não possui nenhum chamado cadastrado.</label>
			</div>
            @endif
		</div>
	</div>
</div>
@endsection

@section('modal')
	@if(!empty($chamados[0]))
  		@include('tecnologia.chamados.status')
  	@endif
@endsection

@section('suporte')
<script type="text/javascript">
  $(document).ready( function (){
    $('#modal-alterar #formAlterar').on('submit', function(e){
      // Editando as informações
      e.preventDefault();
      $.ajax({
        url: "{{url('app/gti/chamados/status')}}/"+$('#modal-alterar .idChamado').val(),
        type: 'POST',
        data: $('#modal-alterar #formAlterar').serialize(),
        beforeSend: function(){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
          $('#modal-alterar #err').html('');
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
              $('#modal-alterar #err').html(data.responseText);
            }else{
              $('#modal-alterar #err').html('');
              $('input').removeClass('border-bottom border-danger');
              $.each(data.responseJSON.errors, function(key, value){
                $('#modal-alterar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
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