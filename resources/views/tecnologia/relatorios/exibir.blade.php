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
            <div class="col-lg-12 col-12">
              <div class="form-group">
                <label class="col-form-label pb-0">Tipos de relatórios <span class="text-danger">*</span></label>
                <div class="radio radio-success">
                    <input type="radio" name="dados" id="radio1" value="option1">
                    <label for="radio1"> Atalhos </label>
                </div>
                <div class="radio radio-success">
                    <input type="radio" name="dados" id="radio2" value="option2">
                    <label for="radio2"> Chamados </label>
                </div>
                <div class="radio radio-success">
                    <input type="radio" name="dados" id="radio3" value="option3">
                    <label for="radio3"> Inventário </label>
                </div>
                <div class="radio radio-success">
                    <input type="radio" name="dados" id="radio4" value="option4">
                    <label for="radio4"> Termo de responsabilidade </label>
                </div>
              </div>
            </div>
            <div class="form" id="option1" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.termoUso.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 justify-content-center mt-4">
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-excel pr-2"></i> 
                            <span>Gerar Excel</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-pdf pr-2"></i> 
                            <span>Gerar PDF</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="form" id="option2" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.termoUso.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 justify-content-center mt-4">
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-excel pr-2"></i> 
                            <span>Gerar Excel</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-pdf pr-2"></i> 
                            <span>Gerar PDF</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="form" id="option3" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.termoUso.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 px-0 mb-5">
                        <div class="col-12 mb-2">
                            <label class="col-form-label pb-0">Selecione os dados <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox1" type="checkbox">
                                <label for="checkbox1"> Equipamento </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox2" type="checkbox">
                                <label for="checkbox2"> Marca </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox3" type="checkbox">
                                <label for="checkbox3"> Modelo </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox4" type="checkbox">
                                <label for="checkbox4"> Sistema Operacional </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox5" type="checkbox">
                                <label for="checkbox5"> Tipo de licença </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox6" type="checkbox">
                                <label for="checkbox6"> Antivírus </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox7" type="checkbox">
                                <label for="checkbox7"> Nº série </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox8" type="checkbox">
                                <label for="checkbox8"> Nº patrimônio </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox9" type="checkbox">
                                <label for="checkbox9"> Service TAG </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox10" type="checkbox">
                                <label for="checkbox10"> Setor </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox12" type="checkbox">
                                <label for="checkbox12"> PA </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox13" type="checkbox">
                                <label for="checkbox13"> Usuário responsável </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox14" type="checkbox">
                                <label for="checkbox14"> Descrição </label>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 justify-content-center">
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-excel pr-2"></i> 
                            <span>Gerar Excel</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-pdf pr-2"></i> 
                            <span>Gerar PDF</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="form" id="option4" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.termoUso.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 px-0">
                        <div class="col-12 row">
                            <div class="col-lg-8 col-12">
                                <div class="form-group">
                                    <label class="col-form-label pb-0">Selecione o usuário <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-line" name="usuario" required>
                                        <option value="">Selecione</option>
                                        @foreach($usuarios as $usuario)
                                        <option value="{{$usuario->id}}">{{$usuario->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-12 row justify-content-center mt-4">
                            <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                                <i class="mdi mdi-file-pdf pr-2"></i> 
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
        $('input[name=dados]').on('change', function(e){
            $('.form').fadeOut();
            if(this.value != ''){
                $('#'+this.value).fadeIn();
            }
        });
    });
</script>
@endsection