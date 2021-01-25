<div class="col-11 mx-auto slideInLeft animated webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend" id="dadosPF" style="display: none">
	<form class="form-sample" id="formPF" method="POST" enctype="multipart/form-data" action="{{route('cadastrar.cadastro.atendimento')}}" autocomplete="off">
	@csrf
		<input type="hidden" name="sigla" value="PF">
		<div id="smartwizardPF" class="sw sw-justified sw-theme-arrows border-top-0">
			<ul class="nav border-0" style="font-size: 1.4rem;">
				<li class="nav-item">
					<a class="nav-link inactive active" href="#step-1">
						<strong>Etapa 1</strong> <br> 
						<span>Dados pessoais</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link inactive done" href="#step-2">
						<strong>Etapa 2</strong> <br>
						<span>Contatos</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link inactive" href="#step-3">
						<strong>Etapa 3</strong> <br>
						<span>Documentos</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link inactive" href="#step-4">
						<strong>Etapa 4</strong> <br>
						<span>Assinaturas</span>
					</a>
				</li>
			</ul>
			<div class="tab-content col-12 mx-auto h-100">
				<div id="step-1" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-1">
					<div class="row col-12 mx-auto">
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0 tipoDocumento">CPF <span class="text-danger">*</span></label>
								<input class="form-control form-control-line cpf" name="documento" id="cpf" placeholder="000.000.000-00" required/>
							</div>
						</div>
						<div class="col-lg-3 my-auto verificarDocumentoPF px-0 font-weight-bold"></div>
						<div class="col-lg-9 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="nome" id="nome" onkeyup="this.value = this.value.toUpperCase();" placeholder="PEDRO HENRIQUE DOS SANTOS OLIVEIRA" onchange="this.value = this.value.toUpperCase();" required/>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Sexo <span class="text-danger">*</span></label>
								<select class="form-control form-control-line" name="sexo" id="sexo" required>
									<option>Selecione</option>
									<option value="Masculino">Masculino</option>
									<option value="Feiminino">Feiminino</option>
									<option value="Outros">Outros</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Naturalidade <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="naturalidade" id="naturalidade" onkeyup="this.value = this.value.toUpperCase();" onchange="this.value = this.value.toUpperCase();" required/>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Estado Cívil <span class="text-danger">*</span></label>
								<select class="form-control form-control-line" name="estadoCivil" id="estadoCivil" required>
									<option>Selecione</option>
									<option value="Solteiro">Solteiro</option>
									<option value="Casado">Casado</option>
									<option value="Viuvo">Viuvo</option>
									<option value="Divorciado">Divorciado</option>
									<option value="Outros">Outros</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Escolaridade <span class="text-danger">*</span></label>
								<select class="form-control form-control-line" name="escolaridade" id="escolaridade" required>
									<option>Selecione</option>
									<option value="Fundamental - Incompleto">Fundamental - Incompleto</option>
									<option value="Fundamental - Completo">Fundamental - Completo</option>
									<option value="Médio - Incompleto">Médio - Incompleto</option>
									<option value="Médio - Completo">Médio - Completo</option>
									<option value="Superior - Incompleto">Superior - Incompleto</option>
									<option value="Superior - Completo">Superior - Completo</option>
									<option value="Pós-graduação (Lato senso) - Incompleto">Pós-graduação (Lato senso) - Incompleto</option>
									<option value="Pós-graduação (Lato senso) - Completo">Pós-graduação (Lato senso) - Completo</option>
									<option value="Pós-graduação (Stricto sensu, nível mestrado) - Incompleto">Pós-graduação (Stricto sensu, nível mestrado) - Incompleto</option>
									<option value="Pós-graduação (Stricto sensu, nível mestrado) - Completo">Pós-graduação (Stricto sensu, nível mestrado) - Completo</option>
									<option value="Pós-graduação (Stricto sensu, nível doutor) - Incompleto">Pós-graduação (Stricto sensu, nível doutor) - Incompleto</option>
									<option value="Pós-graduação (Stricto sensu, nível doutor) - Completo">Pós-graduação (Stricto sensu, nível doutor) - Completo</option>
								</select>
							</div>
						</div>
						<div class="col-12 row p-0 mx-auto">
							<div class="col-lg-6 col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Profissão <span class="text-danger">*</span></label>
									<input class="form-control form-control-line" name="profissao" id="profissao" onkeyup="this.value = this.value.toUpperCase();" onchange="this.value = this.value.toUpperCase();" required/>
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Data de contratação <span class="text-danger">*</span></label>
									<input type="date" class="form-control form-control-line" name="data_contratacao" id="data_contratacao" required>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Observações</label>
								<textarea class="form-control form-control-line" name="observacoes" placeholder="Digite suas observações" onkeyup="this.value = this.value.toUpperCase();" rows="4" ></textarea>
							</div>
						</div>
					</div>
				</div>
				<div id="step-2" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-2">
					<div class="row col-12 mx-auto">
						<div class="col-12 px-0">
							<div class="col-lg-4 col-12">
								<div class="form-group">
									<label class="col-form-label pb-0">Tipo <span class="text-danger">*</span></label>
									<select class="form-control form-control-line" name="tipoTelefone[]" required>
										<option>Selecione</option>
										<option value="celular">Celular</option>
										<option value="residencial">Residencial</option>
										<option value="comercial">Comercial</option>
										<option value="recado">Recado</option>
										<option value="fax">Fax</option>
									</select>
								</div>
							</div>
							<div class="col-lg-5 col-11">
								<div class="form-group">
									<label class="col-form-label pb-0">Número <span class="text-danger">*</span></label>
									<input class="form-control form-control-line numeroTelefone" name="numeroTelefone[]" placeholder="(38) 99168-0335" required/>
								</div>
							</div>
						</div>

						<div class="row col-12 px-0 mx-auto dadosTelefone"></div>
						<div class="col-lg-12 col-12 mb-4">
							<a href="javascript:" class="novoTelefone">
								<i class="mdi mdi-plus mr-2"></i> 
								<span>Mais telefones</span> 
							</a>
						</div>

						<div class="col-lg-12 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">E-mail <small>(Preencha está informação para atividades futuras)</small></label>
								<input class="form-control form-control-line" name="email" placeholder="servicos@sicoobsertaominas.com.br"/>
							</div>
						</div>
					</div>
				</div>
				<div id="step-3" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-3">
					<div class="row col-12 mx-auto">
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Certidão de Nascimento, RG, CNH ou CTPS <span class="text-danger">*</span></label>
								<div class="col-12 px-0">
									<div class="fileinput input-group fileinput-new" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput"> 
											<i class="glyphicon glyphicon-file fileinput-exists"></i> 
											<span class="fileinput-filename"></span>
										</div> 
										<span class="input-group-addon btn btn-default btn-file"> 
											<span class="fileinput-new">Selecione o arquivo</span> 
											<span class="fileinput-exists">Alterar</span>
											<input type="hidden" value="" name="...">
											<input type="file" name="documentoIdentificacao" required> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">CPF <span class="text-danger">*</span></label>
								<div class="col-12 px-0">
									<div class="fileinput input-group fileinput-new" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput"> 
											<i class="glyphicon glyphicon-file fileinput-exists"></i> 
											<span class="fileinput-filename"></span>
										</div> 
										<span class="input-group-addon btn btn-default btn-file"> 
											<span class="fileinput-new">Selecione o arquivo</span> 
											<span class="fileinput-exists">Alterar</span>
											<input type="hidden" value="" name="...">
											<input type="file" name="documentoInscricao" required> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Comprovante de Renda <b>(atual)</b> <span class="text-danger">*</span></label>
								<div class="col-12 px-0">
									<div class="fileinput input-group fileinput-new" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput"> 
											<i class="glyphicon glyphicon-file fileinput-exists"></i> 
											<span class="fileinput-filename"></span>
										</div> 
										<span class="input-group-addon btn btn-default btn-file"> 
											<span class="fileinput-new">Selecione o arquivo</span> 
											<span class="fileinput-exists">Alterar</span>
											<input type="hidden" value="" name="...">
											<input type="file" name="documentoRenda" required> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Comprovante de Residência <b>(atual)</b> <span class="text-danger">*</span></label>
								<div class="col-12 px-0">
									<div class="fileinput input-group fileinput-new" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput"> 
											<i class="glyphicon glyphicon-file fileinput-exists"></i> 
											<span class="fileinput-filename"></span>
										</div> 
										<span class="input-group-addon btn btn-default btn-file"> 
											<span class="fileinput-new">Selecione o arquivo</span> 
											<span class="fileinput-exists">Alterar</span>
											<input type="hidden" value="" name="...">
											<input type="file" name="documentoResidencia" required> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Certidão de casamento <b>(se casado)</b></label>
								<div class="col-12 px-0">
									<div class="fileinput input-group fileinput-new" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput"> 
											<i class="glyphicon glyphicon-file fileinput-exists"></i> 
											<span class="fileinput-filename"></span>
										</div> 
										<span class="input-group-addon btn btn-default btn-file"> 
											<span class="fileinput-new">Selecione o arquivo</span> 
											<span class="fileinput-exists">Alterar</span>
											<input type="hidden" value="" name="...">
											<input type="file" name="documentoCasamento"> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Recibo e Declaração de Imposto de Renda</label>
								<div class="col-12 px-0">
									<div class="fileinput input-group fileinput-new" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput"> 
											<i class="glyphicon glyphicon-file fileinput-exists"></i> 
											<span class="fileinput-filename"></span>
										</div> 
										<span class="input-group-addon btn btn-default btn-file"> 
											<span class="fileinput-new">Selecione o arquivo</span> 
											<span class="fileinput-exists">Alterar</span>
											<input type="hidden" value="" name="...">
											<input type="file" name="documentoImpostoRenda"> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div id="step-4" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-4">
					<div class="row col-12 mx-auto">
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Cartão de assinatura <span class="text-danger">*</span></label>
								<div class="col-12 px-0">
									<div class="fileinput input-group fileinput-new" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput"> 
											<i class="glyphicon glyphicon-file fileinput-exists"></i> 
											<span class="fileinput-filename"></span>
										</div> 
										<span class="input-group-addon btn btn-default btn-file"> 
											<span class="fileinput-new">Selecione o arquivo</span> 
											<span class="fileinput-exists">Alterar</span>
											<input type="hidden" value="" name="...">
											<input type="file" name="documentoIdentificacao" required> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="toolbar toolbar-bottom text-center mt-4" role="toolbar">
				<div class="col-12 mb-3">
					<div class="checkbox checkbox-success mb-0 text-center">
						<input id="checkbox-1" type="checkbox" checked required>
						<label for="checkbox-1"> Declaro todas as informações fornecidas nesse cadastro conferem com as originais. </label>
					</div>
				</div>
				<button class="btn sw-btn-prev disabled" type="button">
					<i class="mdi mdi-arrow-left"></i> 
					<span>Anterior</span>
				</button>
				<button class="btn sw-btn-next" type="button">
					<span>Próximo</span>
					<i class="mdi mdi-arrow-right"></i> 
				</button>
				<button type="submit" class="btn sw-btn-enviar" style="display: none;"> 
					<span>Enviar</span> 
					<i class="mdi mdi-check pl-2"></i> 
				</button>
			</div>
		</div>
	</form>
</div>