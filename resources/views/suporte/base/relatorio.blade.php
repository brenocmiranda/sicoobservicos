@section('title')
Relatório de aprendizagem
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
					<h5 class="my-2">Relatório de aprendizagem </h5>
					<label>Número da aprendizagem: #{{$dados->id}} </label>
				</div>
				<div class="pt-3 col-3 text-right">
					<small>
						<b class="d-block">Data de abertura</b> 
						<span>{{$dados->created_at->format('d/m/Y H:i')}}</span>
					</small>
					<br>
					<small>
						<b class="d-block">Data de atualização</b> 
						<span>{{$dados->updated_at->format('d/m/Y H:i')}}</span>
					</small>
				</div>
			</div>
			<hr class="border-dark">
			<div class="body px-5 py-4">
				<div class="col-12">
					<h5 class="border-bottom border-dark pb-3">Descrição do tópico</h5>
				</div>
				<div class="row mx-auto">
					<div  style="margin-left: 20px; margin-right: 20px">
		              <h4>{{$dados->titulo}}</h4>
		              <h5>{{$dados->RelationAmbientes->nome}} &#183 {{$dados->RelationFontes->nome}}</h5>
		              <label>{{$dados->subtitulo}}</label> 
		              @foreach($dados->RelationArquivos as $arquivos)
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
		                    <span class="text-truncate">{{str_replace('base/', '', $arquivos->endereco)}}</span>
		                  </div>
		                </a>
		                </div>
		                @endforeach
		              <hr>
		              <p class="w-100"><?php echo $dados->descricao; ?></p>
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