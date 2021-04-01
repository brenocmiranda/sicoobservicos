<html>
<body>
	<div>
		<table width="650" cellpadding="0" border="0" cellspacing="0" align="center" bgcolor="#FFFFFF" style="border-radius:5px; border:1px solid #dddddd; text-align: left">
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
								Eiiiitaaa! Verificamos que você possui <b>{{count($todos)}}</b> {{(count($todos) == 1 ? 'chamado pendente' : 'chamados pendentes')}}. Analise as informações abaixo e faça o tratamento de cada um deles.
							</p>
							@foreach($todos as $dados)
							<p>
								<ul>
									<li><b>Nº chamado:</b> #{{$dados->id}}</li>
									<li><b>Ambiente:</b> {{$dados->RelationAmbientes->nome}}</li>
									<li><b>Fonte:</b> {{$dados->RelationFontes->nome}}</li>
									<li><b>Assunto:</b> {{$dados->assunto}}</li>
									<li><a href="{{route('detalhes.chamados.gti', $dados->id)}}" target="_blank"><b>Mais informações</b></a></li>
								</ul>
							</p>
							@endforeach				
							<p> Estamos a disposição!</p>
							<p>
								<a href="{{route('exibir.chamados.gti')}}" target="_blank">
									<b>Veja todos seus chamados.</b>
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