@section('title')
Solicitações de contrato
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Solicitações de contrato</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.credito')}}">Crédito</a></li>
				<li><a class="active">Solicitações</a></li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12">
				<div class="col-12 row mb-4 mx-auto">
					@include('layouts.search')
					<button class="btn btn-primary btn-outline ml-auto" id="solicitacao" name="solicitacao" title="Solicitar novo material" data-toggle="modal" data-target="#modal-solicitacao">
						<i class="m-0 pr-1 mdi mdi-plus"></i> 
						<span>Nova solicitação</span>
					</button>
				</div>

				<div class="row col-12 mx-auto mt-5">
					<div class="col-12">
						@if(isset($dados[0]))
						<div class="sttabs tabs-style-linetriangle">
                            <nav  class="col-10 mx-auto">
                                <ul>
                                    <li class="tab-current">
                                    	<a href="#section-1">
                                    		<span class="font-weight-bold">Em aberto</span>
                                    	</a>
                                    </li>
                                    <li class="">
                                    	<a href="#section-2">
                                    		<span class="font-weight-bold">Entregue</span>
                                    	</a>
                                    </li>
                                    <li class="">
                                    	<a href="#section-3">
                                    		<span class="font-weight-bold">Devolvido</span>
                                    	</a>
                                    </li>
                                </ul>
                            </nav>
                            <ul class="content-wrap p-0" id="requisicoes">
                        		<section id="section-1" class="content-current">
                        			@foreach($dados as $requisicao)
										@if($requisicao->RelationStatus->last()->status == 'aberto')
										<li class="row">
											<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
												<div class="col-1 m-auto row justify-content-center">
													<i class="mdi mdi-alert-circle-outline text-warning mdi-48px"></i>
												</div>
												<div class="col-7">
													<div>
														<div>
															<small><b>Nº de requisição:</b> {{$requisicao->id}}</small>
														</div>
														<div>
															<small><b>Usuário solicitante:</b> {{$requisicao->RelationUsuarios->RelationAssociado->nome}}</small>
														</div>
														<div>
															<small><b>Data da solicitação:</b> {{$requisicao->created_at->format('d/m/Y H:i')}}</small>
														</div>
														<div>
															<small><b>Observações:</b> {{$requisicao->observacoes}}</small>
														</div>
													</div>
													<hr class="my-3">
													<div>
														<small><b>Nº do contrato:</b> {{$requisicao->RelationContratos->num_contrato}}</small>
													</div>
													<div>
														<small><b>Associado:</b> {{$requisicao->RelationContratos->RelationAssociados->nome}}</small>
													</div>
													<div>
														<small><b>Produto:</b> {{$requisicao->RelationContratos->RelationProdutos->nome}} - {{$requisicao->RelationContratos->RelationModalidades->nome}}</small>
													</div>
													<div>
														<small><b>Valor do contrato:</b> R$ {{number_format($requisicao->RelationContratos->valor_contrato, 2, ',', '.')}}</small>
													</div>
													<div>
														<small><b>Localização:</b> {{$requisicao->RelationContratos->RelationArmarios->referencia}}</small>
													</div>
												</div>
												@if(Auth::user()->RelationFuncao->gerenciar_credito == 1)
												<div class="col-2 p-0 m-auto">
													@if($requisicao->RelationStatus->last()->status == 'aberto' && Auth::id() == $requisicao->RelationUsuarios->id)
														<button class="btn btn-primary btn-outline btn-rounded btn-xs col-12 px-2 mb-3 remover" id="{{$requisicao->id}}">
															<i class="mdi mdi-close"></i>
															<label>Remover</label>
														</button>
													@endif
													<button class="btn btn-primary btn-outline btn-rounded btn-xs col-12 px-2 mb-3 alterar" id="{{$requisicao->id}}">
														<i class="mdi mdi-sync"></i>
														<label>Alterar status</label>
													</button>
													<a href="{{route('imprimir.solicitacoes.credito', $requisicao->id)}}" target="_blank" class="btn btn-primary btn-outline btn-rounded btn-xs col-12 px-2 impirmir">
														<i class="mdi mdi-printer"></i>
														<label>Imprimir</label>
													</a>
												</div>
												@endif
											</div>
										</li>
										@endif
									@endforeach
								</section>
								<section id="section-2" class="">
									@foreach($dados as $requisicao)
										@if($requisicao->RelationStatus->last()->status == 'entregue')
										<li class="row">
											<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
												<div class="col-1 m-auto row justify-content-center">
													<i class="mdi mdi-comment-alert-outline text-info mdi-48px"></i>
												</div>
												<div class="col-7">
													<div>
														<div>
															<small><b>Nº de requisição:</b> {{$requisicao->id}}</small>
														</div>
														<div>
															<small><b>Usuário solicitante:</b> {{$requisicao->RelationUsuarios->RelationAssociado->nome}}</small>
														</div>
														<div>
															<small><b>Data da solicitação:</b> {{$requisicao->created_at->format('d/m/Y H:i')}}</small>
														</div>
														<div>
															<small><b>Observações:</b> {{$requisicao->observacoes}}</small>
														</div>
													</div>
													<hr class="my-3">
													<div>
														<small><b>Nº do contrato:</b> {{$requisicao->RelationContratos->num_contrato}}</small>
													</div>
													<div>
														<small><b>Associado:</b> {{$requisicao->RelationContratos->RelationAssociados->nome}}</small>
													</div>
													<div>
														<small><b>Produto:</b> {{$requisicao->RelationContratos->RelationProdutos->nome}} - {{$requisicao->RelationContratos->RelationModalidades->nome}}</small>
													</div>
													<div>
														<small><b>Valor do contrato:</b> R$ {{number_format($requisicao->RelationContratos->valor_contrato, 2, ',', '.')}}</small>
													</div>
													<div>
														<small><b>Localização:</b> {{$requisicao->RelationContratos->RelationArmarios->referencia}}</small>
													</div>
												</div>
												@if(Auth::user()->RelationFuncao->gerenciar_credito == 1)
												<div class="col-2 p-0 m-auto">
													<button class="btn btn-primary btn-outline btn-rounded btn-xs col-12 px-2 mb-3 alterar" id="{{$requisicao->id}}">
														<i class="mdi mdi-sync"></i>
														<label>Alterar status</label>
													</button>
													<a href="{{route('imprimir.solicitacoes.credito', $requisicao->id)}}" target="_blank" class="btn btn-primary btn-outline btn-rounded btn-xs col-12 px-2 impirmir">
														<i class="mdi mdi-printer"></i>
														<label>Imprimir</label>
													</a>
												</div>
												@endif
											</div>
										</li>
										@endif
									@endforeach
                            	</section>
                           		<section id="section-3" class="">
                             		@foreach($dados as $requisicao)
                                 		@if($requisicao->RelationStatus->last()->status == 'devolvido')
										<li class="row">
											<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
												<div class="col-1 m-auto row justify-content-center">
													<i class="mdi mdi-comment-check-outline text-success mdi-48px"></i>
												</div>
												<div class="col-7">
													<div>
														<div>
															<small><b>Nº de requisição:</b> {{$requisicao->id}}</small>
														</div>
														<div>
															<small><b>Usuário solicitante:</b> {{$requisicao->RelationUsuarios->RelationAssociado->nome}}</small>
														</div>
														<div>
															<small><b>Data da solicitação:</b> {{$requisicao->created_at->format('d/m/Y H:i')}}</small>
														</div>
														<div>
															<small><b>Observações:</b> {{$requisicao->observacoes}}</small>
														</div>
													</div>
													<hr class="my-3">
													<div>
														<small><b>Nº do contrato:</b> {{$requisicao->RelationContratos->num_contrato}}</small>
													</div>
													<div>
														<small><b>Associado:</b> {{$requisicao->RelationContratos->RelationAssociados->nome}}</small>
													</div>
													<div>
														<small><b>Produto:</b> {{$requisicao->RelationContratos->RelationProdutos->nome}} - {{$requisicao->RelationContratos->RelationModalidades->nome}}</small>
													</div>
													<div>
														<small><b>Valor do contrato:</b> R$ {{number_format($requisicao->RelationContratos->valor_contrato, 2, ',', '.')}}</small>
													</div>
													<div>
														<small><b>Localização:</b> {{$requisicao->RelationContratos->RelationArmarios->referencia}}</small>
													</div>
												</div>
												@if(Auth::user()->RelationFuncao->gerenciar_credito == 1)
												<div class="col-2 p-0 m-auto">
													<button class="btn btn-primary btn-outline btn-rounded btn-xs col-12 px-2 mb-3 alterar" id="{{$requisicao->id}}">
														<i class="mdi mdi-sync"></i>
														<label>Alterar status</label>
													</button>
													<a href="{{route('imprimir.solicitacoes.credito', $requisicao->id)}}" target="_blank" class="btn btn-primary btn-outline btn-rounded btn-xs col-12 px-2 impirmir">
														<i class="mdi mdi-printer"></i>
														<label>Imprimir</label>
													</a>
												</div>
												@endif
											</div>
										</li>
										@endif
									@endforeach
                            	</section>
					
                            </ul>
                        </div>
						@else
							<div class="row mx-auto">
								<label class="alert alert-secondary col-12 rounded">Você não possui nenhuma solicitação.</label>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('credito.solicitacoes.alterar')
	@include('credito.solicitacoes.solicitacao')
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#requisicoes li").css("display", "block");
			$("#requisicoes li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});

		// Limpando as informações dos modais
		$('#solicitacao').on('click', function(){
			$('.modal form').each (function(){
				this.reset();
				if ($(this).hasClass('border-bottom border-danger')){
					this.removeClass('border-bottom border-danger');
				}
			});
		});

		// Retornando dados do contrato
		$('.contrato').on('change', function(e){
			$.get('solicitacoes/detalhes/'+this.value, function(data){
				$('.cre_id_produtos').val(data.cre_id_produtos);
				$('.cre_id_modalidades').val(data.cre_id_modalidades);
				$('.data_operacao').val(data.data_operacao);
				$('.data_vencimento').val(data.data_vencimento);
				$('.valor_contrato').val(data.valor_contrato.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
			});
		});

		// Removendo essa solicitação
		$('.remover').on('click', function(e){
			swal({
				title: "Tem certeza que deseja remover essa solicitação?",
				icon: "error",
				buttons: ["Cancelar", "Remover"],
				dangerMode: true
			})
			.then((willDelete) => {
				if (willDelete) {
					$.get('solicitacoes/remover/'+this.id, function(data){
						if(data.success == true){
							swal("Solicitação removida com sucesso!", {
								icon: "success",
							});
							location.reload();
						}else{
							swal("Não foi possível alterar essas informações, tente novamente!", {
								icon: "error",
							});
						}
					});
				} else {
					swal.close();
				}
			});
		});

		// Alterando estado da solicitação
		$('.alterar').on('click', function(e){
			$('.idChamado').val(this.id);
			$('#modal-alterar').modal('show');
		});


		$('#modal-alterar #formAlterar').on('submit', function(e){
	      // Alterar as informações
	      e.preventDefault();
	      $.ajax({
	        url: "{{route('alterar.solicitacoes.credito')}}",
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

	    $('#modal-solicitacao #formSolicitacao').on('submit', function(e){
	      // Efetuando a solicitação
	      e.preventDefault();
	      $.ajax({
	        url: "{{route('solicitar.solicitacoes.credito')}}",
	        type: 'POST',
	        data: $('#modal-solicitacao #formSolicitacao').serialize(),
	        beforeSend: function(){
	          $('.modal-body, .modal-footer').addClass('d-none');
	          $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
	          $('#modal-solicitacao #err').html('');
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
	              $('#modal-solicitacao #err').html(data.responseText);
	            }else{
	              $('#modal-solicitacao #err').html('');
	              $('input').removeClass('border-bottom border-danger');
	              $.each(data.responseJSON.errors, function(key, value){
	                $('#modal-solicitacao #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
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