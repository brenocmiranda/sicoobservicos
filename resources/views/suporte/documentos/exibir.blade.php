@section('title')
Documentos
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Documentos</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Suporte</a></li>
				<li class="active">Documentos</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mx-auto justify-content-center">
				@include('layouts.search')
			</div>
			<ul class="row p-5" id="documentos">
				@foreach($dados->sortBy('nome') as $documento)
				<li class="col-12 mx-auto">
					<div class="row">
						<div class="rounded text-center px-4">
							@if( explode(".", $documento->RelationArquivo->endereco)[1] == "docx" || explode(".", $documento->RelationArquivo->endereco)[1] == "doc")
								<i class="mdi mdi-file-word mdi-36px mdi-dark"></i>
							@elseif( explode(".", $documento->RelationArquivo->endereco)[1] == "xls" || explode(".", $documento->RelationArquivo->endereco)[1] == "xlsx" || explode(".", $documento->RelationArquivo->endereco)[1] == "xlsm"
							|| explode(".", $documento->RelationArquivo->endereco)[1] == "csv")
								<i class="mdi mdi-file-excel mdi-36px mdi-dark"></i>
							@elseif( explode(".", $documento->RelationArquivo->endereco)[1] == "pdf")
								<i class="mdi mdi-file-pdf mdi-36px mdi-dark"></i>
							@else
								<i class="mdi mdi-file-document mdi-36px mdi-dark"></i>
							@endif
						</div>
						<div class="text-left my-auto">
							{{$documento->nome}}
						</div>
						<div class="ml-auto my-auto px-5">
							<a href="{{asset('storage/app').'/'.$documento->RelationArquivo->endereco}}" target="_blank" title="Download do arquivo">
								<div class="text-center">
									<i class="mdi mdi-download"></i>
									<small>Download</small>
								</div>
							</a>
						</div>
					</div>
					<hr class="my-2">	
				</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#documentos li").css("display", "block");
			$("#documentos li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});
	});
</script>
@endsection