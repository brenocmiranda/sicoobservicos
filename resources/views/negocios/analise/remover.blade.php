<!-- Modal -->
<div class="modal fade" id="modal-remover" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Cancelamento de análise</h5>
        </div>
        <div class="col-12 mb-0">
          <p> Preencha o motivo de remoção da análise do associado <span class="nome font-weight-bold"></span>.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formRemover" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" id="cli_id_associado" name="cli_id_associado" value="">
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                 <div class="col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Motivo do cancelamento?</label>
                      <textarea class="observacoes form-control form-control-line" name="observacoes" onkeyup="this.value = this.value.toUpperCase();" rows="4" placeholder="Descreva o motivo do cancelamento da análise..." required></textarea>
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