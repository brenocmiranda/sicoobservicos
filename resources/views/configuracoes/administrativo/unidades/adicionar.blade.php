<!-- Modal -->
<div class="modal fade" id="modal-adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block border-bottom-0 pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Adicionar unidade</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
        <ul class="nav customtab col-12" role="tablist">
          <li role="presentation" class="active">
            <a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab" aria-expanded="true">
              <span class="visible-xs"><i class="ti-home"></i></span>
              <span class="hidden-xs"> Informações</span>
            </a>
          </li>
          <li role="presentation" class="">
            <a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab" aria-expanded="true">
              <span class="visible-xs"><i class="ti-home"></i></span>
              <span class="hidden-xs"> Endereço</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formAdicionar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="tab-content mt-4" id="myTabContent">
                <!-- TAB1 -->
                <div class="tab-pane active in" id="informacoes" role="tabpanel" aria-labelledby="informacoes">
                  <div class="row">
                    <div class="col-lg-7 col-sm-12 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Instituição <span class="text-danger">*</span></label>
                        <div class="input-field">
                          <select class="form-control form-control-line" name="usr_id_instituicao" required>
                            <option value="">Selecione a instituição responsável</option>
                            @foreach($instituicoes as $instituicao)
                            <option value="{{$instituicao->id}}">{{$instituicao->nome}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-8 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                        <div class="">
                          <input class="form-control form-control-line text-uppercase" placeholder="PA NOVO" name="nome" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Referência <span class="text-danger">*</span></label>
                        <div class="">
                          <input class="form-control form-control-line text-uppercase" placeholder="4133-00" name="referencia" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">CNPJ <span class="text-danger">*</span></label>
                        <div class="">
                          <input class="cnpj form-control form-control-line" name="cnpj" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Telefone 1</label>
                        <div class="">
                          <input class="telefone form-control form-control-line" placeholder="(38) 3741-6250" name="telefone"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Telefone 2</label>
                        <div class="">
                          <input class="telefone1 form-control form-control-line" placeholder="(38) 3741-6250" name="telefone1"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 p-0">
                      <div class="col-lg-3 col-12">
                        <div class="form-group">
                          <label class="col-form-label mb-2">Status <span class="text-danger">*</span></label>
                          <div class="switchery-demo">
                            <input type="checkbox" class="js-switch" name="status" data-color="#99d683" data-secondary-color="#f96262" checked>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- TAB2 -->
                <div class="tab-pane" id="endereco" role="tabpanel" aria-labelledby="endereco">
                  <div class="row">
                    <div class="col-12 px-0 mx-auto row">
                      <div class="col-lg-4 col-12">
                        <div class="form-group">
                          <label class="col-form-label pb-0">CEP</label>
                          <div class="">
                            <input class="form-control form-control-line text-uppercase" name="cep"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4 col-12 my-auto px-0">
                        <label class="country"></label>
                      </div>
                    </div>
                    <div class="col-lg-8 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Rua</label>
                        <div class="">
                          <input class="rua form-control form-control-line text-uppercase" name="rua"/>
                          <input type="hidden" name="cidade" class="cidade">
                          <input type="hidden" name="estado" class="estado">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Número</label>
                        <div class="">
                          <input type="number" class="numero form-control form-control-line" name="numero"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-5 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Bairro</label>
                        <div class="">
                          <input class="bairro form-control form-control-line text-uppercase" name="bairro"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-7 col-12">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Complemento</label>
                        <div class="">
                          <input class="complemento form-control form-control-line text-capitalize" name="complemento"/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row col-12 justify-content-center mx-auto">
            <button class="btn btn-danger btn-outline col-lg-3 col-5 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
            <button type="submit" class="btn btn-success btn-outline col-lg-3 col-5 mx-1 d-flex align-items-center justify-content-center">
              <i class="mdi mdi-check pr-2"></i> 
              <span>Salvar</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
