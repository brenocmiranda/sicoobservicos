<!-- Modal -->
<div class="modal fade" id="modal-filtros" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Filtros das atividades</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form class="form-sample" method="POST" action="#" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                @if(Auth::user()->RelationFuncao->gerenciar_atendimento == 1)
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Colaborador </label>
                    <select class="form-control form-control-line" name="colaborador">
                        <option value="">Selecione</option>
                        @foreach($usuarios as $colaborador)
                        <option value="{{$colaborador->id}}" {{(@$filtros['colaborador'] == $colaborador->id ? 'selected' : '')}}>{{$colaborador->RelationAssociado->nome}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                @endif
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">PA </label>
                    <select class="form-control form-control-line" name="unidade">
                        <option value="">Selecione</option>
                        @foreach($unidades as $unidade)
                        <option value="{{$unidade->id}}" {{(@$filtros['unidade'] == $unidade->id ? 'selected' : '')}}>{{$unidade->nome}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Sistema operacional</label>
                    <select class="form-control form-control-line" name="sistema_operacional">
                      <option value="">Selecione</option>
                      <option value="Windows 10">Windows 10</option>
                      <option value="Windows 8.1">Windows 8.1</option>
                      <option value="Linux Ubuntu">Linux Ubuntu</option>
                      <option value="Linux Mint">Linux Mint</option>
                      <option value="Windows Server 2016">Windows Server 2016</option>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Licença</label>
                    <select class="form-control form-control-line" name="tipo_licenca">
                      <option value="">Selecione</option>
                      <option value="OEM">OEM</option>
                      <option value="GPL">GPL</option>
                      <option value="Por volume">Por volume</option>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Antivírus</label>
                    <select class="form-control form-control-line" name="antivirus">
                      <option value="">Selecione</option>
                      <option value="Kaspersky">Kaspersky</option>
                      <option value="Windows Defender">Windows Defender</option>
                    </select>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Data inicial cadastro </label>
                    <input type="date" class="form-control form-control-line" name="data_inicial" value="{{(isset($filtros['data_inicial']) ? date('Y-m-d', strtotime(@$filtros['data_inicial'])) : '')}}" />
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Data final cadastro </label>
                    <input type="date" class="form-control form-control-line" name="data_final" value="{{(isset($filtros['data_final']) ? date('Y-m-d', strtotime(@$filtros['data_final'])) : '')}}"/>
                  </div>
                </div>   
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row col-12 justify-content-center mx-auto">
            <button class="btn btn-danger btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Limpar</span>
            </button>
            <button type="submit" class="btn btn-success btn-outline col-5 col-lg-3 mx-1 d-flex align-items-center justify-content-center">
              <i class="mdi mdi-check pr-2"></i> 
              <span>Aplicar</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>