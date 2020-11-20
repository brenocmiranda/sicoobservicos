<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  	<!-- Title &#8226 -->
  	<title>Aniversariantes de {{(
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
					explode('-', $result[0]->data_nascimento)[1] == 12 ? 'Dezembro' : 'mês'))))))))))))}}</title>
					
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  	<style type="text/css">
  		@font-face {
		    font-family: 'Asap';
		    font-style: normal;
		    font-weight: 400;
		    src: url('{{ asset('storage/fonts/Asap-Regular.ttf') }}') format("truetype");
		}

		body {
			margin:0px;
			padding:0px;
			line-height: 1.5em !important;
			color: #003641 !important;
		}

		h1, h2 {
			font-family: asap;
		}

		.footer {
		  position: fixed;
		  left: 0;
		  bottom: 150px;
		  width: 100%;
		  color: white;
		  text-align: center;
		}
  </style>
</head>

<body>
	<div style="margin-bottom: 10px; margin-top: -40px">
		<h1 style="color:white !important; text-transform: uppercase; z-index: 100; position: absolute; padding-top: 25px; padding-left: 20px;font-size:29px;"> Aniversariantes de {{(
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
		<img src="{{public_path().'\img\header-aniv.png'}}" style="width: 100%">
	</div>
	<div style="text-align: center;">
		@foreach($result as $aniversario)
			<h2 style="font-size:28px;line-height: 1.45em;">{{$aniversario->nome}} - {{date('d/m', strtotime($aniversario->data_nascimento))}}</h2>
		@endforeach
	</div>
	<div class="footer">
		<img src="{{public_path().'\img\footer-aniv.png'}}" style="width: 100%">
	</div>
</body>
</html>
