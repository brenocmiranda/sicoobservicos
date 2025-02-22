@section('title')
Executar análise
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Análise do associado</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Negócios</a></li>
				<li><a href="{{route('exibir.analise.negocios')}}">Análise econômica</a></li>
				<li class="active">Executar análise</li>
			</ol>
		</div>
	</div>

	<form class="form-sample" method="POST" id="formFinalizar" action="{{route('finalizar.analise.negocios', $associado->id)}}" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="id_carteira" value="{{@$carteira->id}}">
        <div class="row mx-auto col-12 mb-4">
        	<div class="col-6 px-0 text-left">
		        <a href="{{route('exibir.analise.negocios')}}">
					<i class="mdi mdi-arrow-left pr-2"></i> 
					<span>Voltar</span>
				</a>
			</div>
			<div class="col-6 px-0 text-right">
				<a href="{{route('exibirID.associado.atendimento', $associado->id)}}" target="_blank" class="pr-3">
					<i class="mdi mdi-account pr-2"></i> 
					<span>Painel comercial</span>
				</a>
				<a href="javascript:" id="remover" class="text-danger">
					<i class="mdi mdi-close pr-2"></i> 
					<span>Remover análise do associado</span>
				</a>
			</div>
		</div>
		@if(isset($carteira))
		<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<label class="m-0">Este associado já foi analisado, altere as informações e encaminhe-o para o tratamento.</label>
		</div>
		@endif
		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white">Dados do associado</a></h5>
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
						<table class="table table-bordered text-center table-responsive">
							<thead>
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
										R$ {{(isset($associado->RelationContaCorrente[0]) ? number_format($associado->RelationContaCorrente->where('situacao', 'ATIVA')->sum('valor_contratado'), 2, ',', '.') : '0,00')}}
										<input type="hidden" name="especial_atual" value="{{(isset($associado->RelationContaCorrente[0]) ? number_format($associado->RelationContaCorrente->where('situacao', 'ATIVA')->sum('valor_contratado'), 2, ',', '.') : '0,00')}}">
									</td>
									<td>
										R$ {{(isset($associado->RelationCartaoCredito[0]) ? number_format($associado->RelationCartaoCredito->where('situacao', 'Operativo')->sum('valor_atribuido'), 2, ',', '.') : '0,00')}}
										<input type="hidden" name="cartao_atual" value="{{(isset($associado->RelationCartaoCredito[0]) ? number_format($associado->RelationCartaoCredito->where('situacao', 'Operativo')->sum('valor_atribuido'), 2, ',', '.') : '0,00')}}">
									</td>
									<td>
										R$ {{number_format($emprestimoGeral, 2, ',', '.')}}
										<input type="hidden" name="emp_atual" value="{{number_format($emprestimoGeral, 2, ',', '.')}}">
									</td>
									<td>
										R$ {{number_format($financiamento, 2, ',', '.')}}
										<input type="hidden" name="fin_atual" value="{{number_format($financiamento, 2, ',', '.')}}">
									</td>
									<td>
										R$ {{(isset($associado->RelationSeguros[0]) ? number_format($associado->RelationSeguros->where('familia', 'VIDA INDIVIDUAL')->sum('premio_liquido'), 2, ',', '.') : '0,00')}}
										<input type="hidden" name="svida_atual" value="{{(isset($associado->RelationSeguros[0]) ? number_format($associado->RelationSeguros->where('familia', 'VIDA INDIVIDUAL')->sum('premio_liquido'), 2, ',', '.') : '0,00')}}">
									</td>
									<td>
										R$ {{(isset($associado->RelationSeguros[0]) ? number_format($associado->RelationSeguros->where('familia', '!=', 'VIDA INDIVIDUAL')->sum('premio_liquido'), 2, ',', '.') : '0,00')}}
										<input type="hidden" name="sgeral_atual" value="{{(isset($associado->RelationSeguros[0]) ? number_format($associado->RelationSeguros->where('familia', '!=', 'VIDA INDIVIDUAL')->sum('premio_liquido'), 2, ',', '.') : '0,00')}}">
									</td>
									<td>
										R$ {{(isset($associado->RelationConsorcios[0]) ? number_format($associado->RelationConsorcios->where('situacao', 'NORMAL')->sum('valor_contratado'), 2, ',', '.') : '0,00')}}
										<input type="hidden" name="consorcio_atual" value="{{(isset($associado->RelationConsorcios[0]) ? number_format($associado->RelationConsorcios->where('situacao', 'NORMAL')->sum('valor_contratado'), 2, ',', '.') : '0,00')}}">
									</td>
									<td>
										R$ {{(isset($associado->RelationPrevidencias[0]) ? number_format($associado->RelationPrevidencias->where('tipo_participante', 'ATIVO - COBRANÇA BANCÁRIA')->sum('valor_proposta'), 2, ',', '.') : '0,00')}}
										<input type="hidden" name="previdencia_atual" value="{{(isset($associado->RelationPrevidencias[0]) ? number_format($associado->RelationPrevidencias->where('tipo_participante', 'ATIVO - COBRANÇA BANCÁRIA')->sum('valor_proposta'), 2, ',', '.') : '0,00')}}">
									</td>
								</tr>
								<tr>
									<td>
										<label>Sugerido</label>
									</td>
									<td>
										<input type="text" name="especial_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->especial_sugerido, 2, ',', '.')}}">
									</td>
									<td>
										<input type="text" name="cartao_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->cartao_sugerido, 2, ',', '.')}}">
									</td>
									<td>
										<input type="text" name="emp_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->emp_sugerido, 2, ',', '.')}}">
									</td>
									<td>
										<input type="text" name="fin_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->fin_sugerido, 2, ',', '.')}}">
									</td>
									<td>
										<input type="text" name="svida_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->svida_sugerido, 2, ',', '.')}}">
									</td>
									<td>
										<input type="text" name="sgeral_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->sgeral_sugerido, 2, ',', '.')}}">
									</td>
									<td>
										<input type="text" name="consorcio_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->consorcio_sugerido, 2, ',', '.')}}">
									</td>
									<td>
										<input type="text" name="previdencia_sugerido" class="money text-center form-control form-control-line px-0" placeholder="0,00" value="{{number_format(@$carteira->previdencia_sugerido, 2, ',', '.')}}">
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
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Data-Base</h5>
							<input type="month" name="bc_data" class="form-control form-control-line col-lg-4 col-11" placeholder="10/01/2020" value="{{@$carteira->bc_data}}">
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Consignados:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_consignados" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_consignados, 2, ',', '.')}}">
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Créditos Pessoais:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_creditopessoal" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_creditopessoal, 2, ',', '.')}}">
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Cheque Especial:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_chequeespecial" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_chequeespecial, 2, ',', '.')}}">
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Cartão de crédito:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_cartao" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_cartao, 2, ',', '.')}}">
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Financiamentos:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_financiamento" class="form-control form-control-line col-lg-4 col-11" placeholder="0,00" value="{{number_format(@$carteira->bc_financiamento, 2, ',', '.')}}">
						</div>
						<div class="col-12 row mx-auto px-0 mt-2 mb-5 mb-lg-0">
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Possui divida vencida?</h5>
							<select class="form-control form-control-line col-lg-5 col-11" name="bc_dividavencida">
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
							<h5 class="col-lg-4 col-12 px-0 px-lg-4">Data-Base</h5>
							<input type="date" name="se_data" class="form-control form-control-line col-lg-4 col-12" placeholder="10/01/2020" value="{{@$carteira->se_data}}">
						</div>
						<div class="form-group col-12 row mx-auto px-0 px-lg-4">
							<h5 class="col-12 px-0">Endereço</h5>
							<input type="text" name="se_endereco" class="form-control form-control-line col-12" placeholder="RUA ANTONIO NASCIMENTO, 179, CENTRO - PIRAPORA/MG" onkeyup="this.value = this.value.toUpperCase();" value="{{(isset($carteira->se_endereco) ? $carteira->se_endereco : (isset($associado->RelationEnderecos) ? $associado->RelationEnderecos->rua.', '.$associado->RelationEnderecos->numero.', '.$associado->RelationEnderecos->bairro.' - '.$associado->RelationEnderecos->cidade.'/'.$associado->RelationEnderecos->estado : ''))}}">
						</div>
						<div class="form-group col-12 row mx-auto px-0 px-lg-4">
							<h5 class="col-12 px-0">Telefone</h5>
							<input type="text" name="se_telefone" class="numeroTelefone form-control form-control-line col-lg-6 col-11" placeholder="(38) 3741-6250" value="{{@$carteira->se_telefone}}">
						</div>
						<div class="form-group col-12 row mx-auto px-0">
							<h5 class="col-lg-5 col-12 px-0 px-lg-4">Possui restrição?</h5>
							<select class="form-control form-control-line col-lg-5 col-12 se_restricao" name="se_restricao">
								<option value="Sim" {{(@$carteira->se_restricao == 'Sim' ? 'selected' : '')}}>Sim</option>
								<option value="Não" {{(@$carteira->se_restricao == 'Não' ? 'selected' : (@$carteira->se_restricao != 'Sim' ? 'selected' : ''))}}>Não</option>
							</select>
						</div>
						<div class="mb-3 restricao" style="{{(isset($carteira->se_restricao) ? ($carteira->se_restricao == 'Não' ? 'display: none;' : '') : 'display: none;')}}">
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
												<input type="date" name="se_restricao_data[]" class="form-control form-control-line" value="{{$dados1[$key]}}" style="font-size: 12px">
											</div>
											<div class="form-group col-4 row mx-auto">
												<h6 class="m-0">Tipo</h6>
												<input type="text" name="se_restricao_tipo[]" class="form-control form-control-line" value="{{$dados2[$key]}}"  onkeyup="this.value = this.value.toUpperCase();" style="font-size: 12px">
											</div>
											<div class="form-group col-3 row mx-auto">
												<h6 class="m-0">Valor</h6>
												<input type="text" name="se_restricao_valor[]" class="money form-control form-control-line" value="{{$dados3[$key]}}" style="font-size: 12px">
											</div>
											<div class="col-1 px-0 m-auto">
												<a href="javascript:" onclick="remover(this);">
													<i class="mdi mdi-close text-danger mdi-24px"></i>
												</a>
											</div>
										</div>
									@endforeach
								@endif
							</div>
							<div class="col-12">
								<a href="javascript:" class="novaRestricao"><i class="mdi mdi-plus pr-2"></i>Nova restrição</a>
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
					<div class="form-group col-12 row mx-auto">
						<h5>Parecer do analista <span class="text-danger">*</span></h5>
						<textarea class="form-control form-control-line" name="observacoes" placeholder="Descreva seu parecer das informações analisadas..." required>{{@$carteira->RelationStatus->observacoes}}</textarea>
					</div>
					<div class="form-group col-12 row mx-auto">
						<h5 class="col-12 px-0">Encaminhar para tramento <span class="text-danger">*</span></h5>
						<select class="form-control form-control-line col-lg-7 col-12" name="usr_id_usuarios" required>
							<option value="">Selecione</option>
							@foreach($usuarios as $usuario)
								<option value="{{$usuario->id}}" {{(@$carteira->RelationStatus->usr_id_usuarios == $usuario->id ? 'selected' : '')}}>{{$usuario->RelationAssociado->nome}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<hr class="col-10">
		<div class="row col-12 justify-content-center mx-auto">
			<button type="submit" class="btn btn-info col-3 col-lg-3 d-flex align-items-center justify-content-center mx-2" name="button" value="salvar">
				<i class="mdi mdi-content-save pr-2"></i> 
				<span>Salvar</span>
			</button>
			<button type="submit" class="btn btn-success col-3 col-lg-3 d-flex align-items-center justify-content-center mx-2" name="button" value="encaminhar">
				<i class="mdi mdi-file-send pr-2"></i> 
				<span>Enviar p/ tratamento</span>
			</button>
		</div>
	</form>
</div>
@endsection

@section('modal')
	@include('negocios.analise.remover')
@endsection

@section('suporte')
<script type="text/javascript">
	function remover(div){
		$(div).parent('div').parent('div').remove();
	}

	$(document).ready( function (){
		$('.money').mask('000.000.000.000.000,00', {reverse: true});
		$('.numeroTelefone').mask('(00) 00000-0000');

		// Remover o associado da análise
		$('#remover').on('click', function(e) {
			$('#modal-remover #cli_id_associado').val('{{$associado->id}}');
			$('#modal-remover .nome').html('{{$associado->nome}}');
			$('#modal-remover').modal('show');
		});

		// Enviar processo de remoção
		$('#modal-remover #formRemover').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: "{{url('app/negocios/analise/remover')}}/"+$('#modal-remover #cli_id_associado').val(),
				type: 'POST',
				data: new FormData(this),
				processData: false,
		        contentType: false,
				beforeSend: function(){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
					$('#modal-remover #err').html('');
				},
				success: function(data){
					$('.modal-body, .modal-footer').addClass('d-none');
					$('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
					setTimeout(function(){
						window.location.href = '{{route('exibir.analise.negocios')}}';
					}, 1200);
				}, error: function (data) {
					setTimeout(function(){
						$('.modal-body, .modal-footer').removeClass('d-none');
						$('.carregamento').html('');
						if(!data.responseJSON){
							console.log(data.responseText);
							$('#modal-remover #err').html(data.responseText);
						}else{
							$('#modal-remover #err').html('');
							$('input').removeClass('border-bottom border-danger');
							$.each(data.responseJSON.errors, function(key, value){
								$('#modal-remover #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
								$('input[name="'+key+'"]').addClass('border-bottom border-danger');
							});
						}
					}, 2000);
				}
			});
		});

		// Exibindo restrições serasa
		$('.se_restricao').on('change', function(){
			$('#restricoes').html('');
			if (this.value == 'Sim'){
				$('.restricao').fadeIn();
			}else{
				$('.restricao').fadeOut();
			}
		});
		// Inserindo novas restrições
		$('.novaRestricao').on('click', function(){
			$('#restricoes').append('<div class="row col-12 mx-auto px-0"> <div class="form-group col-4 row mx-auto"> <h6 class="m-0">Data</h6> <input type="date" name="se_restricao_data[]" class="form-control form-control-line" style="font-size: 12px" required> </div> <div class="form-group col-4 row mx-auto"> <h6 class="m-0">Tipo</h6> <input type="text" name="se_restricao_tipo[]" class="form-control form-control-line" style="font-size: 12px" required> </div> <div class="form-group col-3 row mx-auto"> <h6 class="m-0">Valor</h6> <input type="text" name="se_restricao_valor[]" class="money form-control form-control-line" style="font-size: 12px" required> </div> <div class="col-1 px-0 m-auto"> <a href="javascript:" onclick="remover(this);"> <i class="mdi mdi-close text-danger mdi-24px"></i> </a> </div> </div>'); 
		});
	});
</script>
@endsection