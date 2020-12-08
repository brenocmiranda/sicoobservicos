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
            <label class="col-12 mb-5">Neste módulo você tem a possibilidade de efetuar a importação dos arquivos de maneira manual. Essa importação pode demorar alguns minutos até que seja concluída, aguarde até conclua a importação completa dos arquivos.</label>
            <form class="form-sample" id="form" action="{{route('executar.importacoes')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row col-12 mx-auto">
                    <div class="col-12">
                        <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_associados.xlsx</label>
                                <input type="file" name="cli_associados" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_associados->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_associados->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_consolidado.xlsx</label>
                                <input type="file" name="cli_consolidado" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_consolidado->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_consolidado->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                        <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_emails.xlsx</label>
                                <input type="file" name="cli_emails" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_emails->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_emails->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                        <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_telefones.xlsx</label>
                                <input type="file" name="cli_telefones" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_telefones->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_telefones->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_enderecos.xlsx</label>
                                <input type="file" name="cli_enderecos" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_enderecos->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_enderecos->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                     <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_conglomerados.xlsx</label>
                                <input type="file" name="cli_conglomerados" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_conglomerados->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_conglomerados->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                     <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_iap.xlsx</label>
                                <input type="file" name="cli_iap" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_iap->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_iap->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cli_bacen.xlsx</label>
                                <input type="file" name="cli_bacen" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_bacen->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cli_bacen->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cca_contacapital.xlsx</label>
                                <input type="file" name="cca_contacapital" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cca_contacapital->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cca_contacapital->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cco_contacorrente.xlsx</label>
                                <input type="file" name="cco_contacorrente" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cco_contacorrente->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cco_contacorrente->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cre_contratos.xlsx</label>
                                <input type="file" name="cre_contratos" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_contratos->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cre_contratos->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cre_contratos_mensal.xlsx</label>
                                <input type="file" name="cre_contratos_mensal" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_contratos->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cre_contratos->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cre_avalistas.xlsx</label>
                                <input type="file" name="cre_avalistas" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_avalistas->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cre_avalistas->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">cre_garantias.xlsx</label>
                                <input type="file" name="cre_garantias" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_garantias->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$cre_garantias->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">crt_cartaocredito.xlsx</label>
                                <input type="file" name="crt_cartaocredito" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$crt_cartaocredito->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$crt_cartaocredito->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">pop_poupanca.xlsx</label>
                                <input type="file" name="pop_poupanca" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$pop_poupanca->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$pop_poupanca->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <hr class="col-12 my-2">
                    <div class="col-12">
                         <div class="form-group col-12 row">
                            <div class="col-8 p-0">
                                <label class="col-form-label mb-2">dep_aplicacoes.xlsx</label>
                                <input type="file" name="dep_aplicacoes" accept=".xlsx">
                            </div>
                            <div class="col-4 p-0 m-auto text-right">
                                <label class="mb-0 d-block">
                                    <b>{!! ( strtotime(date('Y-m-d', strtotime(@$dep_aplicacoes->updated_at))) == 
                                    strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check mdi-24px text-success px-2"></i>'."Atualizado" : '<i class="mdi mdi-close mdi-24px text-danger px-2"></i>'."Desatualizado")!!}</b>
                                </label>
                                <small>{{date('d/m/Y H:i:s', strtotime(@$dep_aplicacoes->updated_at))}}</small>
                            </div>
                        </div>
                    </div>
                   
                    <hr class="col-12">
                    <div class="confirm col-12 text-center mb-3 font-weight-bold"></div>
                    <div class="col-8 p-0 ml-auto progress" style="height: 20px; display: none">
                      <div class="progress-bar progress-bar-striped progress-bar-animated bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <label class="col-2 percent" style="line-height: 20px; display: none;">0</label>
                    <div class="row col-12 justify-content-center mx-auto">
                        <button type="submit" class="btn btn-success btn-outline col-3 d-flex align-items-center justify-content-center mx-2">
                            <i class="mdi mdi-upload pr-2"></i> 
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
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">
    (function() {
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
    
    $("#form input[type=file]").on('change', function(){
        $('.confirm').html('');
        $('.progress').fadeOut();
        $('.percent').fadeOut();
    });

    $('#form').on('submit', function(e){
        $("#form input[type=file]").each(function(dados) {
            if($(this).val() != ''){
                $('#form').ajaxSubmit({
                    beforeSend: function() {
                        $('.progress-bar').removeClass('bg-success');
                        $('.progress-bar').removeClass('bg-danger');
                        $('.progress').fadeIn();
                        $('.percent').fadeIn();
                        status.empty();
                        var percentVal = '0';
                        var posterValue = $('input[name=file]').fieldValue();
                        bar.width(percentVal+'%')
                        percent.html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = '25';
                        bar.width(percentVal+'%')
                        percent.html(percentVal);
                        $('button[type=submit]').attr('disabled', 'disabled');
                        $('.confirm').html('Importando arquivos...');
                    },
                    success: function() {
                        $('.confirm').html('Aguarde, finalizando importação...');
                        var percentVal = '50';
                        bar.width(percentVal+'%')
                        percent.html(percentVal);
                    },
                    complete: function(xhr) {
                        //console.log(xhr.responseText);
                        if(xhr.responseText == "true"){
                            var percentVal = '100';
                            bar.width(percentVal+'%')
                            percent.html(percentVal);
                            $('.progress-bar').addClass('bg-success');
                            swal("Upload efetuado com sucesso!", {
                                icon: "success",
                            });
                            $('.confirm').html('');   
                            setTimeout( function(){
                                location.reload();
                            }, 1000);  
                        }else{
                            var percentVal = '25';
                            bar.width(percentVal+'%')
                            percent.html(percentVal);
                            $('.progress-bar').addClass('bg-danger');
                            $('button[type=submit]').removeAttr('disabled');
                            $('.confirm').html('Ocorreu um erro no processo de importação, tente novamente!');
                            swal("Ocorreu um erro no processo de importação, tente novamente!", {
                                icon: "error",
                            });
                        }
                    }
                });
                return false;
            }else if(dados == 13){
                swal("Nenhum arquivo selecionado para upload!", {
                    icon: "error",
                });
            }
        });
        e.preventDefault();
    });
     
    })();
</script>
@endsection