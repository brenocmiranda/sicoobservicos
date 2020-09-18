<!-- Modal -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header d-block pb-0">
        <div class="col-lg-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Editar informações do setor</h5>
        </div>
        <div class="col-lg-12 mb-0">
          <p>Altere as informações do setor selecionado.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formEditar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-10">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="nome form-control form-control-line" name="nome" required/>
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label class="col-form-label">Status <span class="text-danger">*</span></label>
                    <div class="switchery-demo">
                      <input type="checkbox" class="status js-switch" name="status" data-color="#99d683" data-secondary-color="#f96262" checked>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row col-12 justify-content-center">
            <button class="btn btn-danger btn-outline col-3 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
            <button type="submit" class="btn btn-success btn-outline col-3 mx-1 d-flex align-items-center justify-content-center">
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
