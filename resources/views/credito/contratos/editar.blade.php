<!-- Modal -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-block pb-0">
        <div class="col-lg-12">
          <button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Editar informações do contrato</h5>
        </div>
        <div class="col-lg-12 mb-0">
          <p>Preencha todas as informações necessárias.</p>
        </div>
        <div id="err"></div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="contratos-tab" data-toggle="tab" href="#contratosEdit" role="tab" aria-controls="contratos" aria-selected="true">Dados contratuais</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="garantias-tab" data-toggle="tab" href="#garantiasEdit" role="tab" aria-controls="garantias" aria-selected="false">Garantias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="complementares-tab" data-toggle="tab" href="#complementaresEdit" role="tab" aria-controls="complementares" aria-selected="false">Complementares</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="observacoes-tab" data-toggle="tab" href="#observacoesEdit" role="tab" aria-controls="observacoes" aria-selected="false">Observações</a>
          </li>
        </ul>
      </div>

      <div class="carregamento"></div>
      <div class="modal-body">
        <form class="form-sample" id="formEditar">
          @csrf
          <div class="col-12 grid-margin mb-0">
            <div class="card-body py-0">
              <div class="tab-content" id="myTabContent">
                <!-- TAB1 -->
                <div class="tab-pane fade show active" id="contratosEdit" role="tabpanel" aria-labelledby="contratos">
                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Nº contrato <i class="text-danger">*</i></label>
                        <div class="">
                          <input class="num_contrato form-control" name="num_contrato" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-9">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Associado <i class="text-danger">*</i></label>
                        <div class="">
                          <input type="text" name="cli_id_associado" class="cli_id_associado form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Produto <i class="text-danger">*</i></label>
                        <div class="input-field mt-0">
                          <select class="produto" name="produto" required>
                             @foreach($produtos as $produto)
                             <option value="{{$produto->id_produto}}">{{$produto->nome}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Modalidade <i class="text-danger">*</i></label>
                        <div class="input-field mt-0">
                          <select class="modalidade" name="modalidade" required>
                            <option disabled> Selecione a modalidade</option>
                             @foreach($modalidades as $modalidade)
                             <option value="{{$modalidade->id_modalidade}}">{{$modalidade->nome}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Data da operação <i class="text-danger">*</i></label>
                        <div class="">
                          <input type="date" class="data_operacao form-control" name="data_operacao" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Data de vencimento <i class="text-danger">*</i></label>
                        <div class="">
                          <input type="date" class="data_vencimento form-control" name="data_vencimento" required/>
                        </div>
                      </div>
                    </div>              
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Valor da operação (R$)<i class="text-danger">*</i></label>
                        <div class="">
                          <input type="text" class="money valor_contrato form-control" name="valor_contrato" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Armário <i class="text-danger">*</i></label>
                        <div class="input-field mt-0">
                          <select class="cre_id_armario" name="cre_id_armario" required>
                            <option disabled>Selecione o armário</option>
                            @foreach($armarios as $armario)
                               <option value="{{$armario->id_armario}}">{{$armario->referencia}} - {{$armario->nome}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- TAB2 -->
                <div class="tab-pane fade" id="garantiasEdit" role="tabpanel" aria-labelledby="garantias">
                  <div class="py-2">
                    <small>Garantias fidejussórias</small>
                    <a href="javascript::void(0);" class="btnAval badge badge-success">Novo +</a>
                  </div>
                  <div class="adicionarAvalista"><div class="form-group border rounded" id="avalista'+contador+'"> <div class="col-12"> <div class="d-flex"> <input type="text" name="avalista[]" class="avalista form-control mr-2" required> <a href="javascript:void(0)" class="badge badge-danger my-auto" onclick="excluirAvalista('+contador+'); return false;">Remover</a> </div> </div> </div></div>
                  <hr>
                  <div class="py-2">
                    <small>Garantias fiduciária</small>
                    <a href="javascript::void(0);" class="btnGarantia badge badge-success">Novo +</a>
                  </div>

                  <div class="adicionarGarantia"></div>
                </div>


                <!-- TAB3 -->
                <div class="tab-pane fade" id="complementaresEdit" role="tabpanel" aria-labelledby="complementares">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Finalidade</label>
                        <div class="" ass="input-field mt-0">
                          <select class="finalidade" name="finalidade">
                            <option disabled> Selecione a finalidade</option>
                             @foreach($finalidades as $finalidade)
                             <option value="{{$finalidade->id_finalidade}}">{{$finalidade->nome}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row col-12">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="col-form-label pb-0">Nível de risco</label>
                          <div class="">
                            <input type="text" class="nivel_risco form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="000" name="nivel_risco"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-form-label pb-0">Qtd. de parcelas</label>
                          <div class="">
                           <input type="text" class="quantidade_parcelas form-control" placeholder="00" name="quantidade_parcelas"/>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-4">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Taxa da operação (%)</label>
                      <div class="">
                        <input type="text" class="taxa_operacao form-control" placeholder="0,00" name="taxa_operacao"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="col-form-label pb-0">Taxa de mora (%)</label>
                      <div class="">
                        <input type="text" class="taxa_mora form-control" placeholder="0,00" name="taxa_mora"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Taxa de multa (%)</label>
                      <div class="">
                        <input type="text" class="taxa_multa form-control" placeholder="0,00" name="taxa_multa"/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <!-- TAB3 -->
              <div class="tab-pane fade" id="observacoesEdit" role="tabpanel" aria-labelledby="observacoes">
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Renegociação? <span class="text-danger">*</span></label>
                      <div class="">
                        <div class="form-group row">
                          <div class="form-radio mx-3">
                            <label class="form-check-label">
                              <input type="radio" class="renegociacao1 form-check-input" name="renegociacao" value="1"> Sim
                            </label>
                          </div>
                          <div class="form-radio mx-1">
                            <label class="form-check-label">
                              <input type="radio" class="renegociacao2 form-check-input" name="renegociacao" value="0"> Não
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-form-label">Observações</label>
                      <div class="">
                        <textarea class="observacao form-control" name="observacao" rows="4" cols="33" onkeyup="this.value = this.value.toUpperCase();"></textarea>
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
        <div class="col-lg-12 text-center">
          <button class="btn btn-outline-danger col-lg-3 mx-1"  data-dismiss="modal" aria-label="Close">
            <i class="mdi mdi-close"></i> Cancelar</button>
            <button type="submit" class="btn btn-outline-success col-lg-3 mx-1">
              <i class="mdi mdi-check"></i> Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
