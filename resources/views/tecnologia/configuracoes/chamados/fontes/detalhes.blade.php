<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes da fonte</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Abaixo estão listadas todas as informações da fonte.</p>
        </div>
      </div>
      <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-lg-7 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Ambientes</label>
                    <select class="form-control form-control-line gti_id_ambientes" disabled>
                      <option disabled>Selecione</option>
                      @foreach($ambientes as $ambiente)
                        <option value="{{$ambiente->id}}">{{$ambiente->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-8 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome</label>
                    <input class="nome form-control form-control-line text-uppercase" disabled/>
                  </div>
                </div>
                <div class="col-lg-10 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Descrição</label>
                    <textarea class="descricao form-control form-control-line" disabled></textarea>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="form-group">
                    <label class="col-form-label mb-2">Status</label>
                      <div class="switchery-demo">
                        <input type="checkbox" class="status js-switch" name="status" data-color="#99d683" data-secondary-color="#f96262" disabled>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <div class="row col-12 justify-content-center">
           <button class="btn btn-danger btn-outline col-lg-3 col-6 mx-1 d-flex align-items-center justify-content-center"  data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
