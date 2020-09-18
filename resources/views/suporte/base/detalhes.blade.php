@section('title')
{{$dados->titulo}}
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">Detalhes do tópico</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Suporte</a></li>
        <li><a href="{{route('exibir.base')}}">Base de conhecimento</a></li>
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

  <div class="row">
    <div class="col-8">
      <div class="card">
        <div class="card-body">
          <div class="row col-12 mx-auto pb-3">
            <div class="mr-auto">
              <a href="javascript:history.back()">
                <i class="mdi mdi-arrow-left"></i>
                <span>Voltar</span>
              </a>
            </div>
            @if(Auth::user()->RelationFuncao->gerenciar_suporte)
            <div class="ml-auto">
              <a href="{{route('editar.base.suporte', $dados->id)}}" class="btn btn-default btn-rounded btn-outline btn-xs px-3 mx-1">
                <i class="mdi mdi-pencil"></i>
                <small>Editar</small>
              </a>
              <a href="javascript:void(0)" data="{{route('delete.base.suporte', $dados->id)}}" class="btn-delete btn btn-default btn-rounded btn-outline btn-xs px-3">
                <i class="mdi mdi-close"></i>
                <small>Deletar</small>
              </a>
            </div>
            @endif
          </div>
          <div class="col-12 text-justify">
            <div>
              <h4>{{$dados->titulo}}</h4>
              <h5>{{$dados->RelationFontes->nome}} &#183 {{$dados->RelationTipos->nome}}</h5>
              <label>{{$dados->subtitulo}}</label> 
              <hr>
              <p><?php echo $dados->descricao; ?></p>
              <hr>
              <small><b>Data de criação:</b> {{$dados->created_at->format('d/m/Y H:i:s')}}</small>
              <br> 
              <small><b>Data de atualização:</b> {{$dados->updated_at->format('d/m/Y H:i:s')}}</small> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
        <h5 class="text-center">Outros tópicos relacionados</h5>
        <hr class="mt-2">
        <div id="info-base">
          @foreach($topicos as $topico)
          <label class="text-muted text-left">
            <div class="panel panel-default border shadow-sm">
              <div class="panel-heading py-4">
                <a href="{{route('detalhes.base', $topico->id)}}">{{$topico->titulo}}</a>
              </div>
              <div class="panel-wrapper collapse in">
                <div class="panel-body py-3"> 
                  <p>{{$topico->subtitulo}}</p>
                </div>
              </div>
            </div>
          </label>
          @endforeach
        </div>
      </div>  
  </div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
  $(document).ready( function (){
    $('.btn-delete').on('click', function(e){
      // Alterando status
      e.preventDefault();
      var url = $(this).attr('data');
      swal({
        title: "Tem certeza que deseja remover esse tópico?",
        icon: "warning",
        buttons: ["Cancelar", "Deletar"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.get(url, function(data){
            if(data.success == true){
              swal("Tópico removido com sucesso!", {
                icon: "success",
                button: false
              });
              window.location.href = "{{route('exibir.base')}}";
            }else{
              swal("Não foi possível remover as informações.", {
                icon: "error",
              });
            }
          });
        } else {
          swal.close();
        }
      });
    }); 
  });
</script>
@endsection