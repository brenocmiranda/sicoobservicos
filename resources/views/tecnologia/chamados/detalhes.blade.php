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
        <li><a href="javascript:void(0)">GTI</a></li>
        <li class="active"><a href="{{route('exibir.chamados.gti')}}">Solicitações</a></li>
        <li class="active">Detalhes</li>
      </ol>
    </div>
  </div>

  <div class="confim row col-12 p-0 mx-auto">
    @if($errors->any())
    <div class="col-sm-12 alert alert-danger font-weight-normal">
      @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
      @endforeach
    </div>
    @endif
  </div>

  <div class="row" style="height: 600px !important;">
    <div class="col-7 h-100">
      <div class="card h-100">
        <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
          <div class="my-4 px-2 row">
            <div class="d-flex">
              <h5 class="my-auto text-white font-weight-normal text-capitalize"><a href="{{route('exibir.chamados.gti')}}"><i class="mdi mdi-arrow-left m-4 text-white"></i></a>CHAMADO #0{{$chamado->id}}</h5>
              <div class="badge mx-3 my-auto" style="background: {{$chamado->RelationStatus->first()->color}}">{{$chamado->RelationStatus->first()->nome}}</div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <h5 class="text-uppercase mb-2 text-truncate">
              <span>{{$chamado->RelationFontes->nome}}</span> 
              <b>&#183</b> 
              <span>{{$chamado->RelationTipos->nome}}</span>
            </h5>
          </div>

          <div class="col-12 mb-4">
            <label class="text-capitalize d-block text-primary">
              {{$chamado->RelationUsuario->RelationAssociado->nome}}
            </label>
          </div>

          <div class="">
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
                <p>{{$chamado->created_at->format('d/m/Y H:i')}}</p>
              </label>
              @if($chamado->RelationStatus->first()->finish == 1)
              <label class="d-block">
                <b>Data de fechamento:</b> 
                <p>{{$chamado->RelationStatus->first()->pivot->created_at->format('d/m/Y H:i')}}</p>
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
          </div>

          <div class="col-12 px-0 pt-0 footer" style="border-radius: 0.8rem;">
            <hr class="col-10">
            <div class="row justify-content-center">
              <div> 
                <a href="{{route('relatorio.chamados.gti', $chamado->id)}}" target="_blank" class="btn btn-info btn-outline d-flex align-items-center justify-content-center mx-2">
                  <i class="mdi mdi-printer pr-2"></i> 
                  <span>Gerar Relatório</span>
                </a>
              </div>
              @if($chamado->RelationStatus->first()->finish != 1)
              <div>
                <a href="javascript:void()" class="btn btn-danger btn-outline d-flex align-items-center justify-content-center mx-2" data-toggle="modal" data-target="#modal-finalizar">
                  <i class="mdi mdi-close pr-2"></i> 
                  <span>Finalizar chamado</span>
                </a>
              </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-5 h-100">
      <div class="card h-100">
        <div class="card-header {{($chamado->RelationStatus->first()->finish != 1 ? 'p-1' : '')}}" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
          <div class="m-4 row">
            <div class="d-flex">
              <h5 class="my-auto text-white font-weight-normal text-capitalize">Últimas atualizações</h5>
            </div>
            @if($chamado->RelationStatus->first()->finish != 1)
            <button class="btn btn-light btn-xs ml-auto" title="Alterar status" data-toggle="modal" data-target="#modal-alterar">
              <i class="mdi mdi-cached"></i>
              <small>Alterar status</small>
            </button>
            @endif
          </div>
        </div>
        <div class="card-body" style="overflow-y: auto">
          <ul class="p-0" id="statusNews">
            @foreach($historicoStatus as $status)
            <li class="m-3" id="status{{$status->id}}">
              <div class="badge" style="background: {{$status->RelationStatus->color}}">{{$status->RelationStatus->nome}}</div>
              <label class="col-12 pt-3 px-0">
                {{$status->descricao}}
              </label>
              <small class="font-weight-normal">
                {!!(isset($status->RelationUsuarios) ? 'Alterado por: <b>'.$status->RelationUsuarios->RelationAssociado->nome.'</b>' : '')!!}
              </small>
              <div class="row mx-auto mt-2">
                <small class="p-0 font-weight-bold">
                  {{$status->created_at->format('d/m/Y H:i')}} -
                  {{$status->created_at->subMinutes(2)->diffForHumans()}}
                </small>
                @if($chamado->RelationStatus->last()->id != $status->id)
                <a href="javascript::void(0)" id="{{$status->id}}" class="status-remove ml-auto">
                  <i class="fa fa-close"></i>
                  <small>Excluir</small>
                </a>
                @endif
                <a href="javascript::void(0)" id="{{$status->id}}" class="status-editar {{($chamado->RelationStatus->last()->id == $status->id ? ' ml-auto' : '')}} pl-3">
                  <i class="fa fa-pencil-square-o"></i>
                  <small>Editar</small>
                </a>
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
  @include('tecnologia.chamados.status')
  @include('tecnologia.chamados.finalizar')
  @include('tecnologia.chamados.descricaostatus')
