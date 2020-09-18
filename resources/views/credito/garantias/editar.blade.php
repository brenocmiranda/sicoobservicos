<!-- Modal -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header d-block pb-0">
        <div class="col-lg-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Editar função</h5>
        </div>
        <div class="col-lg-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <div class="modal-body">
        <form class="form-sample" id="formEditar" enctype="multipart/form-data" autocomplete="off">
          @csrf
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-10">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="nome form-control" name="nome" required/>
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label class="col-form-label">Status <span class="text-danger">*</span></label>
                     <div class="">
                     <input type="checkbox" name="status" class="py-0 form-control status" data-toggle="toggle" data-on="Ativo" data-off="Desativado"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer pb-2">
            <div class="col-lg-12 text-center">
              <button class="btn btn-outline-danger col-lg-3 mx-1"  data-dismiss="modal" aria-label="Close">
                <i class="mdi mdi-close"></i> Cancelar</button>
              <button type="submit" class="btn btn-outline-success col-lg-3 mx-1">
                <i class="mdi mdi-check"></i> Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
