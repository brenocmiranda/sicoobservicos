@extends('layouts.index')

@section('title')
Importações
@endsection

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Importações</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('inicio')}}">Configurações</a></li>
                <li class="active">Importações</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="section-title text-white font-weight-normal">Arquivos</h5>
        </div>
        <div class="card-body">
            @if(Session::has('upload'))
            <p class="mx-auto col-sm-12 alert alert-{{ Session::get('upload')['class'] }}">
                {{ Session::get('upload')['mensagem'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </p>
            @endif
            <form class="form-sample" action="{{route('executar.importacoes')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row col-12 mx-auto">
                    <div class="col-8">
                        <div class="form-group">
                            <label class="col-form-label mb-2">cli_associados.xlsx</label>
                            <input type="file" name="cli_associados" required>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label class="col-form-label mb-2">cli_emails.xlsx</label>
                            <input type="file">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label class="col-form-label mb-2">cli_telefones.xlsx</label>
                            <input type="file">
                        </div>
                    </div>
                    <hr class="col-10">
                    <div class="row col-12 justify-content-center mx-auto">
                        <button type="submit" class="btn btn-success btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
                            <i class="mdi mdi-upload pr-2"></i> 
                            <span>Fazer upload</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection