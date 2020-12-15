<!-- Modal -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document" style="min-width: 1000px;">
    <div class="modal-content">
      <div class="modal-header d-block border-bottom-0 pb-0">
        <div class="col-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Detalhes do contrato</h5>
        </div>
        <div class="col-12 mb-0">
          <p>Abaixo estão listadas as informações do contrato.</p>
        </div>
        <div id="err"></div>
        <ul class="nav customtab col-12" role="tablist">
          <li role="presentation" class="active">
            <a href="#contratos-det" aria-controls="contratos-det" role="tab" data-toggle="tab" aria-expanded="true">
              <span class="visible-xs"><i class="ti-home"></i></span>
              <span class="hidden-xs"> Dados contratuais</span>
            </a>
          </li>
          <li role="presentation" class="">
            <a href="#garantias-det" aria-controls="garantias-det" role="tab" data-toggle="tab" aria-expanded="true">
              <span class="visible-xs"><i class="ti-home"></i></span>
              <span class="hidden-xs"> Garantias</span>
            </a>
          </li>
          <li role="presentation" class="">
            <a href="#complementares-det" aria-controls="complementares-det" role="tab" data-toggle="tab" aria-expanded="true">
              <span class="visible-xs"><i class="ti-home"></i></span>
              <span class="hidden-xs"> Complementares</span>
            </a>
          </li>
          <li role="presentation" class="">
            <a href="#observacoes-det" aria-controls="observacoes-det" role="tab" data-toggle="tab" aria-expanded="true">
              <span class="visible-xs"><i class="ti-home"></i></span>
              <span class="hidden-xs"> Observações</span>
            </a>
          </li>
        </ul>
      </div>

        <div class="modal-body pt-0">
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-3">
              <div class="tab-content mt-4" id="myTabContent">
                <!-- TAB1 -->
                <div class="tab-pane active in" id="contratos-det" role="tabpanel" aria-labelledby="contratos-det">
                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Nº contrato</label>
                        <div class="">
                          <input class="num_contrato form-control form-control-line" name="num_contrato" max="9" disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="col-9">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Associado</label>
                        <input type="text" name="cli_id_associado" class="cli_id_associado form-control form-control-line" placeholder="Pesquise o associado" disabled>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Produto</label>
                        <div class="input-field mt-0">
                          <select class="cre_id_produtos form-control form-control-line" name="cre_id_produtos" disabled>
                            <option value=""> Selecione o produto</option>
                            @foreach($produtos as $produto)
                            <option value="{{$produto->id}}">{{$produto->nome}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Modalidade</label>
                        <select class="cre_id_modalidades form-control form-control-line" name="cre_id_modalidades" disabled>
                          <option value=""> Selecione a modalidade</option>
                          @foreach($modalidades as $modalidade)
                          <option value="{{$modalidade->id}}">{{$modalidade->codigo}} - {{$modalidade->nome}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Data da operação</label>
                        <input type="date" class="data_operacao form-control form-control-line" name="data_operacao" disabled/>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Data de vencimento</label>
                        <input type="date" class="data_vencimento form-control form-control-line" name="data_vencimento" disabled/>
                      </div>
                    </div>              
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Valor da operação (R$)</label>
                        <input type="text" class="money valor_contrato form-control form-control-line" name="valor_contrato" disabled/>
                      </div>
                    </div>
                    <div class="col-8">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Armário</label>
                        <select class="cre_id_armarios form-control form-control-line" name="cre_id_armarios" disabled>
                          <option value="">Selecione o armário</option>
                          @foreach($armarios as $armario)
                          <option value="{{$armario->id}}">{{$armario->referencia}} - {{$armario->nome}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    @if(Request::segment(4) == 'vigente' || Request::segment(4) == 'quitado' || Request::segment(4) == 'prejuizo') 
                    <input type="hidden" name="status" value="{{Request::segment(4)}}">
                    @else
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Status</label>
                        <select class="status form-control form-control-line" name="status" disabled>
                          <option value=""> Selecione o status</option>
                          <option value="vigente">Vigente</option>
                          <option value="quitado">Quitado</option>
                          <option value="prejuizo">Prejuízo</option>
                        </select>
                      </div>
                    </div>
                    @endif

                  </div>
                </div>
                <!-- TAB2 -->
                <div class="tab-pane" id="garantias-det" role="tabpanel" aria-labelledby="garantias-det">
                  <div class="py-2">
                    <label>Garantias fidejussórias</label>
                  </div>
                  <div class="adicionarAvalista"></div>
                  <hr>
                  <div class="py-2">
                    <label>Garantias fiduciária</label>
                  </div>

                  <div class="adicionarGarantia"></div>
                </div>
                <!-- TAB3 -->
                <div class="tab-pane" id="complementares-det" role="tabpanel" aria-labelledby="complementares-det">
                  <div class="row">
                    <div class="col-9">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Finalidade</label>
                        <select class="cre_id_finalidades form-control form-control-line" name="cre_id_finalidades" disabled>
                          <option value=""> Selecione a finalidade</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Nível de risco</label>
                        <input type="text" class="nivel_risco form-control form-control-line" onkeyup="this.value = this.value.toUpperCase();" name="nivel_risco" placeholder="000" disabled/>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Qtd. de parcelas</label>
                        <input type="text" class="qtd_parcelas form-control form-control-line" placeholder="00" name="qtd_parcelas" disabled/>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Qtd. de parcelas pagas</label>
                        <input type="text" class="qtd_parcelas_pagas form-control form-control-line" placeholder="00" name="qtd_parcelas_pagas" disabled/>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Taxa da operação (%)</label>
                        <input type="text" class="taxa_operacao form-control form-control-line" placeholder="0,00" name="taxa_operacao" disabled/>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group ">
                        <label class="col-form-label pb-0">Taxa de mora (%)</label>
                        <input type="text" class="taxa_mora form-control form-control-line" placeholder="0,00" name="taxa_mora" disabled/>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Taxa de multa (%)</label>
                        <input type="text" class="taxa_multa form-control form-control-line" placeholder="0,00" name="taxa_multa" disabled/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- TAB4 -->
                <div class="tab-pane" id="observacoes-det" role="tabpanel" aria-labelledby="observacoes-det">
                  <div class="row">
                    <div class="col-10">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Renegociação? <span class="text-danger">*</span></label>
                        <div class="col-12 row my-auto">
                          <div class="radio radio-success my-3 mr-4">
                            <input id="checkbox-3" type="radio" name="renegociacao" class="renegociacao1" value="1" disabled>
                            <label for="checkbox-3"> Sim </label>
                          </div>
                          <div class="radio radio-success my-3">
                            <input id="checkbox-4" type="radio" name="renegociacao" class="renegociacao2"  value="0" disabled>
                            <label for="checkbox-4"> Não </label>
                          </div>
                          <div class="mx-4">
                            <input type="text" class="renegociacao_contrato form-control form-control-line" placeholder="Nº do contrato" name="renegociacao_contrato" disabled>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <label class="col-form-label">Observações</label>
                        <div class="">
                          <textarea class="observacoes form-control form-control-line" name="observacoes" rows="4" cols="33" onkeyup="this.value = this.value.toUpperCase();" placeholder="Descreva as observações do contrato" disabled></textarea>
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
          </div>
        </div>
    </div>
  </div>
</div>
<!-- Modal -->
