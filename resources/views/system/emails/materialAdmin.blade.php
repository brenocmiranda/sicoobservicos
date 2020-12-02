<html>
<body>
	<div>
		<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF" style="border-radius:5px;border:1px solid #dddddd">
			<tbody>
				<tr bgcolor="#f4f4f4">
					<td>
						<table>
							<tbody>
								<tr>
									<td style="padding:15px 15px 15px 30px"><img src="https://media.solumbox.com//img/i/6887ace8-40a3-43b2-be7a-e4a0b61e2213/1000" alt="" height="50">
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding:30px 30px 20px 30px;border-radius:5px">
						<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
							<tbody>
								<tr>
									<td align="left" id="m_42936987098664594m_1127568141554999x_content-5" style="font-size:15px;font-family:Helvetica,Arial,sans-serif;line-height:25px;color:#222222">
										<div><span>
											<p style="margin-top:0px;margin-bottom:10px">
											</p>
											@if($material->status == 0)
												<p>
													<b>Obaaa, recebemos uma nova solicitação de material!</b>
												</p>
												<label>Neste momento separe os itens para entrega e encaminhe para o usuário que solicitou. Veja abaixo, os dados da solicitação:</label>
												<br>
												<p style="text-align:justify">
													<ul>
														<li><b>Produto:</b> {{$material->RelationMaterial->nome}}</li>
														<li><b>Quantidade:</b> {{$material->quantidade}} unidades</li>
														<li><b>Usuário:</b> {{$material->RelationUsuario->RelationAssociado->nome}}</li>
													</ul>
													<div>
														<label><a href="{{route('exibir.solicitacoes.administrativo')}}"><b>Gerencie suas solicitações de materiais</b></a></label>
													</div>
												</p>
											@else
												<p>
													<b>Eitaaa, a solicitação de material de nº {{$material->id}} acaba de ser cancelada!</b>
												</p>
												<label>Veja mais informações sobre essa solicitação:</label>
												<br>
												<p style="text-align:justify">
													<ul>
														<li><b>Mótivo:</b> {{$material->observacao}}</li>
														<li><b>Produto:</b> {{$material->RelationMaterial->nome}} ({{$material->quantidade}} unidades)</li>										
													</ul>
													<div>
														<label><a href="{{route('exibir.solicitacoes.administrativo')}}"><b>Gerencie suas solicitações de materiais</b></a></label>
													</div>
												</p>
											@endif
											<p style="margin-top:10px;margin-bottom:10px"><span style="color:rgb(0,0,0)"><span></span></span></p>
											<p></p><p></p></span></div>
										</td>
									</tr>
								</tbody>
							</table>
							<div>
								<div>
									<div id="m_42936987098664594q_75" aria-label="Ocultar conteúdo expandido" aria-expanded="true">
										<div></div>
									</div>
								</div>
								<div>
									<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
										<tbody>
											<tr>
												<td height="30" style="border-top:1px solid #dddddd"></td>
											</tr>
										</tbody>
									</table>
									<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
										<tbody>
											<tr>
												<td align="left">
													<table cellpadding="0" border="0" cellspacing="0" align="left">
														<tbody>
															<tr>
																<td align="left" id="m_42936987098664594m_1127568141554999x_content-9" style="font-size:14px;font-family:Helvetica,Arial,sans-serif;line-height:23px;color:#222222;width:100%">
																	<div>
																		<p style="margin-top:0px;margin-bottom:10px">
																			<b>Equipe {{env('APP_NAME')}}</b><br>
																			<a href="{{env('APP_URL')}}" target="_blank">{{env('APP_URL')}}</a><br>
																			
																		</p>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
									<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#ffffff">
										<tbody>
											<tr>
												<td height="20"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
	</html>