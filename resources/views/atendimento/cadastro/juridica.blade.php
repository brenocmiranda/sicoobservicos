<div class="col-11 mx-auto slideInRight animated webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend" id="dadosPJ" style="display: none">
	<div id="smartwizardPJ" class="sw sw-justified sw-theme-arrows border-top-0">

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
					<span>Sócios</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link inactive" href="#step-5">
					<strong>Etapa 5</strong> <br>
					<span>Assinaturas</span>
				</a>
			</li>
		</ul>
		<form class="form-sample" id="formPJ" enctype="multipart/form-data" autocomplete="off">
			@csrf
			<input type="hidden" name="sigla" value="PF">
			<div class="tab-content col-12 mx-auto h-100">
				<div id="step-1" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-1">
					<div class="row col-12 mx-auto">
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0 tipoDocumento">CNPJ <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="documento" id="documento1" placeholder="00.000.000/0000-00" required/>
							</div>
						</div>
						<div class="col-lg-9 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Razão Social <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="nome" onkeyup="this.value = this.value.toUpperCase();" placeholder="Cooperativa de Crédito de Livre Admissão do Sertão de Minas Gerais Ltda" onchange="this.value = this.value.toUpperCase();" required/>
							</div>
						</div>
						<div class="col-lg-9 col-12">
							<div class="form-group">
								<label class="col-form-label pb-0">Nome Fantasia <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="nomeFantasia" onkeyup="this.value = this.value.toUpperCase();" placeholder="Sicoob Sertão Minas" onchange="this.value = this.value.toUpperCase();" required/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Observações</label>
								<textarea class="form-control form-control-line" name="observacoes" placeholder="Digite suas observações" onkeyup="this.value = this.value.toUpperCase();" rows="5" ></textarea>
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
								<label class="col-form-label">Contrato Social, Requerimento de Empresário, MEI ou Estatuto <span class="text-danger">*</span></label>
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
								<label class="col-form-label">Faturamento dos Últimos 12 meses <span class="text-danger">*</span></label>
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
								<label class="col-form-label">Comprovante de Endereço Comercial <b>(atual)</b> <span class="text-danger">*</span></label>
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
								<label class="col-form-label">Incrição Estadual</label>
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
											<input type="file" name="documentoInscricao"> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Extrato do Simples Nacional</label>
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
											<input type="file" name="documentoSimples"> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Última Alteração Contratural ou Estatutárias</label>
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
											<input type="file" name="documentoAlteracaoContrato"> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Ata de Eleição da Diretoria <b>(S/A ou Cooperativa)</b></label>
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
											<input type="file" name="documentoAta"> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label class="col-form-label">Instrumento de Mandato/Carta de revigoramento</label>
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
											<input type="file" name="documentoInstumento"> 
										</span> 
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="step-4" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-4">
					<div class="col-lg-10 col-12 px-0">
						<div class="form-group">
							<label class="col-form-label pb-0">Sócio 1 <span class="text-danger">*</span></label>
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
					<div class="col-lg-10 col-12 px-0">
						<a href="javascript:">
							<i class="mdi mdi-plus"></i>
							<span>Cadastrar novo associado</span>
						</a>
					</div>
				</div>
				<div id="step-5" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-5">
					<div class="row col-12 mx-auto">


					</div>
				</div>
			</div>
		</form>
		<div class="toolbar toolbar-bottom mt-4" role="toolbar" style="text-align: center;">
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
		</div>
	</div>
</div>