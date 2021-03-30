@section('title')
Detalhes do chamado
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">Detalhes do chamado</h4> 
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Suporte</a></li>
        <li class="active"><a href="{{route('exibir.chamados')}}">Chamados</a></li>
        <li class="active">Detalhes</li>
      </ol>
    </div>
  </div>

  <div class="confirm"></div>

  <div class="row" style="height: 600px !important;">
    <div class="col-lg-7 col-12 h-100">
      <div class="card h-100">
        <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
          <div class="my-4 px-2 row">
            <div class="d-flex">
              <h5 class="my-auto text-white font-weight-normal text-capitalize"><a href="{{route('exibir.chamados')}}"><i class="mdi mdi-arrow-left m-4 text-white"></i></a>CHAMADO #0{{$chamado->id}}</h5>
              <div class="badge mx-3 my-auto" style="background: {{$chamado->RelationStatus->first()->color}}">{{$chamado->RelationStatus->first()->nome}}</div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <h5 class="text-uppercase mb-2 text-truncate">
              <span>{{$chamado->RelationAmbientes->nome}}</span> 
              <b>&#183</b> 
              <span>{{$chamado->RelationFontes->nome}}</span>
            </h5>
          </div>

          <div class="col-12 mb-4">
            <label class="text-capitalize d-block text-primary">
              {{$chamado->RelationUsuario->RelationAssociado->nome}}
            </label>
          </div>

          <div class="col-12 mb-4">
            <label class="d-block">
              <b>Assunto</b> 
              <p>{{$chamado->assunto}}</p>
            </label>
            <label class="d-block">
              <b>Descrição</b> 
              <p>{{(isset($chamado->descricao) ? $chamado->descricao : '-')}}</p>
            </label>  
            <label class="d-block">
              <b>Data de abertura:</b> 
              <p>{{$chamado->created_at->format('d/m/Y H:i')}} - {{$chamado->created_at->subMinutes(2)->diffForHumans()}}</p>
            </label>
            @if($chamado->RelationStatus->first()->finish == 1)
            <label class="d-block">
              <b>Data de fechamento:</b> 
              <p>{{$chamado->RelationStatus->first()->pivot->created_at->format('d/m/Y H:i')}} - {{$chamado->RelationStatus->first()->pivot->created_at->subMinutes(2)->diffForHumans()}}</p>
            </label> 
            @endif
          </div>
          <div class="col-12 mb-5">
            <label class="d-inline-block">
              <b>Anexos do chamado</b>
            </label>
            <div>
              @if(!empty($chamado->RelationArquivos[0]))
                @foreach($chamado->RelationArquivos as $arquivos)
                  <div class="row mx-auto"> 
                  <a href="{{asset('storage/app/'.$arquivos->endereco)}}" target="_blank" class="row col-12">
                    <div class="px-2">
                      @if( explode(".", $arquivos->endereco)[1] == "docx" || explode(".", $arquivos->endereco)[1] == "doc")
                      <i class="mdi mdi-file-word mdi-dark mdi-18px m-auto"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "xls" || explode(".", $arquivos->endereco)[1] == "xlsx" || explode(".", $arquivos->endereco)[1] == "xlsm"
                      || explode(".", $arquivos->endereco)[1] == "csv")
                      <i class="mdi mdi-file-excel mdi-dark mdi-18px m-auto"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "pdf")
                      <i class="mdi mdi-file-pdf mdi-dark mdi-18px m-auto"></i>
                      @else
                      <i class="mdi mdi-file-document mdi-dark mdi-18px m-auto"></i>
                      @endif
                    </div>
                    <div class="my-auto">
                      <span class="text-truncate">{{str_replace('chamados/', '', $arquivos->endereco)}}</span>
                    </div>
                  </a>
                  </div>
                @endforeach
              @else
                <label>Não possui informações arquivadas.</label>
              @endif
            </div>
          </div>
          @if(date('d/m/Y H:i:s', strtotime($chamado->RelationStatus->first()->pivot->created_at)) < date('d/m/Y H:i:s', strtotime('-'.explode(':', $chamado->RelationStatus->first()->tempo)[0].' hours -'.explode(':', $chamado->RelationStatus->first()->tempo)[1].' minutes -'.explode(':', $chamado->RelationStatus->first()->tempo)[2].' seconds')) && ($chamado->RelationStatus->first()->finish == 1))
          <div class="col-12 mt-auto">
            <small class="text-danger">* Esse chamado não pode ser reaberto, pois excedeu a quantidade de tempo estabelescida para reabertura.</small>
          </div>
          @endif

          <div class="col-12 px-0 pt-0 footer" style="border-radius: 0.8rem;">
            <hr class="col-10">
            <div class="row justify-content-center">
              <div> 
                <a href="{{route('relatorio.chamados', $chamado->id)}}" target="_blank" class="btn btn-info btn-outline d-flex align-items-center justify-content-center mx-2">
                  <i class="mdi mdi-printer pr-2"></i> 
                  <span>Gerar Relatório</span>
                </a>
              </div>
              @if($chamado->RelationStatus->first()->finish != 1)
              <div>
                <a href="javascript:void()" id="{{$chamado->id}}" class="btn-finalizar btn btn-danger btn-outline d-flex align-items-center justify-content-center mx-2" data-toggle="modal" data-target="#modal-finalizar">
                  <i class="mdi mdi-close pr-2"></i> 
                  <span>Finalizar chamado</span>
                </a>
              </div>
              @elseif(date('d/m/Y H:i:s', strtotime($chamado->RelationStatus->first()->pivot->created_at)) > date('d/m/Y H:i:s', strtotime('-'.explode(':', $chamado->RelationStatus->first()->tempo)[0].' hours -'.explode(':', $chamado->RelationStatus->first()->tempo)[1].' minutes -'.explode(':', $chamado->RelationStatus->first()->tempo)[2].' seconds')))
              <div>
                <a href="javascript:void()" id="{{$chamado->id}}" class="btn-reabrir btn btn-success btn-outline d-flex align-items-center justify-content-center mx-2" data-toggle="modal" data-target="#modal-reabertura">
                  <i class="mdi mdi-check pr-2"></i> 
                  <span>Reabertura chamado</span>
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5 col-12 h-100 py-4 py-lg-0">
      <div class="card h-100">
        <div class="card-header {{($chamado->RelationStatus->first()->finish != 1 ? 'p-1' : '')}}" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
          <div class="m-4 row">
            <div class="d-flex">
              <h5 class="p-2 my-auto text-white font-weight-normal text-capitalize">Últimas atualizações</h5>
            </div>
          </div>
        </div>

        <div class="card-body" style="overflow-y: auto">
          @if($chamado->RelationStatus->first()->finish != 1)
          <div class="col-12 text-center">
            <a href="javascript:" title="Adicionar nova atualização" data-toggle="modal" data-target="#modal-alterar">
              <i class="mdi mdi-plus"></i>
              <span>Nova mensagem</span>
            </a>
          </div>
          @endif

          <ul class="p-0" id="statusNews">
            @foreach($historicoStatus as $status)
            <li class="m-3" id="status{{$status->id}}">
              <div class="badge" style="background: {{$status->RelationStatus->color}}">{{$status->RelationStatus->nome}}</div>
              <label class="col-12 pt-3 px-0">
                {{$status->descricao}}
              </label> 
              @if(!empty($status->RelationStatusArquivos[0]))
              <small class="font-weight-bold">Anexos:</small>
                @foreach($status->RelationStatusArquivos as $arquivos)
                  <div class="row mx-auto mb-3"> 
                  <a href="{{asset('storage/app/'.$arquivos->endereco)}}" target="_blank" class="row col-12">
                    <div class="pr-1">
                      @if( explode(".", $arquivos->endereco)[1] == "docx" || explode(".", $arquivos->endereco)[1] == "doc")
                      <i class="mdi mdi-file-word mdi-dark mdi-18px m-auto"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "xls" || explode(".", $arquivos->endereco)[1] == "xlsx" || explode(".", $arquivos->endereco)[1] == "xlsm"
                      || explode(".", $arquivos->endereco)[1] == "csv")
                      <i class="mdi mdi-file-excel mdi-dark mdi-18px m-auto"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "pdf")
                      <i class="mdi mdi-file-pdf mdi-dark mdi-18px m-auto"></i>
                      @else
                      <i class="mdi mdi-file-document mdi-dark mdi-18px m-auto"></i>
                      @endif
                    </div>
                    <div class="my-auto">
                      <small class="text-truncate">{{str_replace('chamados/', '', $arquivos->endereco)}}</small>
                    </div>
                  </a>
                  </div>
                  @endforeach
              @endif
              <small class="font-weight-normal">
                {!!(isset($status->RelationUsuarios) ? 'Alterado por: <b>'.$status->RelationUsuarios->RelationAssociado->nome.'</b>' : '')!!}
              </small>
              <div class="row mx-auto mt-2">
                <small class="p-0 font-weight-bold">
                  {{$status->created_at->format('d/m/Y H:i')}} -
                  {{$status->created_at->subMinutes(2)->diffForHumans()}}
                </small>
              </div>
              <hr>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>  
  </div>
