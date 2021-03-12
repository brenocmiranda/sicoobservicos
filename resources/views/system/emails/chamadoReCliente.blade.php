<html>
<body>
	<div>
		<table width="600" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF" style="border-radius:5px; border:1px solid #dddddd; text-align: left">
			<tbody>
				<tr bgcolor="#f4f4f4">
					<td>
						<table>
							<tbody>
								<tr>
									<td style="padding:15px 15px 15px 30px">
										<img src="https://media.solumbox.com//img/i/6887ace8-40a3-43b2-be7a-e4a0b61e2213/1000" alt="Sicoob Serviços" height="50">
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding: 20px 40px;">
						<font face="Helvetica,Arial,sans-serif" color="#222222" style="font-size:15px; line-height:25px;">
							<p>
								Feito, o seu chamado foi reaberto com sucesso!
							</p>
							<p>
								Os responsáveis foram notificados sobre essas nova atualização e entreram em contato para resolução do problema.
							</p>
							<p>
								<ul>
									<li><b>Ambiente:</b> {{$chamado->RelationAmbientes->nome}}</li>
									<li><b>Fonte:</b> {{$chamado->RelationFontes->nome}}</li>
									<li><b>Assunto:</b> {{$chamado->assunto}}</li>
									<li><b>Descrição:</b> {{$chamado->descricao}}</li>
								</ul>
							</p>
							<p>
								<a href="{{route('exibir.chamados')}}" target="_blank">
									<b>Acesse seus chamados em aberto.</b>
								</a>
							</p>
						</font>
					</td>
				</tr>
				<tr>
					<td>
						<p style="border-top:1px solid #dddddd; margin: 0px 15px 0px 15px"></p>
					</td>
				</tr>
				<tr>
					<td style="padding: 20px 40px;">
						<font face="Helvetica,Arial,sans-serif" color="#222222" style="font-size:15px; line-height:25px;">
							<b>Equipe {{env('APP_NAME')}}</b><br>
							<a href="{{env('APP_URL')}}" target="_blank">{{env('APP_URL')}}</a><br>
						</font>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>