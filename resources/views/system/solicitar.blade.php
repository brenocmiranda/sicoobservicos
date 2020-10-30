<!-- Modal -->
<div class="modal fade" id="modal-solicitar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Solicitar recuperação de senha</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha os campos abaixo para solicitar da redefinição de senha.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formSolicitar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Usuário <span class="text-danger">*</span></label>
                    <input class="form-control form-control-line login" name="login" placeholder="administrador4133_00" required/>
                  </div>
                </div>
                <div class="col-12">
                  <small>* Após solicitar o envio do e-mail do recuperação, verifique a caixa de entrada do seu e-mail ou lixo eletrônico (SPAM).</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row col-12 justify-content-center">
            <button type="submit" class="btn btn-success btn-outline col-3 mx-1 d-flex align-items-center justify-content-center">
              <i class="mdi mdi-send pr-2"></i> 
              <span>Enviar</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
