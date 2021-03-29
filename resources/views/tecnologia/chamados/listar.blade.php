@section('title')
Solicitações de Suporte
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
				<li><a href="{{route('dashboard.gti')}}">Tecnologia</a></li>
				<li class="active">Suporte</li>
			</ol>
		</div>
	</div>
	<div class="confim"></div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mb-4 mx-auto justify-content-center">
				@include('layouts.search')
			</div>
			@if(!empty($chamados[0]))
			<section class="py-4">
				<div class="sttabs tabs-style-linetriangle row justify-content-center mx-auto">
                    <nav class="col-lg-8 col-12 mx-auto">
                        <ul>
            
                        	<li class="tab-current">
                        		<a href="#section-1">
                        			<span class="font-weight-bold d-block">Em aberto <small>( {{$chamadosEmaberto}} )</small></span>
                        		</a>
                        	</li>
                        	<li>
                        		<a href="#section-2">
                        			<span class="font-weight-bold d-block">Em andamento <small>( {{$chamadosEmandamento}} )</small></span>
                        		</a>
                        	</li>
                        	<li>
                        		<a href="#section-3">
                        			<span class="font-weight-bold d-block">Encerrado <small>( {{$chamadosEncerrado}} )</small></span>
                        		</a>
                        	</li>
                        
                        </ul>
                    </nav>
                    <div class="content-wrap col-12 px-0">
                    	<?php $i=0; ?>
                    	@foreach($statusAtivos as $status)
                        <section id="section-{{$status->id}}" class="{{($status->id == 1 ? 'content-current' : '')}}">
                            <ul class="row col-12 m-auto px-0">
                            	@if($status->nome == 'Encerrado')
									@foreach($chamados->sortByDesc('updated_at') as $chamado)
										@if($chamado->RelationStatus->first()->id == $status->id)
										<li class="col-12 border rounded shadow-sm mb-3" style="border-left: 5px solid {{$chamado->RelationStatus->first()->color}} !important">
											<div class="p-3 h-100 row">
												<div class="text-left col-lg-6 col-8">
													<a href="{{route('detalhes.chamados.gti', $chamado->id)}}">
														<h5 class="text-uppercase my-1 text-truncate">
															<span>{{$chamado->RelationAmbientes->nome}}</span> 
															<b>&#183</b> 
															<span>{{$chamado->RelationFontes->nome}}</span>
															<div class="badge mx-2" style="background: {{$chamado->RelationStatus->first()->color}}">{{$chamado->RelationStatus->first()->nome}}</div>
															@if(date('d/m/Y H:i:s', strtotime($chamado->RelationStatus->first()->pivot->created_at)) < date('d/m/Y H:i:s', strtotime('-'.explode(':', $chamado->RelationStatus->first()->tempo)[0].' hours -'.explode(':', $chamado->RelationStatus->first()->tempo)[1].' minutes -'.explode(':', $chamado->RelationStatus->first()->tempo)[2].' seconds')) && ($chamado->RelationStatus->first()->finish != 1) )
																<small class="text-danger"><b>Em atraso </b></small>	
															@endif
														</h5>
													</a>
													<label class="text-capitalize d-block text-primary">
														{{$chamado->RelationUsuario->RelationAssociado->nome}}
													</label>
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
												<div class="text-right row col-lg-3 col-4 ml-auto my-auto">
													<div class="ml-auto">
														<a href="{{route('detalhes.chamados.gti', $chamado->id)}}" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Detalhes do chamado">
															<i class="mdi mdi-comment-processing-outline"></i>
															<small class="hidden-xs"> Mais informações</small>
														</a>
														@if($chamado->RelationStatus->first()->finish != 1 && Auth::user()->RelationFuncao->gerenciar_gti == 1)
														<a class="status btn btn-default btn-outline btn-rounded col-10 mb-2" id="{{$chamado->id}}" onclick="$('#modal-alterar .idChamado').val(this.id);" data-toggle="modal" data-target="#modal-alterar" title="Alterar status">
															<i class="mdi mdi-cached"></i>
															<small class="hidden-xs">	Atualizar status</small>
														</a>
														@endif
														<a href="{{route('relatorio.chamados.gti', $chamado->id)}}" target="_blank" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Relatório do chamado">
															<i class="mdi mdi-cloud-print-outline"></i>
															<small class="hidden-xs"> Gerar relatório</small>
														</a>
															
													</div>
												</div>
											</div>
										</li>
										<?php $i++; ?>
										@endif
									@endforeach
								@else
									@foreach($chamados->sortBy('created_at') as $chamado)
										@if($chamado->RelationStatus->first()->id == $status->id)
										<li class="col-12 border rounded shadow-sm mb-3" style="border-left: 5px solid {{$chamado->RelationStatus->first()->color}} !important">
											<div class="p-3 h-100 row">
												<div class="text-left col-lg-6 col-8">
													<a href="{{route('detalhes.chamados.gti', $chamado->id)}}">
														<h5 class="text-uppercase my-1 text-truncate">
															<span>{{$chamado->RelationAmbientes->nome}}</span> 
															<b>&#183</b> 
															<span>{{$chamado->RelationFontes->nome}}</span>
															<div class="badge mx-2" style="background: {{$chamado->RelationStatus->first()->color}}">{{$chamado->RelationStatus->first()->nome}}</div>
															@if(date('d/m/Y H:i:s', strtotime($chamado->RelationStatus->first()->pivot->created_at)) < date('d/m/Y H:i:s', strtotime('-'.explode(':', $chamado->RelationStatus->first()->tempo)[0].' hours -'.explode(':', $chamado->RelationStatus->first()->tempo)[1].' minutes -'.explode(':', $chamado->RelationStatus->first()->tempo)[2].' seconds')) && ($chamado->RelationStatus->first()->finish != 1) )
																<small class="text-danger"><b>Em atraso </b></small>	
															@endif
														</h5>
													</a>
													<label class="text-capitalize d-block text-primary">
														{{$chamado->RelationUsuario->RelationAssociado->nome}}
													</label>
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
												<div class="text-right row col-lg-3 col-4 ml-auto my-auto">
													<div class="ml-auto">
														<a href="{{route('detalhes.chamados.gti', $chamado->id)}}" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Detalhes do chamado">
															<i class="mdi mdi-comment-processing-outline"></i>
															<small class="hidden-xs"> Mais informações</small>
														</a>
														@if($chamado->RelationStatus->first()->finish != 1 && Auth::user()->RelationFuncao->gerenciar_gti == 1)
														<a class="status btn btn-default btn-outline btn-rounded col-10 mb-2" id="{{$chamado->id}}" onclick="$('#modal-alterar .idChamado').val(this.id);" data-toggle="modal" data-target="#modal-alterar" title="Alterar status">
															<i class="mdi mdi-cached"></i>
															<small class="hidden-xs">	Atualizar status</small>
														</a>
														@endif
														<a href="{{route('relatorio.chamados.gti', $chamado->id)}}" target="_blank" class="btn btn-default btn-outline btn-rounded col-10 mb-2" title="Relatório do chamado">
															<i class="mdi mdi-cloud-print-outline"></i>
															<small class="hidden-xs"> Gerar relatório</small>
														</a>
															
													</div>
												</div>
											</div>
										</li>
										<?php $i++; ?>
										@endif
									@endforeach
								@endif
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
            @else
            <div class="row mx-auto pt-4">
				<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhum chamado cadastrado.</label>
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
	function removeImagem(id){
	    $.ajax({
	      url: "../removeArquivoStatus/"+id,
	      type: 'GET',
	      success: function(data){ 
	        $('#PreviewImage'+id).remove();
	      }
	    });
	  }

	 $(document).ready( function (){
	 	// Pré-visualização de várias imagens no navegador
	    $('#addArquivo').on('change', function(event) {
	      var formData = new FormData();
	      formData.append('_token', '{{csrf_token()}}');

	      if (this.files) {
	        for (i = 0; i < this.files.length; i++) {
	          formData.append('arquivos[]', this.files[i]);
	        }
	        $.ajax({
	          url: "{{ route('adicionar.arquivos.chamados.status.gti') }}",
	          type: 'POST',
	          data: formData,
	          processData: false,
	          contentType: false,
	          success: function(data){ 
	            for (i = 0; i < data.length; i++) {
	              $('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 p-0 row text-center" id="PreviewImage'+data[i].id+'" style="height:7em"> <input type="hidden" name="arquivos[]" value="'+data[i].id+'"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="height: 26px; width: 26px; z-index:10">x</a>'+(data[i].endereco.split('.')[1] == 'docx' || data[i].endereco.split('.')[1] == 'doc' ? '<i class="mdi mdi-file-word mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'xls' || data[i].endereco.split('.')[1] == 'xlsx' || data[i].endereco.split('.')[1] == 'xlsm' || data[i].endereco.split('.')[1] == 'csv' ? '<i class="mdi mdi-file-excel mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'pdf' ? '<i class="mdi mdi-file-pdf mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : '<i class="mdi mdi-file-document mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>')))+'</div>');
	            } 
	            $('#addArquivo').val('');   
	          }
	        });
	      }
	    });
    
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