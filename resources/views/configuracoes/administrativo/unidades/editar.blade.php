<!-- Modal -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Editar unidade</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formEditar" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" class="identificador">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-7">
                  <div class="form-group">
                    <label class="col-form-label">Instituição <span class="text-danger">*</span></label>
                    <div class="input-field">
                      <select class="form-control form-control-line usr_id_instituicao" name="usr_id_instituicao" required>
                        <option value="">Selecione a instituição responsável</option>
                        @foreach($instituicoes as $instituicao)
                        <option value="{{$instituicao->id}}">{{$instituicao->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-10">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="form-control form-control-line nome" onkeyup="this.value = this.value.toUpperCase();" name="nome" required/>
                    </div>
                  </div>
                </div>
                <div class="col-5">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Referência <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="form-control form-control-line referencia " onkeyup="this.value = this.value.toUpperCase();" name="referencia" required/>
                    </div>
                  </div>
                </div>
                <div class="col-12 p-0">
                  <div class="col-3">
                    <div class="form-group">
                      <label class="col-form-label mb-2">Status <span class="text-danger">*</span></label>
                      <div class="switchery-demo">
                        <input type="checkbox" class="status js-switch" name="status" data-color="#99d683" data-secondary-color="#f96262" checked>
                      </div>
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