@section('title')
Relatório da solicitação #{{$chamado->id}}
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
			font-size: 16px !important;
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
					<h5 class="my-2">Relatório de solicitação de suporte técnico </h5>
					<label>Número da solicitação: #{{$chamado->id}} </label>
				</div>
				<div class="pt-3 col-3 text-right">
					<small>
						<b class="d-block">Data de abertura</b> 
						<span>{{$chamado->created_at->format('d/m/Y H:i')}}</span>
					</small>
					<br>
					<small>
						<b class="d-block">Data de fechamento</b> 
						<span>{{$chamado->RelationStatus->first()->pivot->created_at->format('d/m/Y H:i')}}</span>
					</small>
				</div>
			</div>
			<hr class="border-dark">
			<div class="body px-5 py-4">
				<div class="col-12">
					<h5 class="border-bottom border-dark pb-3">Descrição do chamado</h5>
				</div>
				<div class="row mx-auto">
					<div class="col-12">
						<h5 class="text-uppercase mb-2 text-truncate">
							<span>{{$chamado->RelationFontes->nome}}</span> 
							<b>&#183</b> 
							<span>{{$chamado->RelationTipos->nome}}</span>
						</h5>
					</div>
					<div class="col-12 mb-4">
						<label class="text-capitalize d-block text-primary">{{$chamado->RelationUsuario->RelationAssociado->nome}}
						</label>
					</div>
					<div class="col-12 mb-4">
						<label class="d-block">
							<b>Assunto</b> 
							<p>{{$chamado->assunto}}</p>
						</label>
						<label class="d-block">
							<b>Descrição</b> 
							<p>{{(isset($chamado->descricao) ? $chamado->descricao : '-')}}</p>
						</label>  
					</div>
					<div class="col-12 mb-5">
						<label class="d-inline-block">
							<b>Anexos do chamado</b>
						</label>
						<div>
							@foreach($chamado->RelationArquivos as $arquivos)
							<div class="row mx-auto"> 
								<a href="{{asset('storage/app/'.$arquivos->endereco)}}" target="_blank" class="row col-12">
									<div class="px-2">
										@if( explode(".", $arquivos->endereco)[1] == "docx" || explode(".", $arquivos->endereco)[1] == "doc")
										<i class="mdi mdi-file-word mdi-dark mdi-18px m-auto"></i>
										@elseif( explode(".", $arquivos->endereco)[1] == "xls" || explode(".", $arquivos->endereco)[1] == "xlsx" || explode(".", $arquivos->endereco)[1] == "xlsm"
										|| explode(".", $arquivos->endereco)[1] == "csv")
										<i class="mdi mdi-file-excel mdi-dark mdi-18px m-auto"></i>
										@elseif( explode(".", $arquivos->endereco)[1] == "pdf")
										<i class="mdi mdi-file-pdf mdi-dark mdi-18px m-auto"></i>
										@else
										<i class="mdi mdi-file-document mdi-dark mdi-18px m-auto"></i>
										@endif
									</div>
									<div class="my-auto">
										<span class="text-truncate">{{str_replace('chamados/', '', $arquivos->endereco)}}</span>
									</div>
								</a>
							</div>
							@endforeach
						</div>
					</div>
				</div>	
				<div class="row mx-auto">
					<div class="col-12">
						<h5 class="border-bottom border-dark pb-3">Hístórico de atualizações</h5>
					</div>
					<div class="col-12 px-2">
						<ul class="p-0" id="statusNews">
							@foreach($historicoStatus as $status)
				            <li class="m-3" id="status{{$status->id}}">
				              <div class="badge" style="background: {{$status->RelationStatus->color}}">{{$status->RelationStatus->nome}}</div>
				              <label class="col-12 pt-3 px-0">
				                {{$status->descricao}}
				              </label>
				              <small class="font-weight-normal">
				                {!!(isset($status->RelationUsuarios) ? 'Alterado por: <b>'.$status->RelationUsuarios->RelationAssociado->nome.'</b>' : '')!!}
				              </small>
				              <div class="row mx-auto mt-2">
				                <small class="p-0 font-weight-bold">
				                  {{$status->created_at->format('d/m/Y H:i')}} -
				                  {{$status->created_at->subMinutes(2)->diffForHumans()}}
				                </small>
				              </div>
				              <hr>
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