<!-- Modal -->
<div class="modal fade" id="modal-adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Adicionar material</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formAdicionar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-lg-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Categoria <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" name="id_categoria" required>
                      <option>Selecione</option>
                      @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-8 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <input class="form-control form-control-line" name="nome" onkeyup="this.value = this.value.toUpperCase();" placeholder="Caneta azul" required/>
                  </div>
                </div>
                <div class="col-lg-10 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Descrição</label>
                    <textarea class="form-control form-control-line" name="descricao" onkeyup="this.value = this.value.toUpperCase();"></textarea>
                  </div>
                </div>
                <div class="row col-12">
                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Quantidade <span class="text-danger">*</span></label>
                      <input type="number" class="form-control form-control-line" name="quantidade" min="0" required/>
                    </div>
                  </div>
                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Quantidade mínima <span class="text-danger">*</span></label>
                      <input type="number" class="form-control form-control-line" min="0" name="quantidade_min" required/>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="form-group">
                    <label class="col-form-label mb-2">Status <span class="text-danger">*</span></label>
                    <div class="switchery-demo">
                      <input type="checkbox" class="js-switch" name="status" data-color="#99d683" data-secondary-color="#f96262" checked>
                    </div>
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
            <button type="submit" class="btn btn-success btn-outline col-lg-3 col-5 3 mx-1 d-flex align-items-center justify-content-center">
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
