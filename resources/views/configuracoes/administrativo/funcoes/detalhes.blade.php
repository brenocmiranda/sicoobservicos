<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes da função</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Abaixo estão listadas todas as informações da função.</p>
        </div>
      </div>
      <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-10">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome</label>
                    <input class="nome form-control form-control-line" disabled/>
                  </div>
                </div>
                <div class="col-12 col-lg-3">
                  <div class="form-group">
                    <label class="col-form-label mb-2">Status</label>
                      <div class="switchery-demo">
                        <input type="checkbox" class="status js-switch" data-color="#99d683" data-secondary-color="#f96262" disabled>
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
                        <input id="checkbox60" type="checkbox" name="ver_credito">
                        <label for="checkbox60"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox61" type="checkbox" name="gerenciar_credito">
                        <label for="checkbox61"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Tecnologia</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox62" type="checkbox" name="ver_gti">
                        <label for="checkbox62"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox63" type="checkbox" name="gerenciar_gti">
                        <label for="checkbox63"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Configurações</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox64" type="checkbox" name="ver_configuracoes">
                        <label for="checkbox64"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox65" type="checkbox" name="gerenciar_configuracoes">
                        <label for="checkbox65"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Administrativo</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox66" type="checkbox" name="ver_administrativo">
                        <label for="checkbox66"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox67" type="checkbox" name="gerenciar_administrativo">
                        <label for="checkbox67"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Cadastro</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox68" type="checkbox" name="ver_cadastro">
                        <label for="checkbox68"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox69" type="checkbox" name="gerenciar_cadastro">
                        <label for="checkbox69"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Produtos</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox70" type="checkbox" name="ver_produtos">
                        <label for="checkbox70"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox71" type="checkbox" name="gerenciar_produtos">
                        <label for="checkbox71"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Atendimento</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox72" type="checkbox" name="ver_atendimento">
                        <label for="checkbox72"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox73" type="checkbox" name="gerenciar_atendimento">
                        <label for="checkbox73"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Negócios</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox74" type="checkbox" name="ver_negocios">
                        <label for="checkbox74"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox75" type="checkbox" name="gerenciar_negocios">
                        <label for="checkbox75"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <label class="border-bottom py-2 w-100">Suporte</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox76" type="checkbox" name="ver_suporte">
                        <label for="checkbox76"> Visualizar </label>
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
           <button class="btn btn-danger btn-outline col-6 col-lg-3 mx-1 d-flex align-items-center justify-content-center"  data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