</div>
@endsection

@section('modal')
  @include('suporte.chamados.status')
  @include('suporte.chamados.finalizar')
  @include('suporte.chamados.reabertura')
@endsection

@section('suporte')
<script type="text/javascript">
  function removeImagem(id){
    $.ajax({
      url: "../removeArquivoStatus/"+id,
      type: 'GET',
      success: function(data){ 
        $('#PreviewImage'+id).remove();
      }
    });
  }

  $(document).ready( function (){
    setInterval(function(){
      $.ajax({
        url: "{{route('monitorar.chamados.gti', [$chamado->id, $chamado->RelationStatus->first()->pivot->id])}}",
        type: 'GET',
        success: function(data){
          if(data[0]){
            $('.confirm').html('<div class="row mx-auto text-center"><a href="javascript:void(0)" onclick="location.reload()" class="col-12 alert alert-warning"> Você possui novas atualizações. Clique aqui e atualize!</a></div>');
          }
        }
      });
    }, 5000);

    // Pré-visualização de várias imagens no navegador
    $('#addArquivo').on('change', function(event) {
      var formData = new FormData();
      formData.append('_token', '{{csrf_token()}}');

      if (this.files) {
        for (i = 0; i < this.files.length; i++) {
          formData.append('arquivos[]', this.files[i]);
        }
        $.ajax({
          url: "{{ route('adicionar.arquivos.chamados.status') }}",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(data){ 
            for (i = 0; i < data.length; i++) {
              $('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 p-0 row text-center" id="PreviewImage'+data[i].id+'" style="height:7em"> <input type="hidden" name="arquivos[]" value="'+data[i].id+'"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="height: 26px; width: 26px; z-index:10">x</a>'+(data[i].endereco.split('.')[1] == 'docx' || data[i].endereco.split('.')[1] == 'doc' ? '<i class="mdi mdi-file-word mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'xls' || data[i].endereco.split('.')[1] == 'xlsx' || data[i].endereco.split('.')[1] == 'xlsm' || data[i].endereco.split('.')[1] == 'csv' ? '<i class="mdi mdi-file-excel mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'pdf' ? '<i class="mdi mdi-file-pdf mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : '<i class="mdi mdi-file-document mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>')))+'</div>');
            } 
            $('#addArquivo').val('');   
          }
        });
      }
    });

    // Pré-visualização de várias imagens no navegador
    $('#addArquivoFinalizar').on('change', function(event) {
      var formData = new FormData();
      formData.append('_token', '{{csrf_token()}}');

      if (this.files) {
        for (i = 0; i < this.files.length; i++) {
          formData.append('arquivos[]', this.files[i]);
        }
        $.ajax({
          url: "{{ route('adicionar.arquivos.chamados.status.gti') }}",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(data){ 
            for (i = 0; i < data.length; i++) {
              $('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 p-0 row text-center" id="PreviewImage'+data[i].id+'" style="height:7em"> <input type="hidden" name="arquivos[]" value="'+data[i].id+'"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="height: 26px; width: 26px; z-index:10">x</a>'+(data[i].endereco.split('.')[1] == 'docx' || data[i].endereco.split('.')[1] == 'doc' ? '<i class="mdi mdi-file-word mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'xls' || data[i].endereco.split('.')[1] == 'xlsx' || data[i].endereco.split('.')[1] == 'xlsm' || data[i].endereco.split('.')[1] == 'csv' ? '<i class="mdi mdi-file-excel mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'pdf' ? '<i class="mdi mdi-file-pdf mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>' : '<i class="mdi mdi-file-document mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate" title="'+data[i].endereco.replace('chamados/', '')+'">'+data[i].endereco.replace('chamados/', '')+'</span>')))+'</div>');
            } 
            $('#addArquivo').val('');   
          }
        });
      }
    });

    $('#modal-finalizar #formFinalizar').on('submit', function(e){
      // Finalizar chamado
      e.preventDefault();
      $.ajax({
        url: "{{route('finalizar.chamados', $chamado->id)}}",
        type: 'POST',
        data: $('#modal-finalizar #formFinalizar').serialize(),
        beforeSend: function(){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
          $('#modal-finalizar #err').html('');
        },
        success: function(data){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
          setTimeout(function(){
            location.reload();
          }, 1000);
        }, error: function (data) {
          setTimeout(function(){
            $('.modal-body, .modal-footer').removeClass('d-none');
            $('.carregamento').html('');
            if(!data.responseJSON){
              console.log(data.responseText);
              $('#modal-finalizar #err').html(data.responseText);
            }else{
              $('#modal-finalizar #err').html('');
              $('input').removeClass('border-bottom border-danger');
              $.each(data.responseJSON.errors, function(key, value){
                $('#modal-finalizar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
                $('input[name="'+key+'"]').addClass('border-bottom border-danger');
              });
            }
          }, 2000);
        }
      });
    });
    $('#modal-reabertura #formReabertura').on('submit', function(e){
      // Finalizar chamado
      e.preventDefault();
      $.ajax({
        url: "{{route('reabertura.chamados', $chamado->id)}}",
        type: 'POST',
        data: $('#modal-reabertura #formReabertura').serialize(),
        beforeSend: function(){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
          $('#modal-reabertura #err').html('');
        },
        success: function(data){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
          setTimeout(function(){
            location.reload();
          }, 1000);
        }, error: function (data) {
          setTimeout(function(){
            $('.modal-body, .modal-footer').removeClass('d-none');
            $('.carregamento').html('');
            if(!data.responseJSON){
              console.log(data.responseText);
              $('#modal-reabertura #err').html(data.responseText);
            }else{
              $('#modal-reabertura #err').html('');
              $('input').removeClass('border-bottom border-danger');
              $.each(data.responseJSON.errors, function(key, value){
                $('#modal-reabertura #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
                $('input[name="'+key+'"]').addClass('border-bottom border-danger');
              });
            }
          }, 2000);
        }
      });
    });
    $('#modal-alterar #formAlterar').on('submit', function(e){
      // Alterar as informações
      e.preventDefault();
      $.ajax({
        url: "{{route('status.chamados', $chamado->id)}}",
        type: 'POST',
        data: $('#modal-alterar #formAlterar').serialize(),
        beforeSend: function(){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
          $('#modal-alterar #err').html('');
        },
        success: function(data){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
          setTimeout(function(){
            location.reload();
          }, 1000);
        }, error: function (data) {
          setTimeout(function(){
            $('.modal-body, .modal-footer').removeClass('d-none');
            $('.carregamento').html('');
            if(!data.responseJSON){
              console.log(data.responseText);
              $('#modal-alterar #err').html(data.responseText);
            }else{
              $('#modal-alterar #err').html('');
              $('input').removeClass('border-bottom border-danger');
              $.each(data.responseJSON.errors, function(key, value){
                $('#modal-alterar #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
                $('input[name="'+key+'"]').addClass('border-bottom border-danger');
              });
            }
          }, 2000);
        }
      });
    });
 });
</script>
@endsection