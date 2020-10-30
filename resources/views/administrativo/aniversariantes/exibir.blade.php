@section('title')
Aniversariantes
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Aniversariantes</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.administrativo')}}">Administrativo</a></li>
                <li class="active">Aniversariantes</li>
            </ol>
        </div>
    </div>
    
    @if(Session::has('upload'))
    <p class="mx-auto col-12 alert alert-{{ Session::get('upload')['class'] }}">
        {{ Session::get('upload')['mensagem'] }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </p>
    @endif

    <div class="card">
        <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white">Relatório</h5>
        </div>
        <div class="card-body">
            <form class="form-sample" target="_blank" action="{{route('gerar.aniversariantes.administrativo')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row col-12 mx-auto justify-content-center">
                    <div class="col-8">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Mês de referência <span class="text-danger">*</span></label>
                        <select class="form-control form-control-line" name="mes" required>
                            <option value="">Selecione</option>
                            <option value="01">Janeiro</option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="col-form-label pb-0">Orientação <span class="text-danger">*</span></label>
                        <select class="form-control form-control-line" name="orientacao" required>
                            <option value="">Selecione</option>
                            <option value="paisagem">Paisagem</option>
                            <option value="retrato">Retrato</option>
                        </select>
                      </div>
                    </div>

                    
                    <div class="row col-12 justify-content-center mx-auto mt-5">
                        <button type="submit" class="btn btn-success btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
                            <i class="mdi mdi-printer pr-2"></i> 
                            <span>Gerar relatório</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
