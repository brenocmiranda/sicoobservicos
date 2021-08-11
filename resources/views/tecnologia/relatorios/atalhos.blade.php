<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Relatório dos atalhos &#183 Sicoob Serviços</title>
	
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
								<h3 style="padding: 0; margin: 5px;">Relatório dos atalhos da homepage </h3>
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
		@foreach($atalhos as $atalho)
		<tr>
			<td style="border-bottom: 1px solid black;">
				<table width="100%" align="center">
					<tr>
						<td style="padding: 10px 0;">
							<table width="100%" align="center">
								<tr>
									<td>
										<table width="100%" align="center">
											<tr>
												<td width="12%">
													<table width="100%" align="center">
														<tr>
															<td>
																@if(isset($dados['icone']))
																<div>
																	<div>
																		<img src="{{'data:image/'.pathinfo(storage_path('app/'.$atalho->RelationImagem->endereco), PATHINFO_EXTENSION).'png;base64,' . base64_encode(file_get_contents(storage_path('app/'.$atalho->RelationImagem->endereco))) }}" alt="" width="60" height="60" style="border-radius: 5px;">
																	</div>
																</div>
																@endif
															</td>
														</tr>
													</table>
												</td>
												<td width="85%">
													<table width="100%" align="center">
														<tr>
															<td>
																@if(isset($dados['titulo']))
																<div>
																	<label style="font-weight: 700;">Título:</label>
																	<label>{{$atalho->titulo}}</label>
																</div>
																@endif
															</td>
														</tr>
														<tr>
															<td>
																@if(isset($dados['subtitulo']))
																<div>
																	<label style="font-weight: 700;">Subtítulo:</label>
																	<label>{{(!empty($atalho->subtitulo) ? $atalho->subtitulo : '-')}}</label>
																</div>
																@endif
															</td>
														</tr>
														<tr>
															<td>
																@if(isset($dados['endereco']))
																<div>
																	<label style="font-weight: 700;">Endereço:</label>
																	<label style="word-wrap: break-word;">{{$atalho->endereco}}</label>
																</div>
																@endif
															</td>
														</tr>
													</table>
												</td>
											</tr>
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
