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
										<img src="https://media.solumbox.com//img/i/ade8670d-1d8b-4d5c-988e-db3a4cf5041f/1?v=2" alt="Sicoob Serviços" height="50">
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
								<b>Olá, segue a relação dos dados dos associados com operação de crédito FAMPE no Sicoob Sertão Minas.</b>
							</p>
							<h6>Novas operações</h6>
							@if(isset($operacoesOntem))
								@foreach($operacoesOntem as $novas)
									<ul>
										<li><b>Representante:</b> {{$novas->RelationMaterial->nome}}</li>
										<li><b>Razão Social:</b> {{$novas->quantidade}}</li>
										<li><b>CNPJ:</b> {{$novas->quantidade}}</li>
										<li><b>Telefone:</b> {{$novas->quantidade}}</li>
										<li><b>E-mail:</b> {{$novas->quantidade}}</li>
										<li><b>Endereço:</b> {{$novas->quantidade}}</li>
									</ul>
								@endforeach
							@else
								<p>Nenhuma nova operação.</p>
							@endif
							<br>
							<br>
							<h6>Todas as operações</h6>
							@if(isset($operacoes))
								@foreach($operacoesas $todas)
									<ul>
										<li><b>Representante:</b> {{$todas->RelationMaterial->nome}}</li>
										<li><b>Razão Social:</b> {{$todas->quantidade}}</li>
										<li><b>CNPJ:</b> {{$todas->quantidade}}</li>
										<li><b>Telefone:</b> {{todas->quantidade}}</li>
										<li><b>E-mail:</b> {{$todas->quantidade}}</li>
										<li><b>Endereço:</b> {{$todas->quantidade}}</li>
									</ul>
								@endforeach
							@else
								<p>Nenhuma operação contratada.</p>
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
							<b>Equipe Sicoob Sertão Minas</b><br>
							<a href="http://www.sicoobsertaominas.com.br/" target="_blank">http://www.sicoobsertaominas.com.br/</a><br>
						</font>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
