@section('title')
Novos associados
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
            </div>
            <section class="py-4">
                <div class="sttabs tabs-style-linetriangle row justify-content-center mx-auto">
                    <nav class="col-lg-9 col-12 mx-auto">
                        <ul>
                            <li class="tab-current">
                                <a href="#section-1">
                                    <span class="font-weight-bold d-block">Em aberto <small id="aberto" class="font-weight-bold"></small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#section-2">
                                    <span class="font-weight-bold d-block">Devolvido <small id="devolvido" class="font-weight-bold"></small></span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#section-3">
                                    <span class="font-weight-bold d-block">Em andamento <small id="andamento" class="font-weight-bold"></small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#section-4">
                                    <span class="font-weight-bold d-block">Finalizado <small id="finalizado" class="font-weight-bold"></small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#section-5">
                                    <span class="font-weight-bold d-block">Cancelado <small id="cancelado" class="font-weight-bold"></small></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="content-wrap col-12 px-0">
                        <section id="section-1" class="content-current">
                            @if(isset($solicitacoes[0]))
                            <?php $b = 0;?>
                                @foreach($solicitacoes as $solicitacao)
                                @if($solicitacao->RelationStatusRecente->status == 'aberto')
                                <li class="col-12 border rounded shadow-sm mb-3 callout-success">
                                    <div class="p-3 h-100 row">
                                        <div class="text-left col-lg-9 col-8">
                                            <a href="{{route('detalhes.cadastro.atendimento', $solicitacao->id)}}">
                                                <h5 class="text-uppercase my-1 text-truncate">
                                                    <span>#0{{$solicitacao->id}}</span> 
                                                    <i>&#183</i>
                                                    <span class="pl-1">{{$solicitacao->nome}}</span> 
                                                    <div class="badge badge-success mx-2 text-uppercase">{{$solicitacao->RelationStatusRecente->status}}</div>
                                                </h5>
                                            </a>
                                            <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                                <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                            </label>
                                            @if($solicitacao->sigla == "PF")
                                                <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                                </label>
                                            @else
                                                 <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Atividade econômica</b>: {{$solicitacao->atividade_economica}}</small>
                                                </label>
                                            @endif
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
                                            </label>
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Solicitante</b>: {{$solicitacao->RelationUsuario->RelationAssociado->nome}}</small>
                                            </label>                   
                                        </div>
                                        <div class="text-right row col-lg-3 col-4 ml-auto my-auto">
                                            <div class="ml-auto">
                                                <a href="{{route('detalhes.cadastro.atendimento', $solicitacao->id)}}" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Detalhes do cadastro">
                                                    <i class="mdi mdi-comment-processing-outline"></i>
                                                    <small class="hidden-xs"> Mais informações</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Atualizar estado">
                                                    <i class="mdi mdi-cached"></i>
                                                    <small class="hidden-xs"> Atualizar status</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Gerar relatório">
                                                    <i class="mdi mdi-cloud-print-outline"></i>
                                                    <small class="hidden-xs"> Gerar relatório</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php $b++; ?>
                                @endif
                                @endforeach
                                @if($b == 0)
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
                        <section id="section-2" >
                            <ul class="row col-12 m-auto px-0">
                                @if(isset($solicitacoes[0]))
                                <?php $a = 0;?>
                                    @foreach($solicitacoes as $solicitacao)
                                        @if($solicitacao->RelationStatusRecente->status == 'devolvido')
                                        <li class="col-12 border rounded shadow-sm mb-3 callout-warning">
                                            <div class="p-3 h-100 row">
                                                <div class="text-left col-lg-9 col-8">
                                                    <a href="#">
                                                        <h5 class="text-uppercase my-1 text-truncate">
                                                            <span>#0{{$solicitacao->id}}</span> 
                                                            <i>&#183</i>
                                                            <span class="pl-1">{{$solicitacao->nome}}</span> 
                                                            <div class="badge badge-warning mx-2 text-uppercase">{{$solicitacao->RelationStatusRecente->status}}</div>
                                                        </h5>
                                                    </a>
                                                    <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                                        <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                                    </label>
                                                    <label class="text-capitalize d-block text-primary mb-0">
                                                        <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                                    </label>
                                                     @if($solicitacao->sigla == "PF")
                                                        <label class="text-capitalize d-block text-primary mb-0">
                                                            <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                                        </label>
                                                    @else
                                                         <label class="text-capitalize d-block text-primary mb-0">
                                                            <small class="text-dark"><b>Atividade econômica</b>: {{$solicitacao->atividade_economica}}</small>
                                                        </label>
                                                    @endif
                                                    <label class="text-truncate d-block mb-0">
                                                        <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
                                                    </label>
                                                    <label class="text-truncate d-block mb-0">
                                                        <small class="text-dark"><b>Solicitante</b>: {{$solicitacao->RelationUsuario->RelationAssociado->nome}}</small>
                                                    </label>                   
                                                </div>
                                                <div class="text-right row col-lg-3 col-4 ml-auto my-auto">
                                                    <div class="ml-auto">
                                                        <a href="{{route('detalhes.cadastro.atendimento', $solicitacao->id)}}" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Detalhes do cadastro">
                                                            <i class="mdi mdi-comment-processing-outline"></i>
                                                            <small class="hidden-xs"> Mais informações</small>
                                                        </a>
                                                        <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Atualizar estado">
                                                            <i class="mdi mdi-cached"></i>
                                                            <small class="hidden-xs"> Atualizar status</small>
                                                        </a>
                                                        <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Gerar relatório">
                                                            <i class="mdi mdi-cloud-print-outline"></i>
                                                            <small class="hidden-xs"> Gerar relatório</small>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php $a++; ?>
                                        @endif
                                    @endforeach
                                    @if($a == 0)
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
                        <section id="section-3">
                            @if(isset($solicitacoes[0]))
                                <?php $c = 0;?>
                                @foreach($solicitacoes as $solicitacao)
                                @if($solicitacao->RelationStatusRecente->status == 'andamento')
                                <li class="col-12 border rounded shadow-sm mb-3 callout-info">
                                    <div class="p-3 h-100 row">
                                        <div class="text-left col-lg-9 col-8">
                                            <a href="#">
                                                <h5 class="text-uppercase my-1 text-truncate">
                                                    <span>#0{{$solicitacao->id}}</span> 
                                                    <i>&#183</i>
                                                    <span class="pl-1">{{$solicitacao->nome}}</span>  
                                                    <div class="badge badge-info mx-2 text-uppercase">{{$solicitacao->RelationStatusRecente->status}}</div>
                                                </h5>
                                            </a>
                                            <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                                <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                            </label>
                                            @if($solicitacao->sigla == "PF")
                                                <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                                </label>
                                            @else
                                                 <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Atividade econômica</b>: {{$solicitacao->atividade_economica}}</small>
                                                </label>
                                            @endif
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
                                            </label>
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Solicitante</b>: {{$solicitacao->RelationUsuario->RelationAssociado->nome}}</small>
                                            </label>                   
                                        </div>
                                        <div class="text-right row col-lg-3 col-4 ml-auto my-auto">
                                            <div class="ml-auto">
                                                <a href="{{route('detalhes.cadastro.atendimento', $solicitacao->id)}}" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Detalhes do cadastro">
                                                    <i class="mdi mdi-comment-processing-outline"></i>
                                                    <small class="hidden-xs"> Mais informações</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Atualizar estado">
                                                    <i class="mdi mdi-cached"></i>
                                                    <small class="hidden-xs"> Atualizar status</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Gerar relatório">
                                                    <i class="mdi mdi-cloud-print-outline"></i>
                                                    <small class="hidden-xs"> Gerar relatório</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php $c++; ?>
                                @endif
                                @endforeach
                                @if($c == 0)
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
                            @if(isset($solicitacoes[0]))
                            <?php $d = 0;?>
                                @foreach($solicitacoes as $solicitacao)
                                @if($solicitacao->RelationStatusRecente->status == 'finalizado')
                                <li class="col-12 border rounded shadow-sm mb-3 callout-dark">
                                    <div class="p-3 h-100 row">
                                        <div class="text-left col-lg-9 col-8">
                                            <a href="#">
                                                <h5 class="text-uppercase my-1 text-truncate">
                                                    <span>#0{{$solicitacao->id}}</span> 
                                                    <i>&#183</i>
                                                    <span class="pl-1">{{$solicitacao->nome}}</span> 
                                                    <div class="badge bg-dark mx-2 text-uppercase">{{$solicitacao->RelationStatusRecente->status}}</div>
                                                </h5>
                                            </a>
                                            <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                                <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                            </label>
                                            @if($solicitacao->sigla == "PF")
                                                <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                                </label>
                                            @else
                                                 <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Atividade econômica</b>: {{$solicitacao->atividade_economica}}</small>
                                                </label>
                                            @endif
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
                                            </label>              
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Solicitante</b>: {{$solicitacao->RelationUsuario->RelationAssociado->nome}}</small>
                                            </label>     
                                        </div>
                                        <div class="text-right row col-lg-3 col-4 ml-auto my-auto">
                                            <div class="ml-auto">
                                                <a href="{{route('detalhes.cadastro.atendimento', $solicitacao->id)}}" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Detalhes do cadastro">
                                                    <i class="mdi mdi-comment-processing-outline"></i>
                                                    <small class="hidden-xs"> Mais informações</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Atualizar estado">
                                                    <i class="mdi mdi-cached"></i>
                                                    <small class="hidden-xs"> Atualizar status</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Gerar relatório">
                                                    <i class="mdi mdi-cloud-print-outline"></i>
                                                    <small class="hidden-xs"> Gerar relatório</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php $d++; ?>
                                @endif
                                @endforeach
                                @if($d == 0)
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
                            @if(isset($solicitacoes[0]))
                            <?php $e = 0;?>
                                @foreach($solicitacoes as $solicitacao)
                                @if($solicitacao->RelationStatusRecente->status == 'cancelado')
                                <li class="col-12 border rounded shadow-sm mb-3 callout-danger">
                                    <div class="p-3 h-100 row">
                                        <div class="text-left col-lg-9 col-8">
                                            <a href="#">
                                                <h5 class="text-uppercase my-1 text-truncate">
                                                    <span>#0{{$solicitacao->id}}</span> 
                                                    <i>&#183</i>
                                                    <span class="pl-1">{{$solicitacao->nome}}</span> 
                                                    <div class="badge badge-danger mx-2 text-uppercase">{{$solicitacao->RelationStatusRecente->status}}</div>
                                                </h5>
                                            </a>
                                            <label class="text-truncate d-block font-weight-bold text-muted mb-3">
                                                <span>{{($solicitacao->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</span>
                                            </label>
                                            <label class="text-capitalize d-block text-primary mb-0">
                                                <small class="text-dark"><b>Documento</b>: {{$solicitacao->documento}}</small>
                                            </label>
                                            @if($solicitacao->sigla == "PF")
                                                <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Escolaridade</b>: {{$solicitacao->escolaridade}}</small>
                                                </label>
                                            @else
                                                 <label class="text-capitalize d-block text-primary mb-0">
                                                    <small class="text-dark"><b>Atividade econômica</b>: {{$solicitacao->atividade_economica}}</small>
                                                </label>
                                            @endif
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Data de solicitação</b>: {{date('d/m/Y H:i:s', strtotime($solicitacao->created_at))}}</small>
                                            </label>      
                                            <label class="text-truncate d-block mb-0">
                                                <small class="text-dark"><b>Solicitante</b>: {{$solicitacao->RelationUsuario->RelationAssociado->nome}}</small>
                                            </label>              
                                        </div>
                                        <div class="text-right row col-lg-3 col-4 ml-auto my-auto">
                                            <div class="ml-auto">
                                                <a href="{{route('detalhes.cadastro.atendimento', $solicitacao->id)}}" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Detalhes do cadastro">
                                                    <i class="mdi mdi-comment-processing-outline"></i>
                                                    <small class="hidden-xs"> Mais informações</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Atualizar estado">
                                                    <i class="mdi mdi-cached"></i>
                                                    <small class="hidden-xs"> Atualizar status</small>
                                                </a>
                                                <a href="#" class="btn btn-default btn-outline btn-rounded btn-xs col-10 mb-2 py-2" title="Gerar relatório">
                                                    <i class="mdi mdi-cloud-print-outline"></i>
                                                    <small class="hidden-xs"> Gerar relatório</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php $e++; ?>
                                @endif
                                @endforeach
                                @if($e == 0)
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

@section('suporte')
<script type="text/javascript">
    $(document).ready(function(){
        $('#devolvido').html("({{(isset($a) ? $a : '0')}})");
        $('#aberto').html("({{(isset($b) ? $b : '0')}})");
        $('#andamento').html("({{(isset($c) ? $c : '0')}})");
        $('#finalizado').html("({{(isset($d) ? $d : '0')}})");
        $('#cancelado').html("({{(isset($e) ? $e : '0')}})");
    });
</script>
@endsection