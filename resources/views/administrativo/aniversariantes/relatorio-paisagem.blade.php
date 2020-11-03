@section('title')
Aniversariantes de {{(
					explode('-', $result[0]->data_nascimento)[1] == 1 ? 'Janeiro' : (
					explode('-', $result[0]->data_nascimento)[1] == 2 ? 'Fevereiro' : (
					explode('-', $result[0]->data_nascimento)[1] == 3 ? 'Março' : (
					explode('-', $result[0]->data_nascimento)[1] == 4 ? 'Abril' : (
					explode('-', $result[0]->data_nascimento)[1] == 5 ? 'Maio' : (
					explode('-', $result[0]->data_nascimento)[1] == 6 ? 'Junho' : (
					explode('-', $result[0]->data_nascimento)[1] == 7 ? 'Julho' : (
					explode('-', $result[0]->data_nascimento)[1] == 8 ? 'Agosto' : (
					explode('-', $result[0]->data_nascimento)[1] == 9 ? 'Setembro' : (
					explode('-', $result[0]->data_nascimento)[1] == 10 ? 'Outubro' : (
					explode('-', $result[0]->data_nascimento)[1] == 11 ? 'Novembro' : (
					explode('-', $result[0]->data_nascimento)[1] == 12 ? 'Dezembro' : 'mês'))))))))))))}}
@endsection

@section('header-support')
 <style type="text/css">
 	@import url('https://fonts.googleapis.com/css2?family=Asap&display=swap');

  	@media print {
	  	* {
		  	font-family: 'Asap';
			background:transparent !important;
			color:#003641 !important;
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
		color: #003641 !important;
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
		color: #003641 !important;
		font-family: 'Asap';
	}

	h2, h1{
		font-family: 'Asap';
	}
  </style>
@endsection

@include('layouts.header')
<div class="container vh-100 p-0" style="width:800px">
	<section class="section h-100">
		<div class="page py-5">
			<div class="col-12 row header p-0 mx-auto">
				<h1 class="text-white py-4 ml-5 text-uppercase" style="z-index: 100;"> Aniversariantes de {{(
					explode('-', $result[0]->data_nascimento)[1] == 1 ? 'Janeiro' : (
					explode('-', $result[0]->data_nascimento)[1] == 2 ? 'Fevereiro' : (
					explode('-', $result[0]->data_nascimento)[1] == 3 ? 'Março' : (
					explode('-', $result[0]->data_nascimento)[1] == 4 ? 'Abril' : (
					explode('-', $result[0]->data_nascimento)[1] == 5 ? 'Maio' : (
					explode('-', $result[0]->data_nascimento)[1] == 6 ? 'Junho' : (
					explode('-', $result[0]->data_nascimento)[1] == 7 ? 'Julho' : (
					explode('-', $result[0]->data_nascimento)[1] == 8 ? 'Agosto' : (
					explode('-', $result[0]->data_nascimento)[1] == 9 ? 'Setembro' : (
					explode('-', $result[0]->data_nascimento)[1] == 10 ? 'Outubro' : (
					explode('-', $result[0]->data_nascimento)[1] == 11 ? 'Novembro' : (
					explode('-', $result[0]->data_nascimento)[1] == 12 ? 'Dezembro' : 'mês'))))))))))))}} </h1>
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