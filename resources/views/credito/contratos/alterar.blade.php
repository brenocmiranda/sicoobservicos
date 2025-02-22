<!-- Modal -->
<div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content text-center">
      <div class="modal-header d-block pb-0">
        <div class="col-lg-12">
          <h5 class="modal-title">Alteração de status</h5>
        </div>
        <div class="col-lg-12 mb-0">
          <p>Tem certeza que deseja alterar o status?</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <div class="modal-body">
        <form class="form-sample" id="formAlterar" enctype="multipart/form-data" autocomplete="off">
          @csrf
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-8 mx-auto">
                  <div class="form-group">
                    <label class="col-form-label"><b>Status </b><span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" name="status" required>
                      <option disabled> Selecione o status</option>
                      <option value="vigente">Vigente</option>
                      <option value="quitado">Quitado</option>
                      <option value="prejuizo">Prejuízo</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="row col-12 justify-content-center">
                <button class="btn btn-danger btn-outline col-5 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
                  <i class="mdi mdi-close pr-2"></i> 
                  <span>Cancelar</span>
                </button>
                <button type="submit" class="btn btn-success btn-outline col-5 mx-1 d-flex align-items-center justify-content-center">
                  <i class="mdi mdi-check pr-2"></i> 
                  <span>Salvar</span>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
