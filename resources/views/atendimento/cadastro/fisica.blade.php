<div class="col-12 col-lg-11 mx-auto slideInLeft animated webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend mt-5" id="dadosPF" style="display: none">
	<form class="form-sample" id="formPF" method="POST" enctype="multipart/form-data" action="{{route('salvarPF.cadastro.atendimento')}}" autocomplete="off">
	@csrf
		<input type="hidden" name="sigla" value="PF">
		<div id="smartwizardPF" class="sw sw-justified sw-theme-arrows border-top-0">
			<ul class="nav border-0 hidden-xs" style="font-size: 1.4rem;">
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
			<div class="tab-content col-12 m-auto h-100 px-0">
				<div class="error text-danger text-center font-weight-bold"></div>
				<div id="step-1" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-1">
					<div class="row col-12 mx-auto px-0">
						<div class="col-lg-4 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0 tipoDocumento">CPF <span class="text-danger">*</span></label>
								<input class="form-control form-control-line cpf" name="documento" id="cpf" placeholder="000.000.000-00" onkeyup="$(this).removeClass('border-danger');" required/>
							</div>
						</div>
						<div class="col-lg-3 col-3 px-0 px-lg-4 my-auto verificarDocumentoPF font-weight-bold"></div>
						<div class="col-lg-9 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="nome" id="nome" onkeyup="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" placeholder="PEDRO HENRIQUE DOS SANTOS OLIVEIRA" onchange="this.value = this.value.toUpperCase();" required/>
							</div>
						</div>
						<div class="col-lg-6 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">Sexo <span class="text-danger">*</span></label>
								<select class="form-control form-control-line" onchange="$(this).removeClass('border-danger');" name="sexo" id="sexo" required>
									<option value="">Selecione</option>
									<option value="Masculino">Masculino</option>
									<option value="Feiminino">Feiminino</option>
									<option value="Outros">Outros</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">Naturalidade <span class="text-danger">*</span></label>
								<input class="form-control form-control-line" name="naturalidade" id="naturalidade" onchange="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" onkeyup="this.value = this.value.toUpperCase();" required/>
							</div>
						</div>
						<div class="col-lg-6 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">Estado Cívil <span class="text-danger">*</span></label>
								<select class="form-control form-control-line" onchange="$(this).removeClass('border-danger');" name="estadoCivil" id="estadoCivil" required>
									<option value="">Selecione</option>
									<option value="Solteiro">Solteiro</option>
									<option value="Casado">Casado</option>
									<option value="Viuvo">Viuvo</option>
									<option value="Divorciado">Divorciado</option>
									<option value="Outros">Outros</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">Escolaridade <span class="text-danger">*</span></label>
								<select class="form-control form-control-line" onchange="$(this).removeClass('border-danger');" name="escolaridade" id="escolaridade" required>
									<option value="">Selecione</option>
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
						<div class="col-12 row px-0 mx-auto">
							<div class="col-lg-6 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label pb-0">Profissão <span class="text-danger">*</span></label>
									<input class="form-control form-control-line" name="profissao" id="profissao" onkeyup="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" onchange="this.value = this.value.toUpperCase();" required/>
								</div>
							</div>
							<div class="col-lg-4 col-12 px-0 px-lg-4">
								<div class="form-group">
									<label class="col-form-label pb-0">Data de contratação <span class="text-danger">*</span></label>
									<input type="date" class="form-control form-control-line" onkeyup="$(this).removeClass('border-danger');" name="data_contratacao" id="data_contratacao" required>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label">Observações</label>
								<textarea class="form-control form-control-line" name="observacoes" placeholder="Digite suas observações" onkeyup="this.value = this.value.toUpperCase();" rows="4" ></textarea>
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
									<select class="form-control form-control-line" name="tipoTelefone[]" onchange="$(this).removeClass('border-danger');"  required>
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
									<input class="form-control form-control-line numeroTelefone" onkeyup="$(this).removeClass('border-danger');" name="numeroTelefone[]" placeholder="(38) 99168-0335" required/>
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

						<div class="col-lg-12 col-12 px-0 px-lg-4">
							<div class="form-group">
								<label class="col-form-label pb-0">E-mail <small>(Preencha está informação para atividades futuras)</small></label>
								<input type="email" class="form-control form-control-line" name="email" placeholder="servicos@sicoobsertaominas.com.br"/>
							</div>
						</div>
					</div>
				</div>
				<div id="step-3" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-3">
					<div class="row col-12 mx-auto px-0">
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Certidão de Nascimento, RG, CNH ou CTPS <span class="text-danger">*</span></label>
								<div class="row dadosIdentificacao">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeIdentificacao" onkeyup="this.value = this.value.toUpperCase();"  style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="DOCUMENTO DE IDENTIFICACAO" required>
										<label for="fupload1" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
										<input type="file" name="documentoIdentificacao[]" id="fupload1" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this)" required>
									</div>
								</div>
							</div>
							<a href="javascript:" id="btnIdentificacao"> <i class="ti-plus pr-2"></i> Adicionar mais arquivos</a>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">CPF <span class="text-danger">*</span></label>
								<div class="row">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeCPF" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="CPF" required>
										<label for="fupload2" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
										<input type="file" name="documentoCPF" id="fupload2" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this)" required>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Comprovante de Renda <b>(atual)</b> <span class="text-danger">*</span></label>
								<div class="row">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeRenda" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="COMPROVANTE DE RENDA" required>
										<label for="fupload3" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
										<input type="file" name="documentoRenda" id="fupload3" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this)" required>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Comprovante de Residência <b>(atual)</b> <span class="text-danger">*</span></label>
								<div class="row">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeResidencia" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="COMPROVANTE DE RENSIDENCIA" required>
										<label for="fupload4" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
										<input type="file" name="documentoResidencia" id="fupload4" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this)" required>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Certidão de casamento <b>(se casado)</b></label>
								<div class="row">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeCasamento" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="CERTIDAO DE CASAMENTO">
										<label for="fupload5" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
										<input type="file" name="documentoCasamento" id="fupload5" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this)">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 mb-4 px-0 px-lg-4">
							<div class="form-group mb-0">
								<label class="col-form-label">Recibo e Declaração de Imposto de Renda</label>
								<div class="row dadosImposto">
									<div class="row col-12 justify-content-center mx-auto mb-2">
										<input type="text" class="form-control col-10 px-3 h-100" name="nomeImposto" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="DECLARACAO DE IMPOSTO">
										<label for="fupload6" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
										<input type="file" name="documentoImposto[]" id="fupload6" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="arquivo(this)">
									</div>
								</div>
							</div>
							<a href="javascript:" id="btnImposto"> <i class="ti-plus pr-2"></i> Adicionar mais arquivos</a>
						</div>
					</div>
				</div>
				<div id="step-4" class="tab-pane w-100" role="tabpanel" aria-labelledby="step-4">
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
						<div class="col-12 px-0 mt-5 pt-5 justify-content-center image" style="display: none;">
							<img id="PreviewImage" src="" class="col-12 col-lg-4 px-0">
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
			<div class="toolbar toolbar-bottom text-center" role="toolbar">
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
					<i class="mdi mdi-cube-send pl-2"></i> 
				</button>
			</div>
		</div>
	</form>
</div>