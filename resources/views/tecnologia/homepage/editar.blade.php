<!-- Modal -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Editar atalho</h5>
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
                <div class="col-8 p-0">
                  <div class="col-10">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Título <span class="text-danger">*</span></label>
                      <input class="titulo form-control form-control-line" name="titulo" placeholder="Sicoob Serviços" onkeyup="this.value = this.value.toUpperCase();" required/>
                    </div>
                  </div>
                  <div class="col-11">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Subtítulo</label>
                      <input class="subtitulo form-control form-control-line" name="subtitulo" placeholder="Página de login" onkeyup="this.value = this.value.toUpperCase();"/>
                    </div>
                  </div>
                  <div class="col-11">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Endereço <span class="text-danger">*</span></label>
                      <input class="endereco form-control form-control-line" name="endereco" placeholder="Página de login" required/>
                    </div>
                  </div>
                </div>
                <div class="col-4 p-0">
                  <div class="form-group text-center">
                    <label class="col-form-label pb-0">Ícone <span class="text-danger">*</span></label>
                    <div>
                      <img src="{{ asset('public/img/image.png').'?'.rand() }}" class="border mt-4 rounded-circle" id="PreviewImageEdit" width="130" height="130">
                      <div>
                        <div class="btn btn-secondary btn-outline btn-image px-3 rounded-circle">
                          <input type="file" class="px-0 position-absolute m-auto" accept=".png, .jpg, .jpeg .ico" name="upload_img" id="upload_img_edit" onchange="image1(this);">
                          <div class="row h-100 align-items-center align-self-center justify-content-center my-auto">
                            <i class="mdi mdi-24px mdi-image-filter mdi-light" style="display: none"></i>
                          </div>
                        </div>
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