<!-- Modal -->
<div class="modal fade" id="modal-socios" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content" style="width: 130%;">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Adicionar sócio para empresa</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha as informações necessárias para realizar o cadastro do sócio..</p>
        </div>
        <div id="err"></div>
        <ul class="nav customtab nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-user"></i></span><span class="hidden-xs"> Dados pessoais</span></a></li>
          <li role="presentation" class=""><a href="#contatos" aria-controls="contatos" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-mobile"></i></span> <span class="hidden-xs">Contatos</span></a></li>
          <li role="presentation" class=""><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-zip"></i></span> <span class="hidden-xs">Documentos</span></a></li>
          <li role="presentation" class=""><a href="#cartao" aria-controls="cartao" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-ticket"></i></span> <span class="hidden-xs">Cartão de assinatura</span></a></li>
        </ul>
      </div>
      <div class="modal-body">
        <div class="carregamento"></div>
        <form class="form-sample" id="formSocios" method="POST" enctype="multipart/form-data" autocomplete="off">
          @csrf
          <input type="hidden" name="sigla" value="PF">
          <div class="tab-content mt-0">
            <div role="tabpanel" class="tab-pane fade active in" id="dados">
              <div class="row col-12 mx-auto">
                <div class="col-lg-4 col-12 px-0 px-lg-4">
                  <div class="form-group">
                    <label class="col-form-label pb-0 tipoDocumento">CPF <span class="text-danger">*</span></label>
                    <input class="form-control form-control-line cpf" name="documento" placeholder="000.000.000-00" onkeyup="$(this).removeClass('border-danger');" required/>
                  </div>
                </div>
                <div class="col-lg-3 col-3 px-0 px-lg-4 my-auto verificarDocumentoPF font-weight-bold"></div>
                <div class="col-lg-9 col-12 px-0 px-lg-4">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <input class="form-control form-control-line" name="nome" onkeyup="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" placeholder="PEDRO HENRIQUE DOS SANTOS OLIVEIRA" onchange="this.value = this.value.toUpperCase();" required/>
                  </div>
                </div>
                <div class="col-lg-6 col-12 px-0 px-lg-4">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Sexo <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" onchange="$(this).removeClass('border-danger');" name="sexo" required>
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
                    <input class="form-control form-control-line" name="naturalidade" onchange="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" onkeyup="this.value = this.value.toUpperCase();" required/>
                  </div>
                </div>
                <div class="col-lg-6 col-12 px-0 px-lg-4">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Estado Cívil <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" onchange="$(this).removeClass('border-danger');" name="estadoCivil" required>
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
                    <select class="form-control form-control-line" onchange="$(this).removeClass('border-danger');" name="escolaridade" required>
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
                      <input class="form-control form-control-line" name="profissao" onkeyup="this.value = this.value.toUpperCase(); $(this).removeClass('border-danger');" onchange="this.value = this.value.toUpperCase();" required/>
                    </div>
                  </div>
                  <div class="col-lg-4 col-12 px-0 px-lg-4">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Data de contratação <span class="text-danger">*</span></label>
                      <input type="date" class="form-control form-control-line" onkeyup="$(this).removeClass('border-danger');" name="data_contratacao" required>
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
            <div role="tabpanel" class="tab-pane fade" id="contatos">
              <div class="row col-12 mx-auto">

                <div class="col-12 px-0">
                  <div class="col-lg-4 col-12 px-0 px-lg-4">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Tipo <span class="text-danger">*</span></label>
                      <select class="form-control form-control-line" name="tipoTelefone[]" onchange="$(this).removeClass('border-danger');" required>
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
                <div class="col-lg-12 col-12 mb-4 px-0 px-lg-4">
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
            <div role="tabpanel" class="tab-pane fade" id="documentos">
              <div class="row col-12 mx-auto">
                <div class="col-12 mb-4 px-0 px-lg-4">
                  <div class="form-group mb-0">
                    <label class="col-form-label">Certidão de Nascimento, RG, CNH ou CTPS <span class="text-danger">*</span></label>
                    <div class="row dadosIdentificacao">
                      <div class="row col-12 justify-content-center mx-auto mb-2">
                        <input type="text" class="form-control col-10 px-3 h-100" name="nomeIdentificacao" onkeyup="this.value = this.value.toUpperCase();"  style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="DOCUMENTO DE IDENTIFICACAO" required>
                        <label for="fupload1" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
                          <i class="mdi mdi-file"></i>
                          <input type="file" name="documentoIdentificacao[]" id="fupload1" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" required>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-4 px-0 px-lg-4">
                  <div class="form-group mb-0">
                    <label class="col-form-label">CPF <span class="text-danger">*</span></label>
                    <div class="row dadosCPF">
                      <div class="row col-12 justify-content-center mx-auto mb-2">
                        <input type="text" class="form-control col-10 px-3 h-100" name="nomeCPF" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="CPF" required>
                        <label for="fupload2" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
                          <i class="mdi mdi-file"></i>
                          <input type="file" name="documentoCPF[]" id="fupload2" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" required>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-4 px-0 px-lg-4">
                  <div class="form-group mb-0">
                    <label class="col-form-label">Comprovante de Renda <b>(atual)</b> <span class="text-danger">*</span></label>
                    <div class="row dadosRenda">
                      <div class="row col-12 justify-content-center mx-auto mb-2">
                        <input type="text" class="form-control col-10 px-3 h-100" name="nomeRenda" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="COMPROVANTE DE RENDA" required>
                        <label for="fupload3" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
                          <i class="mdi mdi-file"></i>
                          <input type="file" name="documentoRenda[]" id="fupload3" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" required>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-4 px-0 px-lg-4">
                  <div class="form-group mb-0">
                    <label class="col-form-label">Comprovante de Residência <b>(atual)</b> <span class="text-danger">*</span></label>
                    <div class="row dadosResidencia">
                      <div class="row col-12 justify-content-center mx-auto mb-2">
                        <input type="text" class="form-control col-10 px-3 h-100" name="nomeResidencia" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="COMPROVANTE DE RENSIDENCIA" required>
                        <label for="fupload4" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
                          <i class="mdi mdi-file"></i>
                          <input type="file" name="documentoResidencia[]" id="fupload4" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)" required>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-4 px-0 px-lg-4">
                  <div class="form-group mb-0">
                    <label class="col-form-label">Certidão de casamento <b>(se casado)</b></label>
                    <div class="row dadosCasamento">
                      <div class="row col-12 justify-content-center mx-auto mb-2">
                        <input type="text" class="form-control col-10 px-3 h-100" name="nomeCasamento" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="CERTIDAO DE CASAMENTO">
                        <label for="fupload5" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
                          <i class="mdi mdi-file"></i>
                          <input type="file" name="documentoCasamento[]" id="fupload5" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)">
                        </label>
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
                        <label for="fupload6" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;">
                          <i class="mdi mdi-file"></i>
                          <input type="file" name="documentoImposto[]" id="fupload6" class="position-absolute col-12 px-0" style="opacity: 0;top: 0; height: 100%;" accept="application/pdf" onchange="arquivo(this)">
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-4 px-0 px-lg-4">
                  <div class="form-group mb-0">
                    <label class="col-form-label">Outros arquivos</label>
                    <div class="row dadosOutrosPF mb-2"></div>
                  </div>
                  <a href="javascript:" id="btnOutrosPF"> <i class="ti-plus pr-2"></i> Adicionar mais arquivos</a>
                  <div></div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="cartao">
              <div class="row col-12 mx-auto">
                <div class="col-12 px-0 px-lg-4">
                  <div class="form-group mb-0">
                    <label class="col-form-label">Cartão de assinatura <span class="text-danger">*</span></label>
                    <div class="row">
                      <div class="row col-12 justify-content-center mx-auto mb-2">
                        <input type="text" class="form-control col-10 px-3 h-100" name="nomeCartao" onkeyup="this.value = this.value.toUpperCase();" style="border-top-left-radius: 10px !important; border-bottom-left-radius: 10px !important;" placeholder="Nome do arquivo" value="CARTAO DE ASSINATURA">
                        <label for="fupload15" class="btn btn-default col-2 px-0 border-0" title="Selecione o arquivo" style="border-radius: 0px !important; border-top-right-radius: 10px !important; border-bottom-right-radius: 10px !important;"><i class="mdi mdi-file"></i></label>
                        <input type="file" name="cartaoAssinatura" id="fupload15" class="position-absolute offset-10 col-1 px-0 mt-3" style="opacity: 0" accept="image/*" onchange="cartao(this, 'PF'); ">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-10 px-0 mt-5 pt-5 justify-content-center imagePF w-100">
                  <img id="PreviewImagePF" src="">
                  <input type="hidden" id="xPF" name="x" />
                  <input type="hidden" id="yPF" name="y" />
                  <input type="hidden" id="wPF" name="w" />
                  <input type="hidden" id="hPF" name="h" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="row col-12 justify-content-center mx-auto">
          <button class="btn btn-danger btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
           <button class="btn btn-success btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center">
              <i class="mdi mdi-check pr-2"></i> 
              <span>Salvar</span>
            </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
