<!-- Modal -->
<div class="modal fade" id="modal-solicitacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
	<div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header d-block pb-0">
				<div class="col-12">
					<button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Efetuar solicitação de contrato</h5>
				</div>
				<div class="col-12 mb-0">
					<p>Preencha todas as informações necessárias.</p>
				</div>
				<div id="err"></div>
			</div>
			<div class="carregamento"></div>
			<form class="form-sample" id="formSolicitacao" enctype="multipart/form-data" autocomplete="off">
				@csrf
				<div class="modal-body">
					<div class="col-12 grid-margin mb-0">
						<div class="card-body py-0">
							<div class="row">
								<div class="col-12">
				                  <div class="form-group">
				                    <label class="col-form-label pb-0">Contrato <span class="text-danger">*</span></label>
				                    <select class="form-control form-control-line contrato" name="contrato" required>
				                      <option value=""> Selecione o contrato</option>
				                      @foreach($contratos as $contrato)
				                        <option value="{{$contrato->id}}">{{$contrato->num_contrato}} - {{$contrato->RelationAssociados->nome}}</option>
				                      @endforeach
				                    </select>
				                  </div>
				                </div>
				                <div class="col-12">
				                	<div class="row">
										<div class="col-6">
					                      <div class="form-group">
					                        <label class="col-form-label pb-0">Produto</label>
					                        <div class="input-field mt-0">
					                          <select class="form-control form-control-line cre_id_produtos" id="cre_id_produtos" disabled>
					                            <option value=""></option>
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
					                        <select class="form-control form-control-line cre_id_modalidades" id="cre_id_modalidades" disabled>
					                          <option value=""></option>
					                           @foreach($modalidades as $modalidade)
						                          <option value="{{$modalidade->id}}">{{$modalidade->codigo}} - {{$modalidade->nome}}</option>
						                        @endforeach
					                        </select>
					                      </div>
					                    </div>
					                    <div class="col-4">
					                      <div class="form-group">
					                        <label class="col-form-label pb-0">Data da operação </label>
					                        <input type="date" class="form-control form-control-line data_operacao" id="data_operacao" disabled/>
					                      </div>
					                    </div>
					                    <div class="col-4">
					                      <div class="form-group">
					                        <label class="col-form-label pb-0">Data de vencimento</label>
					                        <input type="date" class="form-control form-control-line data_vencimento" id="data_vencimento" disabled/>
					                      </div>
					                    </div>              
					                    <div class="col-4">
					                      <div class="form-group">
					                        <label class="col-form-label pb-0">Valor da operação</label>
					                        <input type="text" class="money form-control form-control-line valor_contrato" id="valor_contrato" disabled/>
					                      </div>
					                    </div>
						                <div class="col-12">
					                      <div class="form-group">
					                        <label class="col-form-label pb-0">Observações</label>
					                        <textarea class="form-control form-control-line" id="observacoes" placeholder="Entre com as observações..." rows="3"></textarea> 
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
						<button type="submit" class="btn btn-success btn-outline col-3 mx-1 d-flex align-items-center justify-content-center">
							<i class="mdi mdi-check pr-2"></i> 
							<span>Enviar</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal -->
