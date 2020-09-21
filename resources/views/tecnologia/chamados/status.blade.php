<!-- Modal -->
<div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Atualizar status do chamado</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample h-100" id="formAlterar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="id" class="idChamado" value>
        <div class="modal-body h-75">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
             
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label class="col-form-label pb-0">Novo status <span class="text-danger">*</span></label>
                  <select class="form-control form-control-line" name="status" required>
                    <option disabled>Selecione</option>
                    @foreach($statusAtivos->where('open', 0) as $status)
                    <option value="{{$status->id}}">{{$status->nome}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label mb-2">Descrição <span class="text-danger">*</span></label>
                  <textarea class="form-control form-control-line" name="descricao" placeholder="Escreva aqui um descrição para o colaborador..." rows="2"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-form-label col-12">Últimas atualizações: </label>
              <ul class="px-2" id="statusNews">
                @foreach($chamado->RelationStatus as $status)
                <li class="m-3 border-bottom pb-3" id="status{{$status->pivot->id}}">
                  <div class="badge" style="background: {{$status->color}}">{{$status->nome}}</div>
                  <label class="col-12 pt-3 px-0">
                    {{$status->pivot->descricao}}
                  </label>
                  <div class="col-12 row">
                    <small class="p-0 font-weight-bold">
                      {{$status->pivot->created_at->format('d/m/Y H:i')}}
                    </small>
                  </div>
                  @if($chamado->RelationStatus->last()->id != $status->id)
                  @endif
                </li>
                @endforeach
              </ul>
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
