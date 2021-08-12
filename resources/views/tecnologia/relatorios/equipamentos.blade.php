<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Relatório do invetário &#183 Sicoob Serviços</title>
	
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
								<h3 style="padding: 0; margin: 5px;">Relatório do inventário </h3>
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
		@foreach($equipamentos as $equipamento)
		<tr>
			<td style="border-bottom: 1px solid black;">
				<table width="100%" align="center">
					<tr>
						<td style="padding: 20px 0;">
							<table width="100%" align="center">
								<tr>
									<td>
										<table width="100%" align="center">
											<tr>
												@if(isset($dados['id_imagem']))
												<td style="padding-right: 20px;" width="35%">
													<table width="100%" align="center">
														<tr>
															<td>
																<img src="{{storage_path('app/'.$equipamento->RelationImagemPrincipal->endereco)}}" alt="" width="270" height="260" style="border-radius: 5px;">
															</td>
														</tr>
													</table>
												</td>
												@endif
												<td valign="top" width="65%">
													<table width="100%" align="center">
														@if(isset($dados['id_equipamento']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Equipamento:</label>
																	<label>{{$equipamento->RelationEquipamento->nome}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['id_marca']))
														<tr>
															<td>
																
																<div>
																	<label style="font-weight: 700;">Marca:</label>
																	<label>{{$equipamento->RelationMarca->nome}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['modelo']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Modelo:</label>
																	<label>{{$equipamento->modelo}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['serialNumber']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Nº de série:</label>
																	<label>{{$equipamento->serialNumber}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['n_patrimonio']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Nº de patrimônio:</label>
																	<label>{{$equipamento->n_patrimonio}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['serviceTag']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Service TAG:</label>
																	<label>{{(!empty($equipamento->serviceTag) ? $equipamento->serviceTag : '-')}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['sistema_operacional']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Sistema Operacional:</label>
																	<label>{{(!empty($equipamento->sistema_operacional) ? $equipamento->sistema_operacional : '-')}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['tipo_licenca']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Tipo de licença:</label>
																	<label>{{(!empty($equipamento->tipo_licenca) ? $equipamento->tipo_licenca : '-')}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['antivirus']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Antivírus:</label>
																	<label>{{(!empty($equipamento->antivirus) ? $equipamento->antivirus : '-')}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['id_unidade']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Unidade:</label>
																	<label>{{$equipamento->RelationUnidade->nome}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['id_setor']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Setor:</label>
																	<label>{{$equipamento->RelationSetor->nome}}</label>
																</div>=
															</td>
														</tr>
														@endif
														@if(isset($dados['id_usuario']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Usuário responsável:</label>
																	<label>{{$equipamento->RelationUsuario->last()->RelationAssociado->nome}}</label>
																</div>
															</td>
														</tr>
														@endif
														@if(isset($dados['descricao']))
														<tr>
															<td>
																<div>
																	<label style="font-weight: 700;">Descrição:</label>
																	<label>{{$equipamento->descricao}}</label>
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
								<tr>
									<td>
										<table width="100%" align="center">
											@if(isset($dados['id_imagem_outras']))
											<tr>
												<td>
													<table width="100%" align="center">
														<tr>
															<td>
																<table width="100%" align="center">
																	<tr>
																		<td style="padding-bottom: 8px;" colspan="4"> 
																			<label style="font-weight: 700;">Outras imagens:</label> 
																		</td>
																	</tr>
																	<tr>
																		@foreach($equipamento->RelationImagem as $imagens)
																			<td width="20%" style="padding: 0 5px;">
																				<img src="{{storage_path('app/'.$imagens->endereco)}}" width="150">
																			</td>
																		@endforeach
																	</tr>
																</table>
															</td>
														</tr>
													</table>
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
