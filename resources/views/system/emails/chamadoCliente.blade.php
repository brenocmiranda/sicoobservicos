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
							@if($chamado->RelationStatus->first()->open == 1)
								{!! $configuracoes->abertura_chamado !!}
							@elseif($chamado->RelationStatus->first()->finish == 1)
								{!! $configuracoes->fechamento_chamado !!}
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
								<p>
									<b>Responsável: </b>
									<span>{{$chamado->RelationUsuario->RelationAssociado->nome}}</span>
								</p>
							@endif
							<p>
								<a href="{{route('exibir.chamados')}}" target="_blank">
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