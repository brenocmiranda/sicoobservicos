@section('title')
Relatórios
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Relatórios</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.administrativo')}}">Administrativo</a></li>
                <li class="active">Relatórios</li>
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
        <div class="card-body">
            <div class="col-lg-8 col-12">
              <div class="form-group">
                <label class="col-form-label pb-0">Dados do relatório <span class="text-danger">*</span></label>
                <select class="form-control form-control-line" id="dadosrelatorio" required>
                    <option value="">Selecione</option>
                    <option value="termoUso">Termo de responsabilidade de uso</option>
                </select>
              </div>
            </div>
            <div id="termoUso" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.termoUso.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 px-0">
                        <div class="col-12 row">
                            <div class="col-lg-8 col-12">
                                <div class="form-group">
                                    <label class="col-form-label pb-0">Usuários</label>
                                    <select class="form-control form-control-line" name="usuario" required>
                                        <option value="">Selecione</option>
                                        @foreach($usuarios as $usuario)
                                        <option value="{{$usuario->id}}">{{$usuario->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 justify-content-end ml-auto mt-3">
                            <button type="submit" class="btn btn-success btn-outline col-lg-3 col-6 d-flex align-items-center justify-content-center mx-2">
                                <i class="mdi mdi-printer pr-2"></i> 
                                <span>Gerar PDF</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
    $(document).ready( function (){
        $('#dadosrelatorio').on('change', function(e){
            if(this.value != ''){
                $('#'+this.value).fadeIn();
            }
        });
    });
</script>
@endsection