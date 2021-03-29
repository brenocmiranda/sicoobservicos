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
								<b>Obaaa, recebemos uma nova solicitação de contrato!</b>
							</p>
							<p>
								Neste momento separe os itens para entrega e entre em contato para o usuário que solicitou. Veja abaixo, os dados da solicitação:
							</p>
							<p>
								<ul>
									<li>
										<small><b>Nº do contrato:</b> {{$contrato->RelationContratos->num_contrato}}</small>
									</li>
									<li>
										<small><b>Associado:</b> {{$contrato->RelationContratos->RelationAssociados->nome}}</small>
									</li>
									<li>
										<small><b>Produto:</b> {{$contrato->RelationContratos->RelationProdutos->nome}} - {{$contrato->RelationContratos->RelationModalidades->nome}}</small>
									</li>
									<li>
										<small><b>Valor do contrato:</b> R$ {{number_format($contrato->RelationContratos->valor_contrato, 2, ',', '.')}}</small>
									</li>
									<li>
										<small><b>Localização:</b> {{$contrato->RelationContratos->RelationArmarios->referencia}}</small>
									</li>
								</ul>
							</p>
							<p>
								<a href="{{route('exibir.solicitacoes.administrativo')}}" target="_blank">
									<b>Aprove as solicitações de materiais</b>
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
