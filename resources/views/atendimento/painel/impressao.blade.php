<!-- Modal -->
<div class="modal fade" id="modal-impressao" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Impressão do painel do associado</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Selecione quais informações deseja imprimir.</p>
        </div>
        <div id="err"></div>
      </div>
      <div class="carregamento"></div>
      <form id="formImpressao" method="POST" class="form-sample" target="_blank" action="{{route('relatorio.associado.atendimento', $associado->id)}}" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="modal-body">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="row">
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox1" type="checkbox" name="atividades">
                      <label for="checkbox1"> Atividades </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox2" type="checkbox" name="cadastro" checked>
                      <label for="checkbox2"> Dados cadastrais </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox3" type="checkbox" name="bacen">
                      <label for="checkbox3"> BACEN </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox4" type="checkbox" name="contacapital" checked>
                      <label for="checkbox4"> Conta capital </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox5" type="checkbox" name="contacorrente" checked>
                      <label for="checkbox5"> Conta corrente </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox6" type="checkbox" name="cartaocredito" checked>
                      <label for="checkbox6"> Conta cartão </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox7" type="checkbox" name="carteiracredito" checked>
                      <label for="checkbox7"> Emprestimos </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox8" type="checkbox" name="poupanca" checked>
                      <label for="checkbox8"> Poupança </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox9" type="checkbox" name="aplicacoes" checked>
                      <label for="checkbox9"> Aplicações </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox10" type="checkbox" name="iap" checked>
                      <label for="checkbox10"> IAP </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox11" type="checkbox" name="cobranca" checked>
                      <label for="checkbox11"> Cobrança </label>
                  </div>
                </div>  
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox11" type="checkbox" name="consorcio" checked>
                      <label for="checkbox11"> Consórcio </label>
                  </div>
                </div>  
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox11" type="checkbox" name="previdencia" checked>
                      <label for="checkbox11"> Previdência </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox11" type="checkbox" name="seguros" checked>
                      <label for="checkbox11"> Seguros </label>
                  </div>
                </div>
                <div class="col-lg-4 col-6">
                  <div class="checkbox checkbox-info checkbox-circle">
                      <input id="checkbox11" type="checkbox" name="sipag" checked>
                      <label for="checkbox11"> SIPAG </label>
                  </div>
                </div>             
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row col-12 justify-content-center mx-auto">
            <button class="btn btn-danger btn-outline col-lg-3 col-5 mx-1 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
              <i class="mdi mdi-close pr-2"></i> 
              <span>Cancelar</span>
            </button>
            <button type="submit" class="btn btn-success btn-outline col-lg-3 col-5 mx-1 d-flex align-items-center justify-content-center">
              <i class="mdi mdi-printer pr-2"></i> 
              <span>Imprimir PDF</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>