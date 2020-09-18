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
              <div class="col-12 row">
                <div class="col-3">
                  <div class="form-group">
                    <label class="col-form-label mb-2">Status <span class="text-danger">*</span></label>
                    <div class="switchery-demo">
                      <input type="checkbox" class="status js-switch" data-color="#99d683" data-secondary-color="#f96262" disabled>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-10">
                <div class="form-group">
                  <label class="col-form-label pb-0">Nome</label>
                  <div class="">
                    <input class="nome form-control form-control-line" disabled/>
                  </div>
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <label class="col-form-label pb-0">Tempo de vida</label>
                  <div class="input-group">
                    <input class="form-control form-control-line tempo" disabled/>
                    <span class="input-group-addon bg-white border-right-0 border-top-0"><i class="mdi mdi-clock"></i></span>
                  </div>
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <label class="col-form-label pb-0">Cor de etiqueta</label>
                  <input type="text" class="color form-control form-control-line colorpicker" name="color" disabled/>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <div class="checkbox checkbox-custom m-0">
                    <input id="checkbox1" type="checkbox" name="open" class="open">
                    <label for="checkbox1"> Abertura dos chamados </label>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <div class="checkbox checkbox-custom m-0">
                    <input id="checkbox2" type="checkbox" name="finish" class="finish">
                    <label for="checkbox2"> Fechamento dos chamados </label>
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
