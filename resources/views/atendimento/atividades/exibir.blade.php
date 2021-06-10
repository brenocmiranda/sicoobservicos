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
                <div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
                    <button class="btn btn-primary btn-outline ml-auto" id="imprimir" name="imprimir" title="Imprimir atividades">
                        <i class="m-0 pr-lg-1 mdi mdi-printer"></i> 
                        <span class="hidden-xs">Imprimir</span>
                    </button>
                </div>
            </div>
            <ul class="col-12">
                @foreach($dados as $atividade)
                <li class="row">
                    <div class="col-12">
                        <h5 class="text-uppercase">{{$atividade->RelationAssociado->nome}} &#183 {{$atividade->RelationAssociado->documento}}</h5>
                        <h6 class="font-weight-normal text-capitalize">Tipo: <b>{{$atividade->tipo}}</b></h6>
                        <h6 class="font-weight-normal">Contato por: <b class="text-capitalize">{{$atividade->contato}}</b></h6>
                        <label class="d-block">{{$atividade->descricao}}</label>
                        <div class="row col-12">
                            <small class="text-capitalize mr-auto">{{date('d/m/Y H:i:s', strtotime($atividade->created_at))}}</small>
                        </div>
                    </div>
                    <hr class="col-12">
                </li>
                @endforeach
            </ul>
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

    });
</script>
@endsection