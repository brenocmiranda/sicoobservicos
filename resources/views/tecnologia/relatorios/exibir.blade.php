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
                <label class="col-form-label pb-1">Tipos de relatórios <span class="text-danger">*</span></label>
                <div class="row mx-auto align-items-baseline">
                    <div class="radio radio-success mr-3">
                        <input type="radio" name="dados" id="radio1" value="option1">
                        <label for="radio1"> Atalhos </label>
                    </div>
                    <div class="radio radio-success mx-3">
                        <input type="radio" name="dados" id="radio2" value="option2">
                        <label for="radio2"> Chamados </label>
                    </div>
                    <div class="radio radio-success mx-3">
                        <input type="radio" name="dados" id="radio3" value="option3">
                        <label for="radio3"> Inventário </label>
                    </div>
                    <div class="radio radio-success mx-3">
                        <input type="radio" name="dados" id="radio4" value="option4">
                        <label for="radio4"> Termo de responsabilidade </label>
                    </div>
                </div>
              </div>
            </div>
            <div class="form" id="option1" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.atalhos.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 px-0">
                        <div class="col-12">
                            <label class="col-form-label pb-1">Selecione os dados <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox1" type="checkbox" name="titulo" value="titulo">
                                <label for="checkbox1"> Título </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox2" type="checkbox" name="subtitulo" value="subtitulo">
                                <label for="checkbox2"> Subtítulo </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox3" type="checkbox" name="endereco" value="endereco">
                                <label for="checkbox3"> Endereço </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox4" type="checkbox" name="icone" value="icone">
                                <label for="checkbox4"> Ícone </label>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 justify-content-center mt-4">
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-pdf pr-2"></i> 
                            <span>Gerar PDF</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="form" id="option2" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.chamados.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 px-0 mb-5">
                        <div class="col-12">
                            <label class="col-form-label pb-1">Selecione os dados <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox1" type="checkbox">
                                <label for="checkbox1"> Ambiente </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox4" type="checkbox">
                                <label for="checkbox4"> Assunto </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox5" type="checkbox">
                                <label for="checkbox5"> Descrição </label>
                            </div>                        
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox2" type="checkbox">
                                <label for="checkbox2"> Fontes </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox3" type="checkbox">
                                <label for="checkbox3"> ID TeamViewer </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox6" type="checkbox">
                                <label for="checkbox6"> Último status </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox7" type="checkbox">
                                <label for="checkbox7"> Usuário </label>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 justify-content-center">
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2">
                            <i class="mdi mdi-file-pdf pr-2"></i> 
                            <span>Gerar PDF</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="form" id="option3" style="display:none;">
                <form class="form-sample row col-12 mx-auto" target="_blank" action="{{route('relatorio.equipamentos.tecnologia')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row col-12 px-0 mb-4">
                        <div class="col-12">
                            <label class="col-form-label pb-1">Selecione os dados <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox101" type="checkbox" name="antivirus" value="antivirus">
                                <label for="checkbox101"> Antivírus </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox102" type="checkbox" name="descricao" value="descricao">
                                <label for="checkbox102"> Descrição </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox103" type="checkbox" name="id_equipamento" value="id_equipamento">
                                <label for="checkbox103"> Equipamento </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox104" type="checkbox" name="id_imagem" value="id_imagem">
                                <label for="checkbox104"> Imagem principal </label>
                            </div>
                             <div class="checkbox checkbox-success">
                                <input id="checkbox105" type="checkbox" name="id_marca" value="id_marca">
                                <label for="checkbox105"> Marca </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox106" type="checkbox" name="modelo" value="modelo">
                                <label for="checkbox106"> Modelo </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox107" type="checkbox" name="serialNumber" value="serialNumber">
                                <label for="checkbox107"> Nº série </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox108" type="checkbox" name="n_patrimonio" value="n_patrimonio" >
                                <label for="checkbox108"> Nº patrimônio </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox109" type="checkbox" name="id_unidade" value="id_unidade">
                                <label for="checkbox109"> PA </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox110" type="checkbox" name="serviceTag" value="serviceTag">
                                <label for="checkbox110"> Service TAG </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox111" type="checkbox" name="id_setor" value="id_setor">
                                <label for="checkbox111"> Setor </label>
                            </div>
                             <div class="checkbox checkbox-success">
                                <input id="checkbox112" type="checkbox" name="sistema_operacional" value="sistema_operacional">
                                <label for="checkbox112"> Sistema Operacional </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox113" type="checkbox" name="tipo_licenca" value="tipo_licenca">
                                <label for="checkbox113"> Tipo de licença </label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox114" type="checkbox" name="id_usuario" value="id_usuario">
                                <label for="checkbox114"> Usuário responsável </label>
                            </div>                            
                            <div class="checkbox checkbox-success">
                                <input id="checkbox115" type="checkbox" name="id_imagem_outras" value="id_imagem_outras">
                                <label for="checkbox115"> Outras imagens </label>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 px-0 mb-5">
                        <div class="col-12 mb-2">
                            <label class="col-form-label pb-0">Filtros</label>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label class="pb-0">Selecione o PA</label>
                                <select class="form-control form-control-line" name="unidade">
                                    <option value="">Selecione</option>
                                    @foreach($unidades as $unidade)
                                    <option value="{{$unidade->id}}">{{$unidade->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 justify-content-center">
                        <button type="submit" class="btn btn-success btn-outline col-lg-3 mx-2" name="type" value="pdf">
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
                                    <label class="col-form-label pb-1">Selecione o usuário <span class="text-danger">*</span></label>
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