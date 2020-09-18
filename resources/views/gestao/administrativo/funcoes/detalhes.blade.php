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
                <div class="col-3">
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
                    <div class="col-3">
                      <label class="border-bottom pb-2 w-100">Crédito</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox21" type="checkbox" name="ver_credito">
                        <label for="checkbox21"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox22" type="checkbox" name="gerenciar_credito">
                        <label for="checkbox22"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <label class="border-bottom pb-2 w-100">Tecnologia</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox25" type="checkbox" name="ver_gti">
                        <label for="checkbox25"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox26" type="checkbox" name="gerenciar_gti">
                        <label for="checkbox26"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <label class="border-bottom pb-2 w-100">Configurações</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox27" type="checkbox" name="ver_configuracoes">
                        <label for="checkbox27"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox28" type="checkbox" name="gerenciar_configuracoes">
                        <label for="checkbox28"> Gerenciar </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <label class="border-bottom pb-2 w-100">Administrativo</label>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox27" type="checkbox" name="ver_administrativo">
                        <label for="checkbox27"> Visualizar </label>
                      </div>
                      <div class="checkbox checkbox-circle">
                        <input id="checkbox28" type="checkbox" name="gerenciar_administrativo">
                        <label for="checkbox28"> Gerenciar </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <div class="row col-12 justify-content-center">
           <button class="btn btn-danger btn-outline col-3 mx-1 d-flex align-items-center justify-content-center"  data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
