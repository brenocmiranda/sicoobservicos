<!-- Modal -->
<div class="modal fade" id="modal-adicionar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Adicionar fonte</h5>
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
                <div class="col-lg-7 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Ambientes</label>
                    <select class="form-control form-control-line mb-2 gti_id_ambientes" name="gti_id_ambientes">
                      <option disabled>Selecione</option>
                      @foreach($ambientes as $ambiente)
                        <option value="{{$ambiente->id}}">{{$ambiente->nome}}</option>
                      @endforeach
                    </select>
                    <a href="javascript:void()" data-toggle="modal" data-target="#modal-ambiente" class="mt-2"><small><i class="mdi mdi-plus"></i> Novo ambiente</small></a>
                  </div>
                </div>
                <div class="col-lg-8 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <input class="form-control form-control-line text-uppercase" name="nome" placeholder="Módulos de Crédito" required/>
                  </div>
                </div>
                <div class="col-lg-10 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Descrição</label>
                    <textarea class="form-control form-control-line text-uppercase" name="descricao"></textarea>
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
