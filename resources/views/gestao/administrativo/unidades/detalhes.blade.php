<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes da unidade</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Abaixo estão listadas todas as informações da unidade.</p>
        </div>
      </div>
      <div class="modal-body">
        <div class="col-12 grid-margin mb-0">
          <div class="card-body py-0">
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  <label class="col-form-label">Instituição</label>
                  <div class="input-field">
                    <select class="form-control form-control-line usr_id_instituicao" name="usr_id_instituicao" disabled>
                      <option value="">Selecione a instituição responsável</option>
                      @foreach($instituicoes as $instituicao)
                      <option value="{{$instituicao->id}}">{{$instituicao->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="form-group">
                  <label class="col-form-label pb-0">Nome</label>
                  <div class="">
                    <input class="nome form-control form-control-line" disabled/>
                  </div>
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  <label class="col-form-label pb-0">Referência</label>
                  <div class="">
                    <input class="referencia form-control form-control-line" disabled/>
                  </div>
                </div>
              </div>
              <div class="col-12 p-0">
                <div class="col-3">
                  <div class="form-group">
                    <label class="col-form-label mb-2">Status</label>
                    <div class="switchery-demo">
                      <input type="checkbox" class="status js-switch" data-color="#99d683" data-secondary-color="#f96262" checked disabled>
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
