@section('title')
Cadastro
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Cadastro</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="javascript:void(0)">Cadastro</a></li>
                <li class="active">Solicitações</li>
            </ol>
        </div>
    </div>
    <div class="confim"></div>
    <div class="card">
        <div class="card-body">
            <div class="col-12 row mb-4 mx-auto">
                @include('layouts.search')
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
                                @if($solicitacoes[0])
                                <?php $i = 0;?>
                                @foreach($solicitacoes as $solicitacao)
                                @if($solicitacao->RelationStatusRecente->status == 'devolvido')
                                <li class="col-12 border rounded shadow-sm mb-3 callout-warning">
                                    <div class="p-3 h-100 row">
                                        <div class="text-left col-lg-6 col-8">
                                            <a href="#">
                                                <h5 class="text-uppercase my-1 text-truncate">
                                                    <span>{{$solicitacao->nome}}</span> 
                                                    <i>&#183</i>
                                                    <span>#0{{$solicitacao->id}}</span> 
                                                    <div class="badge badge-warning mx-2 text-uppercase">{{$solicitacao->status}}</div>
                                                </h5>
                                            </a>
                                            <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                                <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                            </label>
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
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
                                <?php $i++; ?>
                                @endif
                                @endforeach
                                @if($i == 0)
                                <li class="text-center mx-auto">
                                    <p class="col-12">
                                        <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                    </p>
                                </li>
                                @endif
                                @else
                                <li class="text-center mx-auto">
                                    <p class="col-12">
                                        <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                    </p>
                                </li>
                                @endif
                            </ul>
                        </section>
                        <section id="section-2">
                            @if($solicitacoes[0])
                            <?php $i = 0;?>
                            @foreach($solicitacoes as $solicitacao)
                            @if($solicitacao->RelationStatusRecente->status == 'aberto')
                            <li class="col-12 border rounded shadow-sm mb-3 callout-success">
                                <div class="p-3 h-100 row">
                                    <div class="text-left col-lg-6 col-8">
                                        <a href="#">
                                            <h5 class="text-uppercase my-1 text-truncate">
                                                <span>{{$solicitacao->nome}}</span> 
                                                <i>&#183</i>
                                                <span>#0{{$solicitacao->id}}</span> 
                                                <div class="badge badge-warning mx-2 text-uppercase">{{$solicitacao->status}}</div>
                                            </h5>
                                        </a>
                                        <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                            <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                        </label>
                                        <label class="text-truncate d-block mb-0">
                                            <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
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
                            <?php $i++; ?>
                            @endif
                            @endforeach
                            @if($i == 0)
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif
                            @else
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif
                        </section>
                        <section id="section-3">
                            @if($solicitacoes[0])
                            <?php $i = 0;?>
                            @foreach($solicitacoes as $solicitacao)
                            @if($solicitacao->RelationStatusRecente->status == 'andamento')
                            <li class="col-12 border rounded shadow-sm mb-3 callout-info">
                                <div class="p-3 h-100 row">
                                    <div class="text-left col-lg-6 col-8">
                                        <a href="#">
                                            <h5 class="text-uppercase my-1 text-truncate">
                                                <span>{{$solicitacao->nome}}</span> 
                                                <i>&#183</i>
                                                <span>#0{{$solicitacao->id}}</span> 
                                                <div class="badge badge-warning mx-2 text-uppercase">{{$solicitacao->status}}</div>
                                            </h5>
                                        </a>
                                        <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                            <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                        </label>
                                        <label class="text-truncate d-block mb-0">
                                            <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
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
                            <?php $i++; ?>
                            @endif
                            @endforeach
                            @if($i == 0)
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif
                            @else
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif
                        </section>
                        <section id="section-4">
                            @if($solicitacoes[0])
                            <?php $i = 0;?>
                            @foreach($solicitacoes as $solicitacao)
                            @if($solicitacao->RelationStatusRecente->status == 'finalizado')
                            <li class="col-12 border rounded shadow-sm mb-3 callout-dark">
                                <div class="p-3 h-100 row">
                                    <div class="text-left col-lg-6 col-8">
                                        <a href="#">
                                            <h5 class="text-uppercase my-1 text-truncate">
                                                <span>{{$solicitacao->nome}}</span> 
                                                <i>&#183</i>
                                                <span>#0{{$solicitacao->id}}</span> 
                                                <div class="badge badge-warning mx-2 text-uppercase">{{$solicitacao->status}}</div>
                                            </h5>
                                        </a>
                                        <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                            <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                        </label>
                                        <label class="text-truncate d-block mb-0">
                                            <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
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
                            <?php $i++; ?>
                            @endif
                            @endforeach
                            @if($i == 0)
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif
                            @else
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif		
                        </section>
                        <section id="section-5">
                            @if($solicitacoes[0])
                            <?php $i = 0;?>
                            @foreach($solicitacoes as $solicitacao)
                            @if($solicitacao->RelationStatusRecente->status == 'cancelado')
                            <li class="col-12 border rounded shadow-sm mb-3 callout-danger">
                                <div class="p-3 h-100 row">
                                    <div class="text-left col-lg-6 col-8">
                                        <a href="#">
                                            <h5 class="text-uppercase my-1 text-truncate">
                                                <span>{{$solicitacao->nome}}</span> 
                                                <i>&#183</i>
                                                <span>#0{{$solicitacao->id}}</span> 
                                                <div class="badge badge-warning mx-2 text-uppercase">{{$solicitacao->status}}</div>
                                            </h5>
                                        </a>
                                        <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                            <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                        </label>
                                        <label class="text-capitalize d-block text-primary mb-0">
                                            <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                        </label>
                                        <label class="text-truncate d-block mb-0">
                                            <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
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
                            <?php $i++; ?>
                            @endif
                            @endforeach
                            @if($i == 0)
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif
                            @else
                            <li class="text-center mx-auto">
                                <p class="col-12">
                                    <h5 class="text-center font-weight-normal"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma solicitação nesse estado.</h5>
                                </p>
                            </li>
                            @endif  
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection