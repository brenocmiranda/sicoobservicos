@section('title')
Solicitações de Cadastro
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Solicitações de cadastro</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Atendimento</a></li>
				<li class="active">Associados</li>
			</ol>
		</div>
	</div>
	<div class="confim"></div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mb-4 mx-auto">
				@include('layouts.search')
				<div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
					<a href="{{route('solicitar.cadastro.atendimento')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Solicitar cadastro">
						<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
						<span class="hidden-xs">Novo associado</span>
					</a>
				</div>
			</div>

			<section class="py-4">
				<div class="sttabs tabs-style-linetriangle row justify-content-center mx-auto">
                    <nav class="col-lg-8 col-12 mx-auto">
                        <ul>
                            <li class="tab-current">
                                <a href="#section-1">
                                    <span class="font-weight-bold d-block">Devolvido</span>
                                </a>
                            </li>
                        	<li>
                        		<a href="#section-2">
                        			<span class="font-weight-bold d-block">Em aberto</span>
                        		</a>
                        	</li>
                        	<li>
                        		<a href="#section-3">
                        			<span class="font-weight-bold d-block">Em andamento</span>
                        		</a>
                        	</li>
                        	<li>
                        		<a href="#section-4">
                        			<span class="font-weight-bold d-block">Finalizado</span>
                        		</a>
                        	</li>
                        	<li>
                        		<a href="#section-5">
                        			<span class="font-weight-bold d-block">Cancelado</span>
                        		</a>
                        	</li>
                        </ul>
                    </nav>
                    <div class="content-wrap col-12 px-0">
                        <section id="section-1" class="content-current">
                            <ul class="row col-12 m-auto px-0">
                                <li class="col-12 border rounded shadow-sm mb-3 callout-warning">
                                    <div class="p-3 h-100 row">
                                        <div class="text-left col-lg-6 col-8">
                                            <a href="#">
                                                <h5 class="text-uppercase my-1 text-truncate">
                                                    <span>BRENO DE CARVALHO MIRANDA</span> 
                                                    <i>&#183</i>
                                                    <span>#0152</span> 
                                                    <div class="badge badge-warning mx-2">Devolvido</div>
                                                </h5>
                                            </a>
                                            <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                                <span>Pessoa Física</span>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Documento</b>: 121.489.666-93</small>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Escolaridade</b>: Ensino Superior Incompleto</small>
                                            </label>
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Data de solicitação</b>: 22/01/2021 16:30:02</small>
                                            </label>                  
                                        </div>
                                        <div class="text-right row col-lg-3 col-4 ml-auto my-auto">
                                            <div class="ml-auto">
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2" title="">
                                                    <i class="mdi mdi-comment-processing-outline"></i>
                                                    <small class="hidden-xs"> Mais informações</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2" title="">
                                                    <i class="mdi mdi-cached"></i>
                                                    <small class="hidden-xs"> Atualizar status</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2" title="">
                                                    <i class="mdi mdi-cloud-print-outline"></i>
                                                    <small class="hidden-xs"> Gerar relatório</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </section>
                        <section id="section-2">
							<p class="col-12">
                                <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                            </p>
                        </section>
                        <section id="section-3">
							<p class="col-12">
                                <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                            </p>
                        </section>
                        <section id="section-4">
							<p class="col-12">
                                <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                            </p>			
                        </section>
                        <section id="section-5">
                            <p class="col-12">
                                <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                            </p>    
                        </section>
                    </div>
                </div>
            </section>
		</div>
	</div>
</div>
@endsection