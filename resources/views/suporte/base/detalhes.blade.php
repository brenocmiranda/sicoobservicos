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
        <li><a href="{{route('exibir.base')}}">Aprendizagem</a></li>
        <li class="active">Detalhes</li>
      </ol>
    </div>
  </div>

  <div class="confim row col-12 p-0 mx-auto">
    @if($errors->any())
    <div class="col-12 alert alert-danger font-weight-normal">
      @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
      @endforeach
    </div>
    @endif
  </div>

  <div class="row">
    <div class="col-lg-8 col-12 order-2 order-lg-1">
      <div class="card">
        <div class="card-body">
          <div class="row col-12 mx-auto pb-3">
            <div class="mr-auto">
              <a href="{{route('exibir.base')}}" class="btn btn-danger btn-outline btn-xs px-3">
                <i class="mdi mdi-arrow-left"></i>
                <span>Voltar</span>
              </a>
            </div>
            @if(Auth::user()->RelationFuncao->gerenciar_gti)
            <div class="ml-auto">
              <a href="{{route('editar.base.aprendizagem', $dados->id)}}" class="btn btn-default btn-outline btn-xs px-3 mx-1">
                <i class="mdi mdi-pencil"></i>
                <small class="hidden-xs">Editar</small>
              </a>
              <a href="javascript:void(0)" data="{{route('delete.base.aprendizagem', $dados->id)}}" class="btn-delete btn btn-default btn-outline btn-xs px-3">
                <i class="mdi mdi-close"></i>
                <small class="hidden-xs">Remover</small>
              </a>
            </div>
            @endif
          </div>
          <div class="col-12 text-justify">
            <div>
              <h4>{{$dados->titulo}}</h4>
              <h5>{{$dados->RelationFontes->nome}} &#183 {{$dados->RelationTipos->nome}}</h5>
              <label>{{$dados->subtitulo}}</label> 
              @foreach($dados->RelationArquivos as $arquivos)
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
                    <span class="text-truncate">{{str_replace('base/', '', $arquivos->endereco)}}</span>
                  </div>
                </a>
                </div>
                @endforeach
              <hr>
              <p class="w-100"><?php echo $dados->descricao; ?></p>
              <hr>
              <small><b>Data de criação:</b> {{$dados->created_at->format('d/m/Y H:i:s')}}</small>
              <br> 
              <small><b>Data de atualização:</b> {{$dados->updated_at->format('d/m/Y H:i:s')}}</small> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-12 mb-4 mt-lg-0 order-1 order-lg-2">
      <h5 class="text-center">Outros tópicos relacionados</h5>
      <hr class="mt-2">
      <div id="info-base">
      @if(!empty($topicos[0]))
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
        @else
          <label class="text-muted text-center">Nenhum tópico relacionado a esse iten. Fique atento, logo estaremos disponibilizando novidades!</label>
        @endif
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