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
											<p>
												<b>Olá, {{explode(" ", ucfirst(strtolower($usuario->RelationAssociado->nome)))[0]}}!</b>
											</p>
											<label>Recebemos uma solicitação de redefinição de senha através da nossa plataforma, para prosseguir com esse procedimento siga o passo a passo abaixo:</label>
											<br>
											<p style="text-align:justify">
												<ul>
													<li>A sua nova senha deve seguir as seguintes políticas de segurança:
													 <ul>
													 	<li>Deve conter no mínimo 8 carácteres;</li>
													 	<li>Possuir carácteres especiais;</li>
													 	<li>Possuir números.</li>
													 </ul>
													</li>
													<li><a href="{{route('view.password', $usuario->remember_token)}}">Acesse aqui para redefinir sua senha.</a></li>
													<li>Faça o login com seus novos dados de acesso.</li>
												</ul>
												<div>
													<label><b>Caso não consiga efetuar essa alteração entre em contato com o administrador.</b></label>
												</div>
											</p>
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