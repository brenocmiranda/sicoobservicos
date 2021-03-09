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
											@if($chamado->RelationStatus->first()->open == 1)
												<p>
													<b>Opaaa, recebemos um novo chamado!</b>
												</p>
												<label>Neste momento, tente identificar o problema através das evidências anexadas ao chamado. Confira abaixo as informações do chamado:</label>
												<br>
												<p style="text-align:justify">
													<ul>
														<li><b>Usuário:</b> {{$chamado->RelationUsuario->RelationAssociado->nome}}</li>
														<li><b>Ambiente:</b> {{$chamado->RelationAmbientes->nome}}</li>
														<li><b>Fonte:</b> {{$chamado->RelationFontes->nome}}</li>
														<li><b>Assunto:</b> {{$chamado->assunto}}</li>
														<li><b>Descrição:</b> {{$chamado->descricao}}</li>
													</ul>
													<div>
														<label><a href="{{route('detalhes.chamados.gti', $chamado->id)}}"><b>Saiba mais sobre esse chamado.</b></a></label>
													</div>
												</p>
											@elseif($chamado->RelationStatus->first()->finish == 1)
												<p>
													<b>Seu chamado #{{$chamado->id}} resolvido com sucesso!</b>
												</p>
												<label>Verificamos você solucionou um dos seus chamados. Para mais informações acesse o link abaixo:</label>
												<br>
												<p style="text-align:justify">
													<div>
														<label><a href="{{route('detalhes.chamados.gti', $chamado->id)}}"><b>Saiba mais sobre esse chamado.</b></a></label>
													</div>
												</p>
											@else
												<p>
													<b>Obaaa, temos novidades para você!</b>
												</p>
												<label>Seu chamado teve uma atualização no estado, sendo classificado como: <b>{{$chamado->RelationStatus->first()->nome}}.</b> Veja mais detalhes da sua nova atualização:</label>
												<br>
												<p style="text-align:justify">
													<b>{{$chamado->RelationStatus->first()->pivot->descricao}}</b>
												</p>
											@endif
											<br>
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