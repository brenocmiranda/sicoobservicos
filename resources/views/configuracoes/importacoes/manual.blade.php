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
                                <label>Última atualização: <b>{{date('d/m/Y', strtotime(@$dBaseAssociado->updated_at))}}</b></label>
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
                                <label>Última atualização: <b>{{date('d/m/Y', strtotime(@$dBaseEmails->updated_at))}}</b></label>
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
                                <label>Última atualização: <b>{{date('d/m/Y', strtotime(@$dBaseTelefones->updated_at))}}</b></label>
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
                                <label>Última atualização: <b>{{date('d/m/Y', strtotime(@$dBaseEnderecos->updated_at))}}</b></label>
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
 
    $('#form').ajaxForm({
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
            console.log(xhr.responseText);
            if(xhr.responseText == "true"){
                var percentVal = '100';
                bar.width(percentVal+'%')
                percent.html(percentVal);
                $('.progress-bar').addClass('bg-success');
                $('.confirm').html('Upload efetuado com sucesso!');   
                setTimeout( function(){
                    location.reload();
                }, 1000);  
            }else{
                var percentVal = '25';
                bar.width(percentVal+'%')
                percent.html(percentVal);
                $('.progress-bar').addClass('bg-danger');
                $('button[type=submit]').removeAttr('disabled');
                $('.confirm').html('Ops! Ocorreu um erro no processo de importação, verifique se os arquivos foram selecionados para upload!');
            }
        }
    });
     
    })();
</script>
@endsection