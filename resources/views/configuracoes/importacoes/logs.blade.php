@extends('layouts.index')

@section('title')
Logs de importação
@endsection

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Logs de importação</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('inicio')}}">Configurações</a></li>
                <li><a href="{{route('exibir.importacoes')}}">Importações</a></li></li>
                <li class="active">Logs</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($logs[0])
            <div class="row col-12 mb-3">
                <label class="col-2 font-weight-bold">Data de execução</label>
                <label class="col-10 font-weight-bold">Mensagem</label>
            </div>
                @foreach($logs as $log)
                <div class="row col-12">
                    <label class="col-2">{{date('d/m/Y H:i:s', strtotime($log->created_at))}}</label>
                    <label class="col-10">{!!$log->mensagem!!}</label>
                </div>
                @endforeach
                <div class="row col-12 mx-4 justify-content-end">
                    {{$logs->links()}}
                </div>
            @else
                <div class="row mx-auto">
                    <label class="alert alert-secondary col-12 rounded">Você não possui nenhum log de importação.</label>
                </div>
            @endif
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