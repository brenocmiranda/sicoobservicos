@section('title')
Relatório de atividades
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
					<h5 class="my-2">Relatório de atividades </h5>
				</div>
				<div class="pt-3 col-3 text-right">
					<small>
						<b class="d-block">Data de emissão</b> 
						<span>{{date('d/m/Y H:i')}}</span>
					</small>
				</div>
			</div>
			<hr class="border-dark">
			<div class="body px-5 py-4">
				{!!$result!!}
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