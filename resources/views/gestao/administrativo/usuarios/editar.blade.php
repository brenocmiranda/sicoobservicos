<!-- Modal -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header d-block pb-0">
        <div class="col-lg-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Editar informações do usuário</h5>
        </div>
        <div class="col-lg-12 mb-0">
          <p>Altere as informações do setor selecionado.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" id="formEditar" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="status" class="status" value="">
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-8">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Associado <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line cli_id_associado" name="cli_id_associado" disabled>
                      <option value="">Selecione</option>
                        @foreach($associadosTodos as $associado)
                        <option value="{{$associado->id}}">{{$associado->nome}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Login <span class="text-danger">*</span></label>
                    <div class="">
                      <input type="text" class="login form-control form-control-line" name="login" required/>
                    </div>
                  </div>
                </div>
                <div class="col-8">
                  <div class="form-group">
                    <label class="col-form-label pb-0">E-mail <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="email form-control form-control-line" placeholder="administrativo@sicoobsertaominas.com.br" required>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Telefone <span class="text-danger">*</span></label>
                    <input type="text" name="telefone" class="telefone form-control form-control-line" placeholder="(38) 91234-5678" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Função <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line usr_id_funcao" name="usr_id_funcao" required>
                      <option value="">Selecione</option>
                      @foreach($funcoes as $funcao)
                      <option value="{{$funcao->id}}">{{$funcao->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Setor <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line usr_id_setor" name="usr_id_setor" required>
                      <option value="">Selecione</option>
                      @foreach($setores as $setor)
                      <option value="{{$setor->id}}">{{$setor->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Instituição <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line usr_id_instituicao" name="usr_id_instituicao" required>
                      <option value="">Selecione</option>
                      @foreach($instituicoes as $instituicao)
                      <option value="{{$instituicao->id}}">{{$instituicao->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Unidade <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line usr_id_unidade" name="usr_id_unidade" required>
                      <option value="">Selecione</option>
                      @foreach($unidades as $unidade)
                      <option value="{{$unidade->id}}">{{$unidade->nome}}</option>
                      @endforeach
                    </select>
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
</div>
<!-- Modal -->
