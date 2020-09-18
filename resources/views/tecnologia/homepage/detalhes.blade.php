<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes do atalho</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Abaixo estão listadas todas as informações do atalho.</p>
        </div>
      </div>
      <div class="modal-body">
        <div class="col-12 grid-margin mb-0">
          <div class="card-body py-0">
            <div class="row">
              <div class="col-8 p-0">
                <div class="col-10">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Título</label>
                    <input class="titulo form-control form-control-line" onkeyup="this.value = this.value.toUpperCase();" disabled/>
                  </div>
                </div>
                <div class="col-11">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Subtítulo</label>
                    <input class="subtitulo form-control form-control-line" onkeyup="this.value = this.value.toUpperCase();" disabled/>
                  </div>
                </div>
                <div class="col-11">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Endereço</label>
                    <input class="endereco form-control form-control-line" disabled/>
                  </div>
                </div>
              </div>
              <div class="col-4 p-0">
                <div class="form-group text-center">
                  <label class="col-form-label pb-0">Ícone</label>
                  <div>
                    <img src="{{ asset('public/img/image.png').'?'.rand() }}" class="border mt-4 rounded-circle" id="PreviewImage" width="130" height="130">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row col-12 justify-content-center">
          <button class="btn btn-danger btn-outline col-4 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
            <i class="mdi mdi-close pr-2"></i> 
            <span>Cancelar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
