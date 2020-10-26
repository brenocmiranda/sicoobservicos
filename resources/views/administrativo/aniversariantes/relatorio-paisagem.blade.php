@section('title')
Aniversariantes de {{($mes == 1 ? 'Janeiro' : ($mes == 2 ? 'Fevereiro' : ($mes == 3 ? 'Março' : ($mes == 4 ? 'Abril' : ($mes == 5 ? 'Maio' : ($mes == 6 ? 'Junho' : ($mes == 7 ? 'Julho' : ($mes == 8 ? 'Agosto' : ($mes == 9 ? 'Setembro' : ($mes == 10 ? 'Outubro' : ($mes == 11 ? 'Novembro' : ($mes == 12 ? 'Dezembro' : 'mês'))))))))))))}}
@endsection

@section('header-support')
 <style type="text/css">
  	@media print {
  		@import url('https://fonts.googleapis.com/css2?family=Asap&display=swap');

	  	* {
	  	font-family: 'Asap';
		background:transparent !important;
		color:black !important;
		text-shadow:none !important;
		filter:none !important;
		-ms-filter:none !important;
		size: landscape;
		-webkit-print-color-adjust: exact;
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
			margin: 0.3cm;
			font-size: 16px !important;
			size: landscape;
			font-family: 'Asap';
			-webkit-print-color-adjust: exact;
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
		<div class="page py-5">
			<div class="col-12 row header p-0 mx-auto">
				<h1 class="text-white py-4 ml-5 text-uppercase" style="z-index: 100;"> Aniversariantes de {{($mes == 1 ? 'Janeiro' : ($mes == 2 ? 'Fevereiro' : ($mes == 3 ? 'Março' : ($mes == 4 ? 'Abril' : ($mes == 5 ? 'Maio' : ($mes == 6 ? 'Junho' : ($mes == 7 ? 'Julho' : ($mes == 8 ? 'Agosto' : ($mes == 9 ? 'Setembro' : ($mes == 10 ? 'Outubro' : ($mes == 11 ? 'Novembro' : ($mes == 12 ? 'Dezembro' : 'mês'))))))))))))}} </h1>
				<img src="{{asset('public\img\header-aniv.png')}}" class="w-100 position-absolute">
			</div>
			<div class="text-center pt-5 align-items-center">
				@foreach($result as $aniversario)
					<h2 style="font-size: 30px; line-height: 1.45em">{{$aniversario->nome}} - {{date('d/m', strtotime($aniversario->data_nascimento))}}</h2>
				@endforeach
			</div>
			<div class="row col-12 justify-content-end footer">
				<img src="{{asset('public\img\footer-anivp.png')}}" style="width: 100%">
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