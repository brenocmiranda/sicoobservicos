<!-- Modal -->
<div class="modal fade" id="modal-desaprovar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Cancelar solicitação</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Tem certeza que deseja cancelar a solicitação?</p>
        </div> 
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formDesaprovar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="id" id="identificador">
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
             <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label pb-0">Qual o motivo?</label>
                  <textarea class="observacao form-control form-control-line" name="observacao" onkeyup="this.value = this.value.toUpperCase();" rows="4" placeholder="Descreve o motivo do cancelamento da solicitação..." required></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row col-12 justify-content-center">
          <button class="btn btn-primary btn-outline col-3 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
            <i class="mdi mdi-arrow-left pr-2"></i> 
            <span>Cancelar</span>
          </button>
          <button type="submit" class="btn btn-danger btn-outline col-3 mx-1 d-flex align-items-center justify-content-center">
            <i class="mdi mdi-close pr-2"></i> 
            <span>Desaprovar</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
<!-- Modal -->
