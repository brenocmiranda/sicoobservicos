<!-- Modal -->
<div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Nova mensagem</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formAlterar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="id" class="idChamado" value>
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label mb-2">Descrição <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-line" name="descricao" placeholder="Escreva aqui um descrição para o colaborador..." rows="2" required  onkeyup="this.value = this.value.toUpperCase();"></textarea>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label col-12 row mb-0">Selecione os anexos</label>
                    <small>Todos formatos são aceitos aceitos: <b>.png</b>, <b>.jpg</b>, <b>.xls</b>, <b>.pdf</b>, <b>.doc</b>, <b>.docx</b></small>
                    <div class="row col-12 mt-3 preview mx-0 p-0">
                      <div class="border mx-2 rounded col-lg-2 col-4 row p-0 mb-4" style="height: 7em;">
                        <i class="mdi mdi-plus mdi-36px m-auto"></i>
                        <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" id="addArquivo" title="Selecione os anexos do tópico" multiple>
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
            <button class="btn btn-danger btn-outline col-lg-3 col-5 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
            <button type="submit" class="btn btn-success btn-outline col-lg-3 col-5 mx-1 d-flex align-items-center justify-content-center">
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
