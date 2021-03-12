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
								<b>Obaaa, {{explode(" ", ucfirst(strtolower($usuario->RelationAssociado->nome)))[0]}}, sua senha foi resetada com sucesso!</b>
							</p>
							<p>
								Você teve os seus dados de acessos atualizados na plataforma <b>{{env('APP_NAME')}}</b>. Entre com as informações abaixo e altere os dados:
							</p>
							<p> 
								<ul>
									<li><b>Usuário:</b> {{$usuario->login}}</li>
									<li><b>Nova senha:</b> Sicoob4133</li>
								</ul>
							</p>
							<p>
								<a href="{{route('login')}}" target="_blank">Acesse a plataforma e faça login.</a>
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