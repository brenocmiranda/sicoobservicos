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
				<li><a href="{{route('exibir.analise.negocios')}}">Associados</a></li>
				<li class="active">Tratamento do associado</li>
			</ol>
		</div>
	</div>
	<form class="form-sample" method="POST" id="formFinalizar" action="{{route('finalizar.analise.negocios', $associado->id)}}" enctype="multipart/form-data" autocomplete="off">
        @csrf
		<div class="card mb-4">
			<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
				<h5 class="text-white">Associado <a href="{{route('exibirID.associado.atendimento', $associado->id)}}" target="_blank"><small  class="text-info">(Visualizar painel comercial)</small></a></h5>
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
		                <h6>Participa de conglomerado?</h6>
		                <label>{!!(isset($associado->RelationConglomerados) ? 'Sim '.'<i class="mdi mdi-information-outline text-danger"></i>' : 'Não')!!}</label>
	              	</div>
	             	
					<div class="col-12 col-lg-3">
						<h6>Conta capital:</h6>
						<label>R$ {{(isset($associado->RelationCapital) ? number_format($associado->RelationCapital->valor_integralizado, 2, ',', '.') : '-')}}</label>
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
				<h5 class="text-white">Análise econômica</h5>
			</div>
			<div class="card-body">
				<div class="row mx-auto">
					<div class="col-lg-6 col-12">
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-6 text-center">Banco Central</h5>
						</div>
						<hr class="mt-1 mx-auto col-8">
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-4">Data-Base:</h5>
							<input type="month" name="bc_data" class="form-control form-control-line col-4" placeholder="10/01/2020" value="{{$carteira->bc_data}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-4">Consignados:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_consignados" class="form-control form-control-line col-4" placeholder="0,00" value="{{number_format($carteira->bc_consignados, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-4">Créditos Pessoais:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_creditopessoal" class="form-control form-control-line col-4" placeholder="0,00" value="{{number_format($carteira->bc_creditopessoal, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-4">Cheque Especial:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_chequeespecial" class="form-control form-control-line col-4" placeholder="0,00" value="{{number_format($carteira->bc_chequeespecial, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-4">Cartão de crédito:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_cartao" class="form-control form-control-line col-4" placeholder="0,00" value="{{number_format($carteira->bc_cartao, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-4">Financiamentos:</h5>
							<h5 class="pr-2">R$</h5>
							<input type="text" name="bc_financiamento" class="form-control form-control-line col-4" placeholder="0,00" value="{{number_format($carteira->bc_financiamento, 2, ',', '.')}}" disabled>
						</div>
						<div class="col-12 row mx-auto px-0 mt-2">
							<h5 class="col-4">Possui divida vencida?</h5>
							<select class="form-control form-control-line col-5" name="bc_dividavencida" disabled>
								<option value="Sim" {{(@$carteira->bc_dividavencida == 'Sim' ? 'selected' : '')}}>Sim</option>
								<option value="Não" {{(@$carteira->bc_dividavencida == 'Não' ? 'selected' : '')}}>Não</option>
							</select>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-12 text-center">Serasa</h5>
						</div>
						<hr class="mt-1 mx-auto col-8">
						<div class="col-12 row mx-auto px-0">
							<h5 class="col-4">Data-Base:</h5>
							<input type="date" name="se_data" class="form-control form-control-line col-4" placeholder="10/01/2020" value="{{$carteira->se_data}}" disabled>
						</div>
						<div class="form-group col-12 row mx-auto px-0">
							<h5 class="col-4">Possui restrição?</h5>
							<select class="form-control form-control-line col-5" name="se_restricao" disabled>
								<option value="Sim" {{(@$carteira->se_restricao == 'Sim' ? 'selected' : '')}}>Sim</option>
								<option value="Não" {{(@$carteira->se_restricao == 'Não' ? 'selected' : '')}}>Não</option>
							</select>
						</div>
						<div class="row col-12 mx-auto px-0 d-none">
							<div class="form-group col-4 row mx-auto">
								<h5>Data:</h5>
								<input type="date" name="" class="form-control form-control-line">
							</div>
							<div class="form-group col-4 row mx-auto">
								<h5>Tipo:</h5>
								<input type="text" name="" class="form-control form-control-line">
							</div>
							<div class="form-group col-4 row mx-auto">
								<h5>Valor:</h5>
								<input type="text" name="" class="money form-control form-control-line">
							</div>
						</div>
						<div class="form-group col-12 row mx-auto" disabled>
							<h5>Endereço:</h5>
							<input type="text" name="se_endereco" class="form-control form-control-line" placeholder="RUA ANTONIO NASCIMENTO, 179, CENTRO - PIRAPORA/MG" value="{{$carteira->se_endereco}}" disabled>
						</div>
						<div class="form-group col-12 row mx-auto" disabled>
							<h5 class="col-12 px-0">Telefone:</h5>
							<input type="text" name="se_telefone" class="numeroTelefone form-control form-control-line col-6" placeholder="(38) 3741-6250" value="{{$carteira->se_telefone}}" disabled>
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
						<h5 class="col-12 px-0">Parecer do análise</h5>
						<p>{{$carteira->RelationStatus->observacoes}}</p>
					</div>
					<div class="form-group col-12 row mx-auto">
						<h5>Parecer do atendimento <span class="text-danger">*</span></h5>
						<textarea class="form-control form-control-line" name="observacoes" placeholder="Descreva seu parecer das informações analisadas..."></textarea>
					</div>
				</div>
			</div>
		</div>
		<hr class="col-10">
		<div class="row col-12 justify-content-center mx-auto">
			<a href="{{route('exibir.analise.negocios')}}" class="btn btn-danger col-3 col-lg-3 d-flex align-items-center justify-content-center mx-2">
				<i class="mdi mdi-arrow-left pr-2"></i> 
				<span>Voltar</span>
			</a>
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