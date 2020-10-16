<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes da garantia</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-10">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Contrato</label>
                    <select class="form-control form-control-line contrato" name="contrato" disabled>
                      <option value=""> Selecione o contrato</option>
                      @foreach($contratos as $contrato)
                        <option value="{{$contrato->id}}">{{$contrato->num_contrato}} - {{$contrato->RelationAssociados->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div>
                    <label class="font-weight-bold">Garantia</label>
                  </div>
                  <div class="adicionarGarantia"></div>
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
          </div>
        </div>
    </div>
  </div>
</div>
<!-- Modal -->
