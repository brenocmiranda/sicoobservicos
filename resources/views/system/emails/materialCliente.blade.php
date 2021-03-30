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
							@if($material[0]->status == 0)
								{!! $configuracoes->abertura_solicitacao_material !!}

							@elseif($material[0]->status == 1)
								{!! $configuracoes->fechamento_solicitacao_material !!}
								
								@foreach($material as $atual)
									<ul>
										<li><b>Produto:</b> {{$atual->RelationMaterial->nome}}</li>
										<li><b>Quantidade:</b> {{$atual->quantidade}} unidades</li>
									</ul>
								@endforeach
							@else
								<p>
									<b>Eitaaa, a sua solicitação de material de nº {{$material[0]->id}} acaba de ser cancelada!</b>
								</p>
								<p>
									Veja mais informações sobre essa solicitação:
								</p>
								<p>
									<ul>
										<li><b>Mótivo:</b> {{$material[0]->motivo}}</li>
										<li><b>Produto:</b> {{$material[0]->RelationMaterial->nome}} ({{$material[0]->quantidade}} {{$material[0]->quantidade_tipo}})</li>										
									</ul>
								</p>
							@endif
							<p>
								<a href="{{route('exibir.solicitacoes.materiais')}}" target="_blank">
									<b>Veja todas suas solicitações de materiais.</b>
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