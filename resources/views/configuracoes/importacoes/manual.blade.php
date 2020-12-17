@extends('layouts.index')

@section('title')
Importar
@endsection

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Importar</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('inicio')}}">Configurações</a></li>
                <li class="active">Importar</li>
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
            <form class="form-sample" enctype="multipart/form-data" autocomplete="off">
            @csrf
                <div class="col-12 text-left mb-5">
                    <p>Para importar os relatórios disponíveis você pode optar em fazer upload através da pasta compartilhada <small>( <a href="javascript:" id="automatico">Clicando aqui</a> )</small> ou pode inseri-los de maneira manual abaixo:</p>
                </div>
                <div class="col-12">
                    <ul class="nav nav-tabs customtab justify-content-center">
                        <li class="tab active"><a data-toggle="tab" href="#section-1" aria-expanded="false"> <span class="visible-xs"><i class="mdi mdi-clock"></i></span> <span class="hidden-xs">Diários</span> </a></li>
                        <li class="tab"><a data-toggle="tab" href="#section-2" aria-expanded="false"> <span class="visible-xs"><i class="mdi mdi mdi-calendar"></i></span> <span class="hidden-xs">Mensais</span> </a></li>
                        <li class="tab"><a data-toggle="tab" href="#section-3" aria-expanded="false"> <span class="visible-xs"><i class="mdi mdi-calendar-clock"></i></span> <span class="hidden-xs">Eventuais</span> </a></li>
                    </ul> 
                    <div class="tab-content text-center pb-0">
                        <div id="section-1" class="tab-pane active"> 
                            <ul class="row col-12 mx-auto p-0 text-left">
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cli_associados.xlsx</label>
                                            <input type="file" name="cli_associados" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_associados->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                   <div class="col-12 row mx-auto p-0">
                                    <div class="col-8 p-0">
                                        <label class="col-form-label mb-2 p-0">cli_consolidado.xlsx</label>
                                        <input type="file" name="cli_consolidado" accept=".xlsx">
                                    </div>
                                    <div class="col-4 p-0 m-auto text-right">
                                        <label class="mb-0 d-block">
                                            <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_consolidado->updated_at))) == 
                                                strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cli_emails.xlsx</label>
                                            <input type="file" name="cli_emails" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_emails->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cli_telefones.xlsx</label>
                                            <input type="file" name="cli_telefones" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_telefones->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cli_enderecos.xlsx</label>
                                            <input type="file" name="cli_enderecos" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_enderecos->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cli_conglomerados.xlsx</label>
                                            <input type="file" name="cli_conglomerados" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_conglomerados->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cca_contacapital.xlsx</label>
                                            <input type="file" name="cca_contacapital" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cca_contacapital->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cco_contacorrente.xlsx</label>
                                            <input type="file" name="cco_contacorrente" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cco_contacorrente->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cre_contratos_vigentes.xlsx</label>
                                            <input type="file" name="cre_contratos_vigentes" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_contratos->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cre_contratos_quitados.xlsx</label>
                                            <input type="file" name="cre_contratos_quitados" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_contratos->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">crt_cartaocredito.xlsx</label>
                                            <input type="file" name="crt_cartaocredito" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$crt_cartaocredito->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">dep_aplicacoes.xlsx</label>
                                            <input type="file" name="dep_aplicacoes" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$dep_aplicacoes->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">pop_poupanca.xlsx</label>
                                            <input type="file" name="pop_poupanca" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$pop_poupanca->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                            </ul>
                        </div>
                        <div id="section-2" class="tab-pane">
                            <ul class="row col-12 mx-auto p-0 text-left">
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cli_iap.xlsx</label>
                                            <input type="file" name="cli_iap" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_iap->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                   <div class="col-12 row mx-auto p-0">
                                    <div class="col-8 p-0">
                                        <label class="col-form-label mb-2 p-0">cli_bacen.xlsx</label>
                                        <input type="file" name="cli_bacen" accept=".xlsx">
                                    </div>
                                    <div class="col-4 p-0 m-auto text-right">
                                        <label class="mb-0 d-block">
                                            <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_bacen->updated_at))) == 
                                                strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cre_avalistas.xlsx</label>
                                            <input type="file" name="cre_avalistas" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_avalistas->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cre_garantias.xlsx</label>
                                            <input type="file" name="cre_garantias" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_garantias->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                            </ul>                        
                        </div>
                        <div id="section-3" class="tab-pane">
                            <ul class="row col-12 mx-auto p-0 text-left">
                                <li class="col-12">
                                    <div class="col-12 row mx-auto p-0">
                                        <div class="col-8 p-0">
                                            <label class="col-form-label mb-2 p-0">cre_contratos_historico.xlsx</label>
                                            <input type="file" name="cre_contratos_historico" accept=".xlsx">
                                        </div>
                                        <div class="col-4 p-0 m-auto text-right">
                                            <label class="mb-0 d-block">
                                                <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_contratos_historico->updated_at))) == 
                                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-bell mdi-24px text-success px-2"></i>' : '<i class="mdi mdi-bell mdi-24px text-danger px-2"></i>')!!}</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                            </ul> 
                        </div>
                    </div>
                </div>
                <div class="rodape col-12 row justify-content-center text-center p-0 mx-auto">
                    <div class="col-12 row">                  
                        <div class="col-8 p-0 ml-auto progress" style="height: 20px; display: none;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>       
                        <div class="col-2 text-left">      
                            <label class="percent" style="line-height: 20px; display: none;">0</label>
                        </div>
                    </div>
                    <div class="confirm col-12 text-center mb-3 font-weight-bold"></div>
                    <div class="row col-12 my-3 p-0 mx-auto text-center">
                        <button type="submit" class="btn btn-success btn-lg btn-outline col-lg-3 col-8 mx-auto">
                            <span>Enviar arquivos</span>
                        </button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
    $(document).ready( function (){
        var total = 0;
        var quantidade = 0;
        var bar = $('.bar');
        var progress = $('.progress');
        var percent = $('.percent');
        var mensagem = $('.confirm');

        // Importação automática
        $('#automatico').on('click', function(e){
            swal({
                title: "Tem certeza que deseja importar da pasta compartilhada?",
                icon: "warning",
                buttons: ["Cancelar", "Importar"],
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{{ route("importAuto.importacoes") }}',
                        type: 'GET',
                        beforeSend: function(){
                            $('.customtab').parent('div').animate({left: '100%'}).fadeOut();
                            $('.rodape button').parent('div').animate({left: '100%'}).fadeOut();
                            mensagem.append('<span class="text-warning"><div class="mr-3 spinner-border" style="width: 2.5rem; height: 2.5rem;" role="status"></div>Criando tarefas para importação.</span><br>');
                        },
                        success: function(data){
                            if(data.status == true){
                                swal("Tarefas criadas com sucesso.", {
                                    icon: "success",
                                });
                                mensagem.html('<span class="text-success"><i class="mdi mdi-check mdi-24px pr-3"></i>Tarefas criadas com sucesso.</span><br><a href="{{route("exibir.logs.importacoes")}}"></a>');
                            }else{
                                swal("Não possui arquivos para serem importados!", {
                                    icon: "error",
                                });
                                mensagem.html('<span class="text-danger">Erro ao criar uma das tarefas.</span>.<br>');
                            } 
                        }, 
                        error: function (data) {
                            mensagem.html('<span class="text-danger">Erro ao criar uma das tarefas.</span>.<br>');
                        }
                    });
                } else {
                    swal.close();
                }
            });
        });

        // Importação manual
        $('form').on('submit', function(e){
            e.preventDefault();    
            // Quantidade de inputs com valores
            $("form input[type=file]").each(function(dados, input) {
                if($('form input[name='+input.name+']').val()){
                    total++;
                }
            });
            //Habilitando as informações de progresso de importação
            if(total > 0){
                $("form button").animate({left: '100%'}).fadeOut('fast');
                mensagem.html('Enviando os relatórios...<br>');
                progress.fadeIn();
                percent.fadeIn(); 
                // Enviar arquivos para upload
                $("form input[type=file]").each(function(dados, input) {
                    if($('form input[name='+input.name+']').val()){
                        var form = new FormData();
                        form.append('_token', "{{csrf_token()}}");
                        form.append('myData', $('form input[name='+input.name+']')[0].files[0]);
                        form.append('relatorio', input.name);
                        $.ajax({
                            url: '{{ route("importManual.importacoes") }}',
                            type: 'POST',
                            data: form,
                            processData: false,
                            contentType: false,
                            beforeSend: function(){
                                $("form input").attr('disabled', 'disabled');
                                $(input).parents('li').find('i').removeAttr('class').html('<div class="spinner-border text-success" style="width: 2.5rem; height: 2.5rem;" role="status"></div>');
                            },
                            success: function(data){
                                quantidade++;
                                if(data.status == true){
                                    bar.width((quantidade*100)/total+'%');
                                    percent.html(Math.ceil((quantidade*100)/total));
                                    mensagem.append('<span class="text-success">Tarefa criada com sucesso: '+input.name+'</span>.<br>');
                                    $(input).parents('li').find('i').addClass('mdi mdi-check mdi-24px text-success px-2').html('');
                                }else{
                                    bar.addClass('bg-danger');
                                    mensagem.append('<span class="text-danger">Erro ao criar a tarefa do relatório: '+input.name+'</span>.<br>');
                                    $(input).parents('li').find('i').addClass('mdi mdi-close mdi-24px text-danger px-2').html('');
                                } 
                            }, 
                            error: function (data) {
                                bar.addClass('bg-danger');
                                mensagem.append('<span class="text-danger">Erro ao criar a tarefa do relatório: '+input.name+'</span>.<br>');
                                $(input).parents('li').find('i').addClass('mdi mdi-close mdi-24px text-danger px-2').html('');
                            }
                        });
                    }else{
                        $(input).parents('li').animate({left: '100%'}).fadeOut();
                    }
                });
            }else{
                mensagem.html('<span class="text-warning"><i class="mdi mdi-alert pr-2"></i>Nenhum relatório foi selecionado para ser enviado.</span>');
            }
        });
    });
</script>
@endsection