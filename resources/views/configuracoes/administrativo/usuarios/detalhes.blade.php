<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header d-block pb-0">
        <div class="col-lg-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes do usuário</h5>
        </div>
        <div class="col-lg-12 mb-0">
          <p>Estão listadas abaixo as informações do usuário selecionado.</p>
        </div>
      </div>
      <div class="carregamento"></div>
      <div class="modal-body">
        <div class="col-12 grid-margin mb-0">
          <div class="card-body py-0">
            <div class="row">
              <div class="col-lg-8 col-12">
                <div class="form-group">
                  <label class="col-form-label pb-0">Associado</label>
                  <select class="form-control form-control-line cli_id_associado" disabled>
                    <option value="">Selecione</option>
                    @foreach($associadosTodos as $associado)
                    <option value="{{$associado->id}}">{{$associado->nome}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label class="col-form-label pb-0">Login</label>
                  <input type="text" class="login form-control form-control-line" name="login" disabled/>
                </div>
              </div>
              <div class="col-lg-8 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">E-mail</label>
                    <input type="email" name="email" class="email form-control form-control-line" disabled>
                  </div>
                </div>
                <div class="col-lg-4 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Telefone</label>
                    <input type="text" name="telefone" class="telefone form-control form-control-line" disabled>
                  </div>
                </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="col-form-label pb-0">Função</label>
                  <select class="form-control form-control-line usr_id_funcao" disabled>
                    <option value="">Selecione</option>
                    @foreach($funcoes as $funcao)
                    <option value="{{$funcao->id}}">{{$funcao->nome}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="col-form-label pb-0">Setor</label>
                  <select class="form-control form-control-line usr_id_setor" disabled>
                    <option value="">Selecione</option>
                    @foreach($setores as $setor)
                    <option value="{{$setor->id}}">{{$setor->nome}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="col-form-label pb-0">Instituição</label>
                  <select class="form-control form-control-line usr_id_instituicao" disabled>
                    <option value="">Selecione</option>
                    @foreach($instituicoes as $instituicao)
                    <option value="{{$instituicao->id}}">{{$instituicao->nome}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="col-form-label pb-0">Unidade</label>
                  <select class="form-control form-control-line usr_id_unidade" disabled>
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
        <div class="row col-12 justify-content-center mx-auto">
          <button class="btn btn-danger btn-outline col-lg-3 col-6 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
            <i class="mdi mdi-close pr-2"></i> 
            <span>Cancelar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
