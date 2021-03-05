@section('title')
Análise do associado
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
				<li class="active">Análise de associado</li>
			</ol>
		</div>
	</div>
	<div class="col-12 mb-4">
		<a href="{{route('exibir.analise.negocios')}}#">
			<i class="mdi mdi-arrow-left pr-2"></i> 
			<span>Voltar</span>
		</a>
	</div>
	<div class="card mb-4">
		<div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
			<h5 class="text-white">Associado</h5>
		</div>
		<div class="card-body">
			<div class="row mx-auto">
				<div class="col-12 col-lg-3">
					<h6>Nome:</h6>
					<label>{{$dados->nome}}</label>
				</div>
				<div class="col-12 col-lg-3">
					<h6>Documento:</h6>
					 <label>{{(strlen($dados->documento) == 11 ? substr($dados->documento, 0, 3).'.'.substr($dados->documento, 3, 3).'.'.substr($dados->documento, 6, 3).'-'.substr($dados->documento, 9, 2) : substr($dados->documento, 0, 2).'.'.substr($dados->documento, 3, 3).'.'.substr($dados->documento, 6, 3).'/'.substr($dados->documento, 8, 4).'-'.substr($dados->documento, 12, 2))}}</label>
				</div>
				<div class="col-12 col-lg-3">
					<h6>Renda/Faturamento <small class="text-dark">(Mensal bruto)</small></h6>
					<label>R$ {{number_format(($dados->renda), 2, ',', '.')}}</label>
				</div>
				<div class="col-12 col-lg-3">
					<h6>Patrimônio <small class="text-dark">(Bens móveis e imóveis)</small></h6>
					<label>R$ {{number_format(($dados->RelationConsolidado->valor_imovel+$dados->RelationConsolidado->valor_movel), 2, ',', '.')}}</label>
				</div>
				<div class="col-12 col-lg-3">
					<h6>Gerente:</h6>
					<label>{{$dados->nome_gerente}}</label>
				</div>
				<div class="col-12 col-lg-3">
	              <h6>Nível CRL <small class="text-dark">(Vigência até: {{(isset($dados->RelationConsolidado) ? (date('d/m/Y', strtotime($dados->RelationConsolidado->data_crl)) != date('d/m/Y', strtotime('1899-12-31')) ? date('d/m/Y', strtotime($dados->RelationConsolidado->data_crl)) : '-') : '-')}})</small></h6>
	              <label>{{(isset($dados->RelationConsolidado) ? $dados->RelationConsolidado->nivel_risco_crl : '-')}}</label>
	            </div>
				 <div class="col-12 col-lg-3">
	              <h6>Nível de risco</h6>
	              <label>{{(isset($dados->RelationConsolidado) ? $dados->RelationConsolidado->nivel_risco : '-')}}</label>
	            </div>
				<div class="col-12 col-lg-3">
					<h6>Data de relacionamento:</h6>
					<label>{{date('d/m/Y', strtotime($dados->data_relacionamento))}}</label>
				</div>
				
				<div class="col-12 col-lg-3">
					<h6>Perfil tarifário:</h6>
					<label>-</label>
				</div>
				<div class="col-lg-3 col-12">
	                <h6>Participa de conglomerado?</h6>
	                <label>{{(isset($dados->RelationConglomerados) ? 'Sim' : 'Não')}}</label>
	              </div>
				<div class="col-12 col-lg-3">
					<h6>Conta capital:</h6>
					<label>R$ {{(isset($dados->RelationCapital) ? number_format($dados->RelationCapital->valor_integralizado, 2, ',', '.') : '-')}}</label>
				</div>
				<div class="col-12 col-lg-3">
					<h6>PA:</h6>
					<label>{{$dados->PA}}</label>
				</div>
			</div>
			<div class="row mx-auto">
				<div class="col-12">
					<table class="table table-bordered text-center">
						<h6>Portfólio de produtos</h6>
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
							<tr class="info">
								<td>
									<label>Atual</label>
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
							</tr>
							<tr class="success">
								<td>
									<label>Sugerido</label>
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
								</td>
								<td>
									R$ 0,00
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
				<div class="col-6">
					<div class="col-12 row mx-auto px-0">
						<h5 class="col-12 text-center">Banco Central</h5>
					</div>
					<hr class="mt-1 mx-auto col-8">
					<div class="col-12 row mx-auto px-0">
						<h5 class="col-4">Consignados:</h5>
						<h5 class="pr-2">R$</h5>
						<input type="text" name="" class="form-control form-control-line col-4" placeholder="0,00">
					</div>
					<div class="col-12 row mx-auto px-0">
						<h5 class="col-4">Créditos Pessoais:</h5>
						<h5 class="pr-2">R$</h5>
						<input type="text" name="" class="form-control form-control-line col-4" placeholder="0,00">
					</div>
					<div class="col-12 row mx-auto px-0">
						<h5 class="col-4">Cheque Especial:</h5>
						<h5 class="pr-2">R$</h5>
						<input type="text" name="" class="form-control form-control-line col-4" placeholder="0,00">
					</div>
					<div class="col-12 row mx-auto px-0">
						<h5 class="col-4">Cartão de crédito:</h5>
						<h5 class="pr-2">R$</h5>
						<input type="text" name="" class="form-control form-control-line col-4" placeholder="0,00">
					</div>
					<div class="col-12 row mx-auto px-0">
						<h5 class="col-4">Financiamentos:</h5>
						<h5 class="pr-2">R$</h5>
						<input type="text" name="" class="form-control form-control-line col-4" placeholder="0,00">
					</div>
					<div class="col-12 row mx-auto px-0 mt-2">
						<h5 class="col-4">Possui divida vencida?</h5>
						<select class="form-control form-control-line col-5" nome="">
							<option value="">Selecione</option>
							<option value="Sim">Sim</option>
							<option value="Não">Não</option>
						</select>
					</div>
				</div>
				<div class="col-6">
					<div class="col-12 row mx-auto px-0">
						<h5 class="col-12 text-center">Serasa</h5>
					</div>
					<hr class="mt-1 mx-auto col-8">
					<div class="form-group col-12 row mx-auto px-0">
						<h5 class="col-4">Possui restrição?</h5>
						<select class="form-control form-control-line col-5" nome="">
							<option value="">Selecione</option>
							<option value="Sim">Sim</option>
							<option value="Não">Não</option>
						</select>
					</div>
					<div class="form-group col-12 row mx-auto">
						<h5>Endereço:</h5>
						<input type="text" name="" class="form-control form-control-line" placeholder="RUA ANTONIO NASCIMENTO, 179, CENTRO - PIRAPORA/MG">
					</div>
					<div class="form-group col-12 row mx-auto">
						<h5 class="col-12 px-0">Telefone:</h5>
						<input type="text" name="" class="form-control form-control-line col-6" placeholder="(38) 3741-6250">
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
					<h5>Parecer do analisata:</h5>
					<textarea class="form-control form-control-line" nome="" placeholder="Descreva seu parecer das informações analisadas..."></textarea>
				</div>
				<div class="form-group col-12 row mx-auto">
					<h5 class="col-12 px-0">Encaminhar para tramento:</h5>
					<select class="form-control form-control-line col-7" nome="">
						<option value="">Selecione</option>
						@foreach($usuarios as $usuario)
							<option value="{{$usuario->id}}">{{$usuario->RelationAssociado->nome}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	<hr class="col-10">
	<div class="row col-12 justify-content-center mx-auto">
		<button type="submit" class="btn btn-info col-4 col-lg-2 d-flex align-items-center justify-content-center mx-2">
			<i class="mdi mdi-account-check pr-2"></i> 
			<span>Salvar</span>
		</button>
		<button type="submit" class="btn btn-success col-4 col-lg-3 d-flex align-items-center justify-content-center mx-2">
			<i class="mdi mdi-file-send pr-2"></i> 
			<span>Salvar e encaminhar</span>
		</button>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){

	});
</script>
@endsection