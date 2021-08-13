<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Relatório dos chamados &#183 Sicoob Serviços</title>
	
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Asap&display=swap');
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
				line-height: 1em;
				color: black !important;
				font-family: 'Asap';
				font-size: 13px;
			}
		}

		body {
			margin:0;
			padding:0;
			line-height: 1em;
			color: black !important;
			font-family: 'Asap';
			font-size: 13px;
		}
	</style>
</head>
<body>
	<table width="100%" align="center">
		<tr>
			<td style="padding-bottom: 30px; border-bottom: 1px solid black;">
				<table width="100%" align="center">
					<tr>
						<td width="30%">
							<div>
								<img src="{{ public_path('img/logo-dark.png')}}" width="170">
							</div>
						</td>
						<td align="center" width="45%">
							<div>
								<h2 style="padding: 0; margin: 5px;">Sicoob Serviços</h2>
								<h3 style="padding: 0; margin: 5px;">Relatório dos chamados da plataforma </h3>
							</div>
						</td>
						<td align="right" width="25%">
							<small>
								<b>Data de geração</b>
								<br>
								<span>{{now()->format('d/m/Y H:i')}}</span>
							</small>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		@foreach($chamados as $chamado)
		<tr>
			<td style="border-bottom: 1px solid black;">
				<table width="100%" align="center">
					<tr>
						<td style="padding: 10px 0;">
							<table width="100%" align="center">
								<tr>
									<td>
										<table width="100%" align="center">
											@if(isset($dados['ambiente']))
											<tr>
												<td>
													<div>
														<label style="font-weight: 700;">Ambiente:</label>
														<label>{{$chamado->RelationAmbientes->nome}}</label>
													</div>
												</td>
											</tr>
											@endif
											@if(isset($dados['fontes']))
											<tr>
												<td>
													<div>
														<label style="font-weight: 700;">Fontes:</label>
														<label>{{$chamado->RelationFontes->nome}}</label>
													</div>
												</td>
											</tr>
											@endif
											@if(isset($dados['assunto']))
											<tr>
												<td>
													<div>
														<label style="font-weight: 700;">Assunto:</label>
														<label>{{$chamado->assunto}}</label>
													</div>	
												</td>
											</tr>
											@endif
											@if(isset($dados['descricao']))
											<tr>
												<td>
													<div>
														<label style="font-weight: 700;">Descrição:</label>
														<label style="word-wrap: break-word;">{{(!empty($chamado->descricao) ? $chamado->descricao : '-')}}</label>
													</div>
												</td>
											</tr>
											@endif
											@if(isset($dados['teamViewer']))
											<tr>
												<td>
													<div>
														<label style="font-weight: 700;">ID TeamViewer:</label>
														<label style="word-wrap: break-word;">{{(!empty($chamado->teamViewer) ? $chamado->teamViewer : ' - ')}}</label>
													</div>
												</td>
											</tr>
											@endif
											@if(isset($dados['status']))
											<tr>
												<td>
													<div>
														<label style="font-weight: 700;">Último status:</label>
														<label style="word-wrap: break-word;">{{$chamado->RelationStatus->first()->nome}}</label>
													</div>
												</td>
											</tr>
											@endif
											@if(isset($dados['usuarios']))
											<tr>
												<td>
													<div>
														<label style="font-weight: 700;">Usuário solicitante:</label>
														<label style="word-wrap: break-word;">{{$chamado->RelationUsuario->RelationAssociado->nome}}</label>
													</div>
												</td>
											</tr>
											@endif
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		@endforeach
	</table>
</body>
</html>
