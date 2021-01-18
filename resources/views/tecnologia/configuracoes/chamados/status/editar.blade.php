<!-- Modal -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Editar o status</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Altere as informações necessárias.</p>
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
                <div class="col-12 row">
                  <div class="col-lg-3 col-12">
                    <div class="form-group">
                      <label class="col-form-label mb-2">Status <span class="text-danger">*</span></label>
                      <div class="switchery-demo">
                        <input type="checkbox" class="status js-switch" name="status" data-color="#99d683" data-secondary-color="#f96262" checked>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-10 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="nome form-control form-control-line" name="nome" placeholder="Em aberto" required/>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Tempo de vida <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input class="form-control form-control-line tempo" name="tempo" placeholder="1:00" required/>
                      <span class="input-group-addon bg-white border-right-0 border-top-0"><i class="mdi mdi-clock"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Cor de etiqueta <span class="text-danger">*</span></label>
                    <input type="text" class="color form-control form-control-line colorpicker" name="color" required/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <div class="checkbox checkbox-custom m-0">
                      <input id="checkbox5" type="checkbox" name="open" class="open">
                      <label for="checkbox5"> Abertura dos chamados </label>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <div class="checkbox checkbox-custom m-0">
                      <input id="checkbox5" type="checkbox" name="finish" class="finish">
                      <label for="checkbox5"> Fechamento dos chamados </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row col-12 justify-content-center">
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