@endsection

@section('suporte')
<script type="text/javascript">
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


   $('.status-remove').on('click', function(e){
    // Removendo status do chamado
    var id = this.id;
    swal({
      title: "Tem certeza que deseja remover o status?",
      text: "Essa remoção irá impactar nas informações visualizadas pelos colaboradores.",
      icon: "warning",
      buttons: ["Cancelar", "Confirmar"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.get("{{url('app/gti/chamados/remove')}}/"+id, function(data){
          if(data.success == true){
            swal("Status removido com sucesso!", {
              icon: "success",
              button: false
            });
            location.reload();
          }else{
            swal("Não foi possível remover o status!", {
              icon: "error",
            });
          }
        });
      } else {
        swal.close();
      }
    });
  });

   $('.status-editar').on('click', function(e){
      // Alterando descrição do status
      var id = this.id;
      $.get("{{url('app/gti/chamados/info')}}/"+id, function(data){
        $('#modal-descricao .identificador').val(data.id);
        $('#modal-descricao .descricao').val(data.descricao);
        $('#modal-descricao').modal('show');
      })
    });

   $('#modal-descricao #formDescricao').on('submit', function(e){
      // Finalizar chamado
      e.preventDefault();
      $.ajax({
        url: "{{route('descricao.chamados.gti')}}",
        type: 'POST',
        data: $('#modal-descricao #formDescricao').serialize(),
        beforeSend: function(){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"> <div class="col-12"> <div class="spinner-border my-4" role="status"> <span class="sr-only"> Loading... </span> </div> </div> <label>Salvando informações...</label></div>');
          $('#modal-descricao #err').html('');
        },
        success: function(data){
          $('.modal-body, .modal-footer').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-12"><i class="col-2 mdi mdi-check-all mdi-48px"></i></div><label>Informações alteradas com sucesso!</label></div>');
          $('#statusNews #status'+data.id+' label').html(data.descricao);
          setTimeout(function(){
            $('input').removeClass('border-bottom border-danger');
            $('.carregamento').html('');
            $('.modal-body, .modal-footer').removeClass('d-none');
            $('#modal-descricao').modal('hide');
          }, 1000)
        }, error: function (data) {
          setTimeout(function(){
            $('.modal-body, .modal-footer').removeClass('d-none');
            $('.carregamento').html('');
            if(!data.responseJSON){
              console.log(data.responseText);
              $('#modal-descricao #err').html(data.responseText);
            }else{
              $('#modal-descricao #err').html('');
              $('input').removeClass('border-bottom border-danger');
              $.each(data.responseJSON.errors, function(key, value){
                $('#modal-descricao #err').append('<div class="text-danger mx-4"><p>'+value+'</p></div>');
                $('input[name="'+key+'"]').addClass('border-bottom border-danger');
              });
            }
          }, 2000);
        }
      });
    });
   $('#modal-finalizar #formFinalizar').on('submit', function(e){
      // Finalizar chamado
      e.preventDefault();
      $.ajax({
        url: "{{route('finalizar.chamados.gti', $chamado->id)}}",
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
   $('#modal-alterar #formAlterar').on('submit', function(e){
      // Alterar as informações
      e.preventDefault();
      $.ajax({
        url: "{{route('status.chamados.gti', $chamado->id)}}",
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