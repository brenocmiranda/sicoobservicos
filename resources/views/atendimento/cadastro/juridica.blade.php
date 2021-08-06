<div class="col-12 col-lg-11 mx-auto slideInRight animated webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend mt-5" id="dadosPJ" style="display: none">
	<form class="form-sample" id="formPJ" method="POST" enctype="multipart/form-data" action="{{route('salvarPJ.cadastro.atendimento')}}" autocomplete="off">
		@csrf
		<input type="hidden" name="sigla" value="PJ">
		<div id="smartwizardPJ" class="sw sw-justified sw-theme-arrows border-top-0">
			<ul class="nav border-0 hidden-xs" style="font-size: 1.4rem;">
				<li class="nav-item col">
					<a class="nav-link inactive active" href="#step-1">
						<strong>Etapa 1</strong> <br> 
						<span>Dados da empresa</span>
					</a>
				</li>
				<li class="nav-item col">
					<a class="nav-link inactive" href="#step-2">
						<strong>Etapa 2</strong> <br>
						<span>Contatos</span>
					</a>
				</li>
				<li class="nav-item col">
					<a class="nav-link inactive" href="#step-3">
						<strong>Etapa 3</strong> <br>
						<span>Documentos</span>
					</a>
				</li>
				<li class="nav-item col">
					<a class="nav-link inactive" href="#step-4">
						<strong>Etapa 4</strong> <br>
						<span>Sócios</span>							
					</a>
				</li>
				<li class="nav-item col">
					<a class="nav-link inactive done" href="#step-5">
						<strong>Etapa 5</strong> <br>
						<span>Assinaturas</span>
					</a>
				</li>
			</ul>
			<div class="tab-content col-12 m-auto h-100 px-0">
				<div class="error text-danger text-center"></div>
				<div id="step-1" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-1">
					<div class="row col-12 mx-auto px-0">
						<div class="row mx-auto col-12 px-0">
							<div class="col-lg-4 col-9 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label pb-0 tipoDocumento">CNPJ <span class="text-danger">*</span></label>
									<input class="form-control form-control-line cnpj" name="documento" id="cnpj" placeholder="00.000.000/0000-00" onkeyup="$(this).removeClass('border-danger');" required/>
								</div>
							</div>
							<div class="col-lg-3 col-3 my-auto verificarDocumentoPJ px-0 font-weight-bold"></div>
						</div>
						<div class="col-lg-9 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">Nome Fantasia <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="nome_fantasia" id="fantasia" onkeyup="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" placeholder="Sicoob Sertão Minas" onchange="this.value = this.value.toUpperCase();" required/>
							</div>
						</div>
						<div id="dadosReceita" style="display: none;">
							<div class="col-lg-9 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label">Razão Social </label>
									<input type="hidden" name="nome" id="razaoSocial" required/>
									<label class="razaoSocial d-block">-</label>
								</div>
							</div>
							<div class="col-lg-7 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label">Atividade Principal </label>
									<input type="hidden" name="atividade_economica" id="atividade_economica" required/>
									<label class="atividade_principal d-block">-</label>
								</div>
							</div>
							<div class="col-lg-5 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label">Tipo </label>
									<label class="tipo d-block">-</label>
								</div>
							</div>
							<div class="col-lg-4 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label">Situação <small>(Data: <span class="data_situacao">-</span>)</small></label>
									<input type="hidden" name="situacao" id="situacao" required/>
									<label class="situacao d-block">-</label>
								</div>
							</div>
							<div class="col-lg-3 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label">Porte</label>
									<input type="hidden" name="porte_cliente" id="porte_cliente" required/>
									<label class="porte d-block">-</label>
								</div>
							</div>
							<div class="col-lg-4 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label">Data abertura</label>
									<input type="hidden" name="data_abertura" id="data_abertura" required/>
									<label class="data_abertura d-block">-</label>
								</div>
							</div>
							<div class="col-lg-9 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label">Endereço </label>
									<label class="endereco d-block">-</label>
								</div>
							</div>		
						</div>
						<div class="col-12 col-lg-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label">Observações</label>
								<textarea class="form-control form-control-line" name="observacoes" placeholder="Digite suas observações" onkeyup="this.value = this.value.toUpperCase();" rows="5" ></textarea>
							</div>
						</div>
					</div>
				</div>
				<div id="step-2" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-2">
					<div class="row col-12 mx-auto px-0">
						<div class="col-12 px-0">
							<div class="col-lg-4 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label pb-0">Tipo <span class="text-danger">*</span></label>
									<select class="form-control form-control-line" name="tipoTelefone[]" required>
										<option value="">Selecione</option>
										<option value="celular">Celular</option>
										<option value="residencial">Residencial</option>
										<option value="comercial">Comercial</option>
										<option value="recado">Recado</option>
										<option value="fax">Fax</option>
									</select>
								</div>
							</div>
							<div class="col-lg-5 col-11 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label pb-0">Número <span class="text-danger">*</span></label>
									<input class="form-control form-control-line numeroTelefone" name="numeroTelefone[]" placeholder="(38) 99168-0335" required/>
								</div>
							</div>
						</div>

						<div class="row col-12 px-0 mx-auto dadosTelefone"></div>
						<div class="col-lg-12 col-12 mb-4 px-0 px-lg-4">
							<a href="javascript:" class="novoTelefone">
								<i class="mdi mdi-plus mr-2"></i> 
								<span>Mais telefones</span> 
							</a>
						</div>

						<div class="col-lg-12 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">E-mail <span class="text-danger">*</span></label>
								<input type="email" class="form-control form-control-line" name="email" placeholder="servicos@sicoobsertaominas.com.br" required/>
							</div>
						</div>
					</div>
				</div>
				<div id="step-3" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-3">
					<div class="row col-12 mx-auto px-0">
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Contrato Social, Requerimento de Empresário, MEI ou Estatuto <span class="text-danger">*</span></label>
								<div class="row dadosContrato">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeContrato" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="CONTRATO SOCIAL" required>
										<label for="fupload8" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoContrato[]" id="fupload8" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" required>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Faturamento dos Últimos 12 meses <span class="text-danger">*</span></label>
								<div class="row dadosFaturamento">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeFaturamento" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="FATURAMENTO" required>
										<label for="fupload9" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoFaturamento[]" id="fupload9" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" required>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Comprovante de Endereço Comercial <b>(atual)</b> <span class="text-danger">*</span></label>
								<div class="row dadosEndereco">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeEnderecoComercial" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="ENDEREÇO" required>
										<label for="fupload10" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoEnderecoComercial[]" id="fupload10" class="position-absolute col-12 px-0" style="opacity: 0; top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" required>
										</label>
									</div>
								</div>
							</div>
						</div>
						<!--
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Incrição Estadual</label>
								<div class="row dadosInscricao">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeInscricao" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" value="INSCRIÇÃO ESTADUAL" placeholder="Nome do arquivo">
										<label for="fupload11" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoInscricao[]" id="fupload11" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)">
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Extrato do Simples Nacional</label>
								<div class="row dadosSimples">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeSimples" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" value="SIMPLES NACIONAL" placeholder="Nome do arquivo">
										<label for="fupload12" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoSimples[]" id="fupload12" class="position-absolute col-12 px-0" style="opacity: 0; top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" >
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Última Alteração Contratual ou Estatutárias</label>
								<div class="row dadosAlteracao">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeAlteracao" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" value="ALTERAÇÃO CONTRATUAL" placeholder="Nome do arquivo">
										<label for="fupload13" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoAlteracao[]" id="fupload13" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)">
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Ata de Eleição da Diretoria <b>(S/A ou Cooperativa)</b></label>
								<div class="row dadosAta">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeAta" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" value="ATA DE ELEIÇÃO" placeholder="Nome do arquivo">
										<label for="fupload14" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoAta[]" id="fupload14" class="position-absolute col-12 px-0" style="opacity: 0; top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)">
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Instrumento de Mandato/Carta de revigoramento</label>
								<div class="row dadosMandato">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeMandato" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" value="INSTRUMENTO DE MANDATO" placeholder="Nome do arquivo">
										<label for="fupload15" class="btn btn-default col-2 px-0 border-0 " title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
											<i class="mdi mdi-file"></i>
											<input type="file" name="documentoMandato[]" id="fupload15" class="position-absolute col-12 px-0" style="opacity: 0; top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)">
										</label>
									</div>
								</div>
							</div>
						</div>
						-->
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Outros arquivos</label>
								<div class="row dadosOutrosPJ mb-2"></div>
								<a href="javascript:" id="btnOutrosPJ"> 
									<i class="ti-plus pr-2"></i> 	
									<span>Adicionar arquivos</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div id="step-4" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-4">
					<div class="col-lg-11 col-12 px-0 px-lg-4 mx-lg-4">
						<div class="form-group">
							<div class="row dadosSocios">
								<div class="col-12 mb-2 mt-1"> 
									<label class="col-12 col-form-label px-0">Sócio <span class="text-danger">*</span>
									</label> 
									<div class="row mx-auto">
										<select class="form-control form-control-line col-2 tipoAssociado" name="tipoAssociado">
											<option value="cli_associados">Já associado</option>
											<option value="cad_novos">Novo</option>
										</select>
										<input class="col-8 col-lg-9 form-control form-control-line pesquisar px-2 ui-autocomplete-input" onkeyup="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" placeholder="Entre com nome ou documento do associado..." onchange="this.value = this.value.toUpperCase();" aria-controls="table" name="socios[]" required autocomplete="off"> 
										<div class="col-2 col-lg-1 d-flex">
											<a href="#" class="btn btn-default btn-xs mx-1 my-auto text-center" data-toggle="modal" data-target="#modal-socios" title="Cadastrar novo associado">
												<i class="mdi mdi-account-plus"></i>
											</a>
											<a href="javascript:" class="btn btn-danger btn-xs mx-1 my-auto text-center disabled" title="Remover o associado"> 
												<i class="mdi mdi-delete"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-12 px-0 px-lg-4 mx-lg-4">
						<a href="javascript:" id="btnSocios" title="Selecione mais sócios"> 
							<i class="ti-plus pr-2"></i>
							<span>Selecionar mais sócios</span> 
						</a>
					</div>
				</div>
				<div id="step-5" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-5">
					<div class="row col-12 mx-auto px-0">
						<div class="col-12 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Cartão de assinatura <span class="text-danger">*</span></label>
								<div class="row">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeCartao" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="CARTAO DE ASSINATURA">
										<label for="fupload15" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
										<input type="file" name="cartaoAssinatura" id="fupload15" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="cartao(this); ">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 px-0 mt-5 pt-5 d-flex justify-content-center imagePJ">
							<img id="PreviewImagePJ" src="">
							<input type="hidden" id="xPJ" name="x" />
					        <input type="hidden" id="yPJ" name="y" />
					        <input type="hidden" id="wPJ" name="w" />
					        <input type="hidden" id="hPJ" name="h" />
						</div>
						<div class="col-12 mt-3">
							<div class="checkbox checkbox-success mb-0 text-center">
								<input id="checkbox-1" type="checkbox" checked disabled>
								<label for="checkbox-1"  style="opacity: 1 !important;"> Declaro todas as informações fornecidas nesse cadastro conferem com as originais. </label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="toolbar toolbar-bottom" role="toolbar" style="text-align: center;">
				<button class="btn sw-btn-prev disabled" type="button">
					<i class="mdi mdi-arrow-left"></i> 
					<span>Anterior</span>
				</button>
				<button class="btn sw-btn-next" type="button">
					<span>Próximo</span>
					<i class="mdi mdi-arrow-right"></i> 
				</button>
				<button type="submit" class="btn sw-btn-enviar" style="display: none;"> 
					<span>Finalizar</span> 
					<i class="mdi mdi-check-all pl-2"></i> 
				</button>
			</div>
		</div>
	</form>
</div>