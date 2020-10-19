@section('title')
Relatório da solicitação #{{$requisicao->id}}
@endsection

@section('header-support')
<style type="text/css">
	@media print {
		* {
			background:transparent !important;
			color:black !important;
			text-shadow:none !important;
			filter:none !important;
			-ms-filter:none !important;
		}

		body {
			margin:0;
			padding:0;
			line-height: 1.4em;
			color: black !important;
		}

		body .page{
			height: 100vh !important;
		}

		@page {
			margin: 1.5cm;
			font-size: 18px !important;
		}
	}

	body {
		margin:0;
		padding:0;
		line-height: 1.4em;
		color: black !important;
	}
</style>
@endsection

@include('layouts.header')
<div class="container vh-100 p-0" style="width:800px">
	<section class="section h-100">
		<div class="border border-dark page py-5">
			<div class="header row px-5 py-4">
				<div class="pl-5 m-auto col-3">
					<img src="{{asset('public/img/logo-dark.png')}}" width="130">
				</div>
				<div class="col-6 text-center">
					<h3 class="my-0">{{ env('APP_NAME') }}</h3>
					<h5 class="my-2">Relatório de Solicitação de Contrato de Crédito </h5>
					<label>Número da solicitação: #{{$requisicao->id}} </label>
				</div>
				<div class="pt-3 col-3 text-right">
					<small>
						<b class="d-block">Data de abertura</b> 
						<span>{{$requisicao->created_at->format('d/m/Y H:i')}}</span>
					</small>					
				</div>
			</div>
			<hr class="border-dark">
			<div class="body px-5 py-4">
				<div class="col-12">
					<h5 class="border-bottom border-dark pb-3">Solicitação</h5>
				</div>
				<div class="col-12">
					<label class="text-capitalize d-block"> 
						<b>Solicitante:</b>
						<span>{{$requisicao->RelationUsuarios->RelationAssociado->nome}}</span>
					</label>
				</div>
				<div class="col-12 mb-5">
					<label class="text-capitalize d-block"> 
						<b>Observações:</b>
						<span>{{(isset($requisicao->observacoes) ? $requisicao->observacoes : 'Não possui nenhuma observação cadastrada.' )}}</span>
					</label>
				</div>

				<div class="col-12">
					<h5 class="border-bottom border-dark pb-3">Informações do contrato</h5>
				</div>
				<div class="row mx-auto">
					<div class="col-12">
						<label class="text-capitalize d-block"> 
							<b>Nº do contrato:</b>
							<span>{{$requisicao->RelationContratos->num_contrato}}</span>
						</label>
					</div>
					<div class="col-12">
						<label class="text-capitalize d-block"> 
							<b>Associado:</b>
							<span>{{$requisicao->RelationContratos->RelationAssociados->nome}}</span>
						</label>
					</div>
					<div class="col-12">
						<label class="text-capitalize d-block">
							<b>Produto:</b>
							<span>{{$requisicao->RelationContratos->RelationProdutos->nome}}</span>
						</label>
					</div>
					<div class="col-12">
						<label class="text-capitalize d-block">
							<b>Modalidade:</b>
							<span>{{$requisicao->RelationContratos->RelationModalidades->nome}}</span>
						</label>
					</div>
					<div class="col-12">
						<label class="text-capitalize d-block"> 
							<b>Valor do cotrato:</b>
							<span>R$ {{number_format($requisicao->RelationContratos->valor_contrato, 2, ',', '.')}}</span>
						</label>
					</div>
					<div class="col-12 mb-4">
						<label class="text-capitalize d-block"> 
							<b>Localização:</b>
							<span>{{$requisicao->RelationContratos->RelationArmarios->referencia}}</span>
						</label>
					</div>
				</div>	
				<div class="row mx-auto">
					<div class="col-12">
						<h5 class="border-bottom border-dark pb-3">Hístórico de alterações</h5>
					</div>
					<div class="col-12 px-2">
						<ul class="p-0">
							@foreach($requisicao->RelationStatus as $historico)
							<li class="m-3 border-bottom pb-3">
								<h6>Alteração de estado para {{($historico->status == 'aberto' ? 'Aberto' : ($historico->status == 'entregue' ? 'Entregue' : 'Devolvido'))}}.</h6>
								<small>{{$historico->RelationUsuarios->RelationAssociado->nome}}</small>
								<div class="col-12 row">
									<small class="p-0 font-weight-bold">
										{{$historico->created_at->format('d/m/Y H:i')}}
									</small>
								</div>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		window.print();
	});
</script>
@endsection

@include('layouts.footer')