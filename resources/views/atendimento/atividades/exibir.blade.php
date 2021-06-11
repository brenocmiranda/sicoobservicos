@section('title')
Atividades
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Atividades</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="javascript:void(0)">Atendimento</a></li>
                <li class="active">Atividades</li>
            </ol>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="col-12 row mb-5 mx-auto">
                @include('layouts.search')
                <!--<div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
                    <button class="btn btn-primary btn-outline ml-auto" id="imprimir" name="imprimir" title="Imprimir atividades">
                        <i class="m-0 pr-lg-1 mdi mdi-printer"></i> 
                        <span class="hidden-xs">Imprimir</span>
                    </button>
                </div>-->
            </div>
            @if(isset($filtros))
                <div class="pl-3">
                    <b class="pr-2">Filtros:</b>
                    <span class="badge badge-info badge-pill mr-2" style="font-size: 10px;">{{(isset($filtros['tipo']) ? $filtros['tipo'] : '')}}</span>
                    <span class="badge badge-info badge-pill mr-2" style="font-size: 10px;">{{(isset($filtros['contato']) ? $filtros['contato'] : '')}}</span>
                    <span class="badge badge-info badge-pill mr-2" style="font-size: 10px;">{{(isset($filtros['colaborador']) ? $filtros['colaborador'] : '')}}</span>
                    <span class="badge badge-info badge-pill mr-2" style="font-size: 10px;">{{(isset($filtros['data_inicial']) ? date('d/m/Y', strtotime($filtros['data_inicial'])) : '').(isset($filtros['data_inicial']) && isset($filtros['data_final']) ? ' até ' : '').(isset($filtros['data_final']) ? date('d/m/Y', strtotime($filtros['data_final'])) : '')}}</span>
                    <a href="{{route('exibir.atividades.atendimento')}}" class="text-danger"><small>Limpar</small></a>
                </div>
                <hr class="mt-3">
            @endif
            @if(isset($dados[0]))
            <ul class="col-12 px-4" id="atividades">
                @foreach($dados as $atividade)
                <li class="row d-block w-100">
                    <div class="col-12">
                        <div class="d-flex">
                            <a href="{{route('exibirID.associado.atendimento', $atividade->cli_id_associado)}}" title="Abrir painel de atendimento" target="_blank">
                                <i class="pr-2 mdi mdi-account-card-details"></i>
                            </a>
                            <h5 class="text-uppercase my-auto">{{$atividade->RelationAssociado->nome}} &#183 {{(strlen($atividade->RelationAssociado->documento) == 11 ? substr($atividade->RelationAssociado->documento, 0, 3).'.'.substr($atividade->RelationAssociado->documento, 3, 3).'.'.substr($atividade->RelationAssociado->documento, 6, 3).'-'.substr($atividade->RelationAssociado->documento, 9, 2) : substr($atividade->RelationAssociado->documento, 0, 2).'.'.substr($atividade->RelationAssociado->documento, 3, 3).'.'.substr($atividade->RelationAssociado->documento, 6, 3).'/'.substr($atividade->RelationAssociado->documento, 8, 4).'-'.substr($atividade->RelationAssociado->documento, 12, 2))}}</h5>
                        </div>
                        <h6 class="font-weight-normal text-capitalize mt-2">Tipo: <b>{{$atividade->tipo}}</b></h6>
                        <h6 class="font-weight-normal">Contato por: <b class="text-capitalize">{{$atividade->contato}}</b></h6>
                        <label class="d-block">{{$atividade->descricao}}</label>
                        <div class="row col-12">
                            <small class="text-capitalize mr-auto">@if(Auth::user()->RelationFuncao->gerenciar_atendimento == 1)<b>{{$atividade->RelationUsuarios->RelationAssociado->nome}}</b> -@endif {{date('d/m/Y H:i:s', strtotime($atividade->created_at))}}</small>
                        </div>
                    </div>
                    <hr class="col-12 my-4" >
                </li>
                @endforeach
            </ul>
            @else
            <div class="row mx-auto col-12 p-0">
                <label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhuma atividade cadastrada.</label>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('modal')
    @include('atendimento.atividades.filtros');
@endsection

@section('suporte')
<script type="text/javascript">
    $(document).ready( function(){
        // Campo de pesquisa
        $("input[type=search]").keyup(function(){
            var texto = $(this).val().toUpperCase();
            $("#atividades li").css("display", "block");
            $("#atividades li").each(function(){
                if($(this).text().indexOf(texto) < 0)
                    $(this).css("display", "none");
            });
        });
    });
</script>
@endsection