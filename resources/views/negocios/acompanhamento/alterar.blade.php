<!-- Modal -->
<div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Alteração de estado</h5>
        </div>
        <div class="col-12 mb-0">
          <p> Preencha as informações necessárias e altere o status da análise.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formAlterar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" id="id_carteira" name="id_carteira" value="">
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-12">
                  <div class="form-group col-lg-4 col-12 px-0">
                    <label class="col-form-label pb-0">Status</label>
                    <select class="status form-control form-control-line" name="status" required>
                      <option value="">Selecione</option>
                      <option value="excecao">Não contatar</option>
                      <option value="aberto">Em aberto</option>
                      <option value="andamento">Em andamento</option>
                      <option value="finalizado">Finalizado</option>
                    </select>
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