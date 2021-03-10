<!-- Modal -->
<div class="modal fade" id="modal-solicitacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="overflow-y: hidden;">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document" >
		<div class="modal-content">
			<div class="modal-header d-block pb-0">
				<div class="col-12">
					<button type="button" class="close px-0 py-2" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Efetuar solicitação de materiais</h5>
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
					<div class="row mx-auto">
						<div class="col-lg-5 col-12 px-0">
							<div class="card-body py-0">
								<div class="row">
									<div class="col-lg-10 col-12">
										<div class="form-group">
											<label class="col-form-label pb-0">Categorias <span class="text-danger">*</span></label>
											<select class="categorias form-control form-control-line">
												<option value="">Selecione</option>
												@foreach($categorias as $categoria)
													<option value="{{$categoria->id}}">{{$categoria->nome}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label class="col-form-label pb-0">Materiais <span class="text-danger">*</span></label>
											<select class="materiais form-control form-control-line" disabled>
												<option disabled>Selecione</option>
											</select>
										</div>
									</div>
									<div class="row col-12">
										<div class="col-lg-8 col-12">
						                  <div class="form-group">
						                    <label class="col-form-label pb-0">Quantidade <span class="text-danger">*</span></label>
						                    <div class="row m-0">
						                    	<div class="col p-0">
						                    		<input type="number" class="quantidade form-control form-control-line" min="0"/>
						                    	</div>
						                    	<div class="col my-auto">
						                   	 		<small>unidades</small>
						                   	 	</div>
						                    </div>			                   
						                  </div>
						                </div>
					                </div>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-1 m-auto px-2 text-center py-4">
							<a href="javascript:void(0)" title="Adicionar no carrinho" id="adicionarItem" style="line-height: 10px;">
								<i class="mdi mdi-36px mdi-chevron-double-right hidden-xs"></i>
								<i class="mdi mdi-36px mdi-chevron-double-down visible-xs"></i>
								<small>Adicionar</small>
							</a>
						</div>
						<div class="col-lg-5 col-12">
							<div class="row col-12 mx-auto p-lg-0 px-5">
								<h6 class="col-form-label mt-0 pb-3">Seus materiais:</h6>
								<div id="materiais" class="col-12">
									<div class="pb-2 null">
										<span>Nenhum item selecionado.</span>
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
						<button type="submit" class="btn btn-success btn-outline col-lg-3 col-5 mx-1 d-flex align-items-center justify-content-center" disabled>
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
