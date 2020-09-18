<!-- Modal -->
<div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content text-center">
      <div class="modal-header d-block pb-0">
        <div class="col-lg-12">
          <h5 class="modal-title">Alteração de status</h5>
        </div>
        <div class="col-lg-12 mb-0">
          <p>Tem certeza que deseja alterar o status?</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <div class="modal-body">
        <form class="form-sample" id="formAlterar" enctype="multipart/form-data" autocomplete="off">
          @csrf
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-5 mx-auto">
                  <div class="form-group">
                    <label class="col-form-label"><b>Status </b><span class="text-danger">*</span></label>
                    <div class="">
                     <input type="checkbox" name="status" class="status py-0 form-control status" data-toggle="toggle" data-on="Ativo" data-off="Desativado"/>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="modal-footer pb-2">
            <div class="col-lg-12 text-center">
              <button class="btn btn-outline-danger col-lg-5 mx-1"  data-dismiss="modal" aria-label="Close">
                <i class="mdi mdi-close"></i> Cancelar</button>
              <button type="submit" class="btn btn-outline-success col-lg-5 mx-1">
                <i class="mdi mdi-check"></i> Salvar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- Modal -->
