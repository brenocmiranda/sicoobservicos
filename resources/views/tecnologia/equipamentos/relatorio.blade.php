@section('title')
Termo de responsabilidade e compromisso para uso dos equipamentos corporativos
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
			line-height: 1.5em;
			color: black !important;
		}

		body .page{
			height: 100vh !important;
			font-size: 20px !important;
		}

		@page {
			margin: 2.5cm;
			font-size: 20px !important;
		}
	}

	body {
		margin:0;
		padding:0;
		line-height: 1.5em;
		color: black !important;
		font-size: 20px !important;
	}
  </style>
@endsection

@include('layouts.header')
<div class="container vh-100 p-0" style="width:800px">
	<section class="section h-100">
		<div class="page p-5">
			<div class="header row px-5">
				<div class="pl-4 text-left col-12">
					<img src="{{asset('public/img/logo-dark.png')}}" width="220">
				</div>
				<div class="col-12 pt-5 text-center">
					<h3><b>TERMO DE RESPONSABILIDADE E COMPROMISSO PARA USO DE EQUIPAMENTO CORPORATIVO</b></h3>
				</div>
			</div>
			<div class="body p-5 text-justify">
				<p> &nbsp &nbsp &nbsp Em <b>{{now()->format('d')}}</b> de <b>{{now()->format('m')}}</b> de <b>{{now()->format('Y')}}</b>, eu, <b>{{$equipamentos->first()->RelationUsuarios->RelationAssociado->nome}}</b>, com as atribuições de <b>{{$equipamentos->first()->RelationUsuarios->RelationFuncao->nome}}</b>, pelo presente instrumento, acuso o recebimento dos equipamentos de propriedade da Cooperativa de Crédito de Livre Admissão do Sertão de Minas Gerais LTDA – Sicoob Sertão Minas, com a(s) seguinte(s) descrição: </p>

				<table class="table text-center border border-dark my-4">
					<thead class="border-dark">
						<th>Nome</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Nº de patrimônio</th>
						<th>Nº de Série</th>
					</thead>
					<tbody>
						@foreach($equipamentos as $dados)
						<tr>
							<td>{{$dados->nome}}</td>
							<td>{{$dados->marca}}</td>
							<td>{{$dados->modelo}}</td>
							<td>{{$dados->n_patrimonio}}</td>
							<td>{{$dados->serialNumber}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>

				<p>
					&nbsp &nbsp &nbsp Eu, <b>{{$equipamentos->first()->RelationUsuarios->RelationAssociado->nome}}</b>, firmo o presente com o compromisso de assumir inteira responsabilidade pela guarda e zelo do bem, bem como pela legalidade dos softwares nele instalados e de apresentá-lo em local previamente combinado, quando solicitado pela equipe do Departamento de Tecnologia da Informação na sede do Sicoob Sertão Minas (Pirapora - Minas Gerais), restituindo-o ao titular do setor, quando por este solicitado, ou quando cessarem as minhas atividades nesta empresa.
				</p>
				<p>
					&nbsp &nbsp &nbsp Através da assinatura deste documento, eu, <b>{{$equipamentos->first()->RelationUsuarios->RelationAssociado->nome}}</b>, recipiendário, me comprometo a seguir as normas descritas abaixo para, a partir da data de hoje, <b>{{now()->format('d')}}</b> de <b>{{now()->format('m')}}</b> de <b>{{now()->format('Y')}}</b>, executar os trabalhos pertinentes as minhas atividades.
				</p>
				<h3 class="py-4">Responsabilidade do Usuário</h3>
				<ul style="list-style: disc">
					<li>Responsabilizar-se pelo equipamento (hardware), mantendo-o nas suas perfeitas condições de uso, na forma como lhe foi entregue;</li>
					<li>O equipamento permanecerá sujeito às diretrizes de segurança do Sicoob Sertão Minas;</li>
					<li>Somente instalar software licenciado e adquirido pelo Sicoob Sertão Minas;</li>
					<li>Instalar software livre ou arquivos, desde que não prejudiquem o desempenho do equipamento ou da rede, e não comprometam a imagem do Sicoob Sertão Minas;</li>
					<li>Somente utilizar o equipamento para as atividades pertinentes ao Sicoob Sertão Minas;</li>
					<li>Sempre notificar ao administrador da rede as ocorrências com o computador, que seja invasão, dano ou roubo;</li>
					<li>Não manipular líquidos ou substancias que possam danificar o equipamento quando o estiver operando, assim como não fumar;</li>
					<li>A criação e manutenção de copias de segurança (backup) dos arquivos contidos no equipamento são de inteira responsabilidade do usuário;</li>
					<li>Não emprestar o equipamento para terceiros, exceto em caso de treinamentos e vídeo conferencias no âmbito do Sicoob Sertão Minas.</li>
				</ul>

				<h3 class="py-4">Responsabilidade do Administrador</h3>
				<p>Cabe ao administrador dos recursos seguir as seguintes diretrizes: </p>
				<ul style="list-style: disc">
					<li>Sempre que os equipamentos estiverem conectados a rede da Sicoob Sertão Minas, disponibilizar ao usuário patches atualizados de sistema operacional, Office e antivírus para que o mesmo seja instalado nos computadores.</li>
					<li>Ter acesso aos arquivos do computador pessoal do usuário quando for indispensável para manutenção do sistema, falhas de segurança, quando o usuário solicitar sua ajuda ou por ordem superior.</li>
					<li>Colaborar para garantir a funcionalidade dos serviços do equipamento utilizado pelo usuário;</li>
					<li>Cadastrar o computador pessoal do usuário em domínios ou sub-domínios existentes na rede do Sicoob Sertão Minas. </li>
					<li>Somente instalar software com licença de uso e que não prejudiquem o desempenho do computador ou da rede e não comprometam a imagem do Sicoob Sertão Minas. </li>
				</ul>
				<p>O presente termo foi registrado em 02 (duas) vias <b>(1ª via do emitente, 2ª via do recipiendário)</b>, assinado pelo EMITENTE E RECIPIENDÁRIO. </p>

				<div class="text-right my-5">
					<label class="py-5">Pirapora, {{now()->format('d')}} de {{now()->format('m')}} de {{now()->format('Y')}}</label>
				</div>

				<div class="row text-center mx-auto my-5 pt-5">
					<div class="col-5 border-top border-dark mx-auto">
						<label class="m-0">{{$equipamentos->first()->RelationUsuarios->RelationAssociado->nome}}</label>
						<br>
						<small><b>{{$equipamentos->first()->RelationUsuarios->RelationSetor->nome}}</b></small>
					</div>
					<div class="col-5 border-top border-dark mx-auto">
						<label class="m-0">Barbara Bezerra Palma</label>
						<br>
						<small><b>Supervisora Geral</b></small>
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