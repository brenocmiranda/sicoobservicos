<!-- Modal -->
<div class="modal fade" id="modal-adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Adicionar função</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formAdicionar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-10">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <input class="form-control form-control-line" name="nome" placeholder="Administrador" required/>
                  </div>
                </div>
                <div class="col-12 col-lg-3">
                  <div class="form-group">
                    <label class="col-form-label mb-2">Status <span class="text-danger">*</span></label>
                    <div class="switchery-demo">
                      <input type="checkbox" class="js-switch" name="status" data-color="#99d683" data-secondary-color="#f96262" checked>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <label class="col-form-label">Permissões de acesso</label>
                  <hr class="mt-1">
                  <div class="row mx-auto">
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Crédito</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox1" type="checkbox" name="ver_credito">
                        <label for="checkbox1"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox2" type="checkbox" name="gerenciar_credito">
                        <label for="checkbox2"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Tecnologia</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox5" type="checkbox" name="ver_gti">
                        <label for="checkbox5"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox6" type="checkbox" name="gerenciar_gti">
                        <label for="checkbox6"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Configurações</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox7" type="checkbox" name="ver_configuracoes">
                        <label for="checkbox7"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox8" type="checkbox" name="gerenciar_configuracoes">
                        <label for="checkbox8"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Administrativo</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox9" type="checkbox" name="ver_administrativo">
                        <label for="checkbox9"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox10" type="checkbox" name="gerenciar_administrativo">
                        <label for="checkbox10"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Cadastro</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox11" type="checkbox" name="ver_cadastro">
                        <label for="checkbox11"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox12" type="checkbox" name="gerenciar_cadastro">
                        <label for="checkbox12"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Produtos</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox13" type="checkbox" name="ver_produtos">
                        <label for="checkbox13"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox14" type="checkbox" name="gerenciar_produtos">
                        <label for="checkbox14"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Atendimento</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox15" type="checkbox" name="ver_atendimento">
                        <label for="checkbox15"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox16" type="checkbox" name="gerenciar_atendimento">
                        <label for="checkbox16"> Gerenciar </label>
                      </div>
                    </div>
                     <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Negócios</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox17" type="checkbox" name="ver_negocios">
                        <label for="checkbox17"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox18" type="checkbox" name="gerenciar_negocios">
                        <label for="checkbox18"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Suporte</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox19" type="checkbox" name="ver_suporte">
                        <label for="checkbox19"> Visualizar </label>
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
            <button class="btn btn-danger btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
            <button type="submit" class="btn btn-success btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center">
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
