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
							@if($chamado->RelationStatus->first()->open == 1)
								<p>
									<b>Opaaa, recebemos um novo chamado!</b>
								</p>
								<p>
									Neste momento, tente identificar o problema através das evidências anexadas ao chamado. Confira abaixo as informações do chamado:
								</p>
								<p>
									<ul>
										<li><b>Usuário:</b> {{$chamado->RelationUsuario->RelationAssociado->nome}}</li>
										<li><b>Ambiente:</b> {{$chamado->RelationAmbientes->nome}}</li>
										<li><b>Fonte:</b> {{$chamado->RelationFontes->nome}}</li>
										<li><b>Assunto:</b> {{$chamado->assunto}}</li>
										<li><b>Descrição:</b> {{$chamado->descricao}}</li>
									</ul>
								</p>
								<p>
									<a href="{{route('detalhes.chamados.gti', $chamado->id)}}" target="_blank">
										<b>Saiba mais sobre esse chamado.</b>
									</a>
								</p>
							@elseif($chamado->RelationStatus->first()->finish == 1)
								<p>
									<b>Seu chamado #{{$chamado->id}} resolvido com sucesso!</b>
								</p>
								<p>
									Verificamos você solucionou um dos seus chamados. Para mais informações acesse o link abaixo:
								</p>
								<p>
									<a href="{{route('detalhes.chamados.gti', $chamado->id)}}" target="_blank">
										<b>Saiba mais sobre esse chamado.</b>
									</a>
								</p>
							@else
								<p>
									<b>Obaaa, temos novidades para você!</b>
								</p>
								<p>
									Seu chamado teve uma atualização no estado, sendo classificado como: <b>{{$chamado->RelationStatus->first()->nome}}.</b> Veja mais detalhes da sua nova atualização:
								</p>
								<p>
									<b>{{$chamado->RelationStatus->first()->pivot->descricao}}</b>
								</p>
							@endif
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