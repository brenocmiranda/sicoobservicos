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
										<img src="https://media.solumbox.com//img/i/b3398ddd-cabc-43c1-8bd4-8002c411f71f/1000" alt="Sicoob Serviços" height="50">
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
							<h4 style="text-decoration: underline;">Todas operações:</h4>
							@if(isset($operacoesOntem))
								@foreach($operacoesOntem as $novas)
									<ul>
										<li>
											<b>Representante:</b> 
										</li>
										<li>
											<b>Razão Social:</b>
											{{$novas->RelationAssociados->nome}}
										</li>
										<li>
											<b>CNPJ:</b> 
											{{(strlen($novas->RelationAssociados->documento) == 11 ? substr($novas->RelationAssociados->documento, 0, 3).'.'.substr($novas->RelationAssociados->documento, 3, 3).'.'.substr($novas->RelationAssociados->documento, 6, 3).'-'.substr($novas->RelationAssociados->documento, 9, 2) : substr($novas->RelationAssociados->documento, 0, 2).'.'.substr($novas->RelationAssociados->documento, 3, 3).'.'.substr($novas->RelationAssociados->documento, 6, 3).'/'.substr($novas->RelationAssociados->documento, 8, 4).'-'.substr($novas->RelationAssociados->documento, 12, 2))}}
										</li>
										<li>
											<b>Telefones disponíveis:</b> 
											<br>
											<span style="font-weight: 600; padding-left: 10px;">Celular:</span> 
											{{$novas->RelationAssociados->RelationTelefones->numero_celular}}
											<br>
											<span style="font-weight: 600; padding-left: 10px;">Residêncial:</span> {{($novas->RelationAssociados->RelationTelefones->numero_residencial > 0 ? $novas->RelationAssociados->RelationTelefones->numero_residencial : "Não possui")}}
										</li>
										<li>
											<b>E-mail:</b> 
											{{$novas->RelationAssociados->RelationEmails->email}}
										</li>
										<li>
											<b>Endereço:</b> 
											{{$novas->RelationAssociados->RelationEnderecos->rua.', '.$novas->RelationAssociados->RelationEnderecos->bairro.', '.$novas->RelationAssociados->RelationEnderecos->numero.', '.$novas->RelationAssociados->RelationEnderecos->cidade.'/'.$novas->RelationAssociados->RelationEnderecos->estado}}
										</li>
									</ul>
								@endforeach
							@else
								<p>Nenhuma nova operação.</p>
							@endif
							<br>
							
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
