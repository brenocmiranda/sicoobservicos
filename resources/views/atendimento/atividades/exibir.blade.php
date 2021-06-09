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
    <div class="confim"></div>
    <div class="card">
        <div class="card-body">
            <div class="h-100 row col">
                <div class="col-lg-12 position-absolute">
                    @if(Auth::user()->RelationFuncao->gerenciar_atendimento == 1)
                    <div class="row mx-auto">
                        <button class="btn btn-primary btn-outline ml-auto" id="imprimir" name="imprimir" title="Imprimir relatório" data-toggle="modal" data-target="#modal-imprimir" style="z-index: 10">
                            <i class="m-0 pr-lg-1 mdi mdi-printer"></i> 
                            <span class="hidden-xs">Imprimir</span> 
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mb-3">
                <table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" id="table" style="overflow-y: auto;">
                    <thead>
                        <th> PA </th>
                        <th> Documento </th>
                        <th> Associado </th>
                        <th> Tipo </th>
                        <th> Contato </th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
    $(document).ready( function(){
        // Criando a datatables
        $('#table').DataTable({
            deferRender: true,
            order: [0, 'asc'],
            paginate: true,
            select: true,
            searching: true,
            destroy: true,
            ajax: "{{ route('listar.atividades.atendimento') }}",
            serverSide: true,
            "columns": [ 
                { "data": "pa", "name":"pa"},
                { "data": "documento", "name":"documento"},
                { "data": "associado", "name":"associado"},
                { "data": "tipo", "name":"tipo"},
                { "data": "contato","name":"contato"},
            ],
        });
    });
</script>
@endsection