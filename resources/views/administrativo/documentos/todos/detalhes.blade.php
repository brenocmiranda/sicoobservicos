<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes do documento</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Abaixo estão listadas todas as informações da função.</p>
        </div>
      </div>
      <div class="modal-body">
        <div class="col-12 grid-margin mb-0"> 
          <div class="card-body py-0">
           <div class="row">
            <div class="col-8">
              <div class="form-group">
                <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                <input class="nome form-control form-control-line" name="nome" onkeyup="this.value = this.value.toUpperCase();" disabled/>
              </div>
            </div>
            <div class="col-10">
              <div class="form-group">
                <label class="col-form-label pb-0">Descrição</label>
                <textarea class="descricao form-control form-control-line" name="descricao" onkeyup="this.value = this.value.toUpperCase();" disabled></textarea>
              </div>
            </div>
            <div class="col-10">
              <div class="form-group">
                <label class="col-form-label pb-0">Arquivo <span class="text-danger">*</span></label>
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                  <div class="form-control form-control-line" data-trigger="fileinput"> 
                    <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                    <span class="fileinput-filename"></span>
                  </div> 
                  <span class="input-group-addon btn btn-default btn-file"> 
                    <span class="fileinput-new">Selecione seu arquivo</span> 
                    <span class="fileinput-exists">Alterar</span>
                    <input type="file" name="id_arquivo" disabled> 
                  </span> 
                  <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> 
                </div>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label class="col-form-label mb-2">Status <span class="text-danger">*</span></label>
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