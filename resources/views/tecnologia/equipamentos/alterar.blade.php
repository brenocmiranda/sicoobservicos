<!-- Modal -->
<div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Alterar responsável</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formAlterar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="id" class="identificador">
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-lg-12 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Novo usuário </label>
                    <select class="form-control form-control-line" name="usuario" required>
                      <option value="">Selecione</option>
                      @foreach($usuarios as $usuario)
                      <option value="{{$usuario->id}}">{{$usuario->RelationAssociado->nome}}</option>
                      @endforeach
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
              <span>Finalizar</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
