<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="z-index: 1041">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes do equipamento</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Abaixo estão listadas todas as informações do equipamento.</p>
        </div>
      </div>
      <div class="modal-body">
        <div class="col-12 grid-margin mb-0">
          <div class="card-body py-0">
            <div class="row">
              <div class="col-lg-8 col-10">
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <label class="col-form-label">Equipamento</label>
                      <div class="">
                        <label class="equipamento"></label>
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <label class="col-form-label">Marca</label>
                      <div class="">
                        <label class="marca"></label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <label class="col-form-label">Modelo</label>
                      <div class="">
                        <label class="modelo"></label>
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <label class="col-form-label">Nº série</label>
                      <div class="">
                        <label class="serialNumber"></label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <label class="col-form-label">Nº patrimônio</label>
                      <div class="">
                        <label class="n_patrimonio"></label>
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <label class="col-form-label">Service TAG</label>
                      <div class="">
                        <label class="serviceTag"></label>
                      </div>
                    </div>
                  </div>
                  <label class="col-form-label">Localização</label>
                  <div class="">
                    <label class="id_setor"></label>
                  </div>
                  <label class="col-form-label">Usuário</label>
                  <div class="">
                    <label class="usuario"></label>
                  </div>
                  <label class="col-form-label">Descrição</label>
                  <div class="">
                    <label class="descricao"></label>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-2 mt-5">
                <div class="form-group">
                  <div class="zoom-gallery border mx-auto rounded col-7 row p-0" style="height: 9em;">
                    <a href="#" id="ImagemPrincipalUrl">
                      <img class="p-3" id="ImagemPrincipal" src="{{ asset('public/img/image.png').'?'.rand() }}" width="120" style="height: 9em;">
                    </a>
                  </div>
                </div>
                <div class="form-group text-center">
                  <small class="font-weight-bold">Mais imagens do produto</small>
                  <div class="row mt-3 preview zoom-gallery">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row col-12 justify-content-center">
          <button class="btn btn-danger btn-outline col-lg-4 col-6 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
            <i class="mdi mdi-close pr-2"></i> 
            <span>Cancelar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
