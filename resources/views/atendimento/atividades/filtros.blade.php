<!-- Modal -->
<div class="modal fade" id="modal-filtros" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Filtros das atividades</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formFiltros" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="col-form-label pb-0">Colaborador </label>
                        <select class="form-control form-control-line" name="colaborador" required>
                            <option>Selecione</option>
                            @foreach($colaboradores as $colaborador)
                            <option value="{{$colaborador->id}}">{{$colaborador->RelationAssociado->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Tipo <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line tipo" name="tipo" required>
                      <option value="">Selecione</option>
                      <option value="dificuldades">Dificuldades</option>
                      <option value="liberações">Liberações</option>
                      <option value="propostas">Propostas</option>
                      <option value="simulação">Simulação</option>
                      <option value="outros">Outros</option>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Contato <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line contato" name="contato" required>
                      <option value="">Selecione</option>
                      <option value="telefone">Por telefone</option>
                      <option value="atendimento">Por atendimento</option>
                      <option value="whatsapp">Por whatsapp</option>
                      <option value="outros">Outros</option>
                    </select>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                      <label class="col-form-label pb-0">Data inicial <span class="text-danger">*</span></label>
                      <input type="date" class="form-control form-control-line" name="data_inicial" required/>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="col-form-label pb-0">Data final <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-line" name="data_final"  required/>
                    </div>
                </div>   
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row col-12 justify-content-center mx-auto">
            <button class="btn btn-danger btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
            <button type="submit" class="btn btn-success btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center">
              <i class="mdi mdi-check pr-2"></i> 
              <span>Aplicar</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>