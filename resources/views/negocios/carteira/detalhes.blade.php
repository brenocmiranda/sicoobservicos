@section('title')
Tratamento do associado
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Tratamento do associado</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Negócios</a></li>
				<li><a href="{{route('exibir.carteira.negocios')}}">Carteira</a></li>
				<li class="active">Tratamento</li>
			</ol>
		</div>
	</div>
	<form class="form-sample" method="POST" id="formFinalizar" action="{{route('finalizar.carteira.negocios', $associado->id)}}" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="id_carteira" value="{{@$carteira->id}}">
        <div class="row mx-auto col-12 mb-4">
        	<div class="col-6 px-0 text-left">
		        <a href="{{route('exibir.carteira.negocios')}}">
					<i class="mdi mdi-arrow-left pr-2"></i> 
					<span>Voltar</span>
				</a>
			</div>
			<div class="col-6 px-0 text-right">
				<a href="{{route('exibirID.associado.atendimento', $associado->id)}}" target="_blank">
					<i class="mdi mdi-account pr-2"></i> 
					<span>Painel comercial</span>
				</a>
			</div>
		</div>
		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white">Dados do associado</h5>
			</div>
			<div class="card-body">
				<div class="row mx-auto">
					<div class="col-12 col-lg-3">
						<h6>Nome</h6>
						<label>{{$associado->nome}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>Situação:</h6>
						<label>{{$associado->RelationCapital->situacao_capital}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>Documento:</h6>
						 <label>{{(strlen($associado->documento) == 11 ? substr($associado->documento, 0, 3).'.'.substr($associado->documento, 3, 3).'.'.substr($associado->documento, 6, 3).'-'.substr($associado->documento, 9, 2) : substr($associado->documento, 0, 2).'.'.substr($associado->documento, 3, 3).'.'.substr($associado->documento, 6, 3).'/'.substr($associado->documento, 8, 4).'-'.substr($associado->documento, 12, 2))}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>Perfil tarifário:</h6>
						<label>{{$associado->perfil_tarifario}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>Renda <small class="text-dark">(Mensal bruto)</small></h6>
						<label>R$ {{number_format(($associado->renda), 2, ',', '.')}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>Patrimônio <small class="text-dark">(Bens móveis e imóveis)</small></h6>
						<label>R$ {{number_format(($associado->RelationConsolidado->valor_imovel+$associado->RelationConsolidado->valor_movel), 2, ',', '.')}}</label>
					</div>
					<div class="col-12 col-lg-3">
		              	<h6>Nível CRL <small class="text-dark">(Vigência até: {{(isset($associado->RelationConsolidado) ? (date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) != date('d/m/Y', strtotime('1899-12-31')) ? date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) : '-') : '-')}})</small></h6>
		              	<label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->nivel_risco_crl : '-')}}</label>
		            </div>
					<div class="col-12 col-lg-3">
		              	<h6>Nível de risco</h6>
		              	<label>{{(isset($associado->RelationConsolidado) ? ($associado->RelationConsolidado->nivel_risco == "-3" ? 'NAO SE APLICA' : '-') : '-')}}</label>
		            </div>
					<div class="col-12 col-lg-3">
						<h6>Data de relacionamento:</h6>
						<label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
					</div>
					<div class="col-lg-3 col-12">
		              <h6>Data de renovação</h6>
		              @if(strtotime(date('Y-m-d', strtotime($associado->data_renovacao.'+ 1 year'))) < strtotime(date('Y-m-d')))
		                <small class="bg-danger px-3 py-1 text-white rounded" style="border-radius:15px">
		                {{date('d/m/Y', strtotime($associado->data_renovacao))}}</small>
		              @else
		                <label>{{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
		              @endif
		            </div>
					<div class="col-lg-3 col-12">
		                <h6>Participa de conglomerado?</h6>
		                <span class="mytooltip tooltip-effect-2" style="z-index: 10">
		               		<label>{!!(isset($associado->RelationConglomerados) ? 'Sim '.'<i class="mdi mdi-information-outline text-danger tooltip-item"></i>' : 'Não')!!}</label>
		               		@if(isset($associado->RelationConglomerados))
	                    	<span class="tooltip-content clearfix">
	                      		<span class="tooltip-text p-4" style="font-size: 10px; line-height: 18px">
	                      			@if(isset($conglomerado))
						                @foreach($conglomerado as $participante)
						                	<label class="d-block">&#183 {{$participante->RelationAssociado->nome}}</label>
						                @endforeach
					                @else
					               		<label>-</label>
					                @endif
	                      		</span> 
	                      	</span>
	                      	  @endif
                        </span>
	              	</div>
					<div class="col-12 col-lg-3">
						<h6>Conta capital:</h6>
						<label>R$ {{(isset($associado->RelationCapital) ? number_format($associado->RelationCapital->valor_integralizado, 2, ',', '.') : '-')}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>Valor a integralizar:</h6>
						<label>R$ {{(isset($associado->RelationCapital) ? number_format($associado->RelationCapital->valor_a_integralizar, 2, ',', '.') : '-')}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>PA:</h6>
						<label>{{$associado->PA}}</label>
					</div>
					<div class="col-12 col-lg-3">
						<h6>Gerente:</h6>
						<label>{{$associado->nome_gerente}}</label>
					</div>
				</div>
			</div>
		</div>
		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white">Portfólio de produtos</h5>
			</div>
			<div class="card-body">
				<div class="row mx-auto">
					<div class="col-12">
						<table class="table table-bordered text-center d-block d-lg-table col-12 px-0" style="overflow-y: auto;">
							<thead class="w-100">
								<th>#</th>
								<th>C. Especial</th>
								<th>C. de Crédito</th>
								<th>Emprestimos</th>
								<th>Financiamentos</th>
								<th>Seguro de vida</th>
								<th>Seguro em geral</th>
								<th>Consórcio</th>
								<th>Previdência</th>
							</thead>
							<tbody>
								<tr>
									<td>
										<label>Atual</label>
									</td>
									<td>
										R$ {{number_format($carteira->especial_atual, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->cartao_atual, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->emp_atual, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->fin_atual, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->svida_atual, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->sgeral_atual, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->consorcio_atual, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->previdencia_atual, 2, ',', '.')}}
									</td>
								</tr>
								<tr>
									<td>
										<label>Sugerido</label>
									</td>
									<td>
										R$ {{number_format($carteira->especial_sugerido, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->cartao_sugerido, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->emp_sugerido, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->fin_sugerido, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->svida_sugerido, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->sgeral_sugerido, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->consorcio_sugerido, 2, ',', '.')}}
									</td>
									<td>
										R$ {{number_format($carteira->previdencia_sugerido, 2, ',', '.')}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white">Análises externas</h5>
			</div>
			<div class="card-body">
				<div class="row mx-auto">
					<div class="col-lg-6 col-12">
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-12 text-center">Banco Central</h5>
						</div>
						<hr class="mt-1 mx-auto col-8">
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Data-Base:</h5>
							<input type="month" name="bc_data" class="form-control form-control-line col-lg-4 col-11" placeholder="10/01/2020" value="{{@$carteira->bc_data}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Consignados:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_consignados" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_consignados, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Créditos Pessoais:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_creditopessoal" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_creditopessoal, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Cheque Especial:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_chequeespecial" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_chequeespecial, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Cartão de crédito:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_cartao" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_cartao, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Financiamentos:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_financiamento" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_financiamento, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0 mt-2 mb-5 mb-lg-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Possui divida vencida?</h5>
							<select class="form-control form-control-line col-lg-5 col-11" name="bc_dividavencida" disabled>
								<option value="Sim" {{(@$carteira->bc_dividavencida == 'Sim' ? 'selected' : '')}}>Sim</option>
								<option value="Não" {{(@$carteira->bc_dividavencida == 'Não' ? 'selected' : (@$carteira->bc_dividavencida != 'Sim' ? 'selected' : ''))}}>Não</option>
							</select>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-12 text-center">Serasa</h5>
						</div>
						<hr class="mt-1 mx-auto col-8">
						<div class="form-group col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Data-Base:</h5>
							<input type="date" name="se_data" class="form-control form-control-line col-lg-4 col-12" placeholder="10/01/2020" value="{{@$carteira->se_data}}" disabled> 
						</div>
						<div class="form-group col-12 row mx-auto px-0 px-lg-4">
							<h5 class="col-12 px-0">Endereço</h5>
							<input type="text" name="se_endereco" class="form-control form-control-line col-12" placeholder="RUA ANTONIO NASCIMENTO, 179, CENTRO - PIRAPORA/MG" value="{{@$carteira->se_endereco}}" disabled>
						</div>
						<div class="form-group col-12 row mx-auto px-0 px-lg-4">
							<h5 class="col-12 px-0">Telefone</h5>
							<input type="text" name="se_telefone" class="numeroTelefone form-control form-control-line col-lg-6 col-11" placeholder="(38) 3741-6250" value="{{@$carteira->se_telefone}}" disabled>
						</div>
						<div class="form-group col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Possui restrição?</h5>
							<select class="form-control form-control-line col-lg-5 col-12 se_restricao" name="se_restricao" disabled>
								<option value="Sim" {{(@$carteira->se_restricao == 'Sim' ? 'selected' : '')}}>Sim</option>
								<option value="Não" {{(@$carteira->se_restricao == 'Não' ? 'selected' : (@$carteira->se_restricao != 'Sim' ? 'selected' : ''))}}>Não</option>
							</select>
						</div>
						<div class="mb-3 restricao" {{(@$carteira->se_restricao == 'Sim' ? 'style="display: none;"' : '')}}>
							<div id="restricoes">
								@if(isset($carteira) && $carteira->se_restricao == 'Sim')
									<?php 
										$dados1 = explode(';', $carteira->se_restricao_data);
										$dados2 = explode(';', $carteira->se_restricao_tipo);
										$dados3 = explode(';', $carteira->se_restricao_valor); 
									?>
									@foreach($dados1 as $key => $value)
										<div class="row col-12 mx-auto px-0">
											<div class="form-group col-4 row mx-auto">
												<h6 class="m-0">Data</h6>
												<input type="date" name="se_restricao_data[]" class="form-control form-control-line" value="{{$dados1[$key]}}" style="font-size: 12px" disabled>
											</div>
											<div class="form-group col-4 row mx-auto">
												<h6 class="m-0">Tipo</h6>
												<input type="text" name="se_restricao_tipo[]" class="form-control form-control-line" value="{{$dados2[$key]}}" style="font-size: 12px" disabled>
											</div>
											<div class="form-group col-4 row mx-auto">
												<h6 class="m-0">Valor</h6>
												<input type="text" name="se_restricao_valor[]" class="money form-control form-control-line" value="{{$dados3[$key]}}" style="font-size: 12px" disabled>
											</div>
										</div>
									@endforeach
								@endif
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white">Tratamento</h5>
			</div>
			<div class="card-body">
				<div class="row mx-auto">
					@if($carteira->RelationStatusTodos)
						@foreach($carteira->RelationStatusTodos as $dados)
							@if($dados->status == 'aberto')
							<div class="form-group col-12 row mx-auto">
								<h5 class="col-12 px-0">Parecer do analista</h5>
								<p class="col-12 px-0">{{$dados->observacoes}}</p>
								<p class="col-12 px-0">
									<small>
										<span><b>Responsável:</b> {{$dados->RelationUsuario->RelationAssociado->nome}}</span>
										<br>
										<span><b>Data:</b> {{date('d/m/Y H:i:s', strtotime($dados->created_at))}}</span>
									</small>
								</p>
							</div>
							@endif
						@endforeach
					@else
						<p> Nenhuma informação cadastrada</p>
					@endif
					<div class="form-group col-12 row mx-auto">
						<h5>Parecer do atendimento <span class="text-danger">*</span></h5>
						<textarea class="form-control form-control-line" name="observacoes" placeholder="Descreva seu parecer das informações analisadas..." required></textarea>
					</div>
				</div>
			</div>
		</div>
		<hr class="col-10">
		<div class="row col-12 justify-content-center mx-auto">
			<button type="submit" class="btn btn-success col-3 col-lg-3 d-flex align-items-center justify-content-center mx-2" name="button" value="salvar">
				<i class="mdi mdi-check-all pr-2"></i> 
				<span>Finalizar</span>
			</button>
		</div>
	</form>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		$('.money').mask('000.000.000.000.000,00', {reverse: true});
		$('.numeroTelefone').mask('(00) 00000-0000');
	});
</script>
@endsection