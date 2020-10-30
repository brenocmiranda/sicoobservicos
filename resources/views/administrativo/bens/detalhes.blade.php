@section('title')
Detalhes do bem
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">Detalhes do bem</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="{{route('dashboard.administrativo')}}">Administrativo</a></li>
        <li><a href="{{route('exibir.bens.administrativo')}}">Bens</a></li>
        <li class="active">Detalhes</li>
      </ol>
    </div>
  </div>
  
    <div class="row mb-5">
      <div class="col-12">
          <div class="row mx-auto">
              <div class="col-6">
                <div class="card">
                  <div class="card-body">
                    <div class="panel panel-default">
                        <div class="panel-wrapper collapse in">
                            <div id="owl-demo" class="owl-carousel owl-theme">
                              <div class="item active"> 
                                <img src="{{asset('storage/app').'/'.$bens->RelationImagemPrincipal->endereco}}" alt="Imagem Principal" class="rounded" style="height: 400px">
                              </div>
                              @foreach($bens->RelationImagem as $imagem)
                              <div class="item"> 
                                <img src="{{asset('storage/app').'/'.$imagem->endereco}}" class="rounded" style="height: 400px">
                              </div>
                              @endforeach
                              </div>
                        </div>
                    </div>                  
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h3>{{$bens->nome}} <small>{{($bens->tipo == 'movel' ? "Móvel" : "Imóvel")}}</small></h3>
                    <hr class="mt-2">
                    <div class="pb-2" style="line-height: 15px">
                      <h5>Descrição:</h5>
                      <p>{!! $bens->descricao !!}</p>
                    </div>
                    @if(isset($bens->cep))
                    <div class="py-2" style="line-height: 15px">
                      <h5>Localização:</h5>
                      <label class="text-dark d-block">{{(isset($bens->rua) ? $bens->rua.',' : '')}} {{$bens->numero}}, {{$bens->bairro}}</label>
                      <label class="text-dark d-block">{{$bens->cep}} - {{$bens->cidade}}/{{$bens->estado}}</label>
                    </div>
                    @endif
                    <div>
                      <h2 class="py-4">R$ {{number_format($bens->valor,2,",",".")}}</h2> 
                    </div>
                    
                    <div class="row col-12 justify-content-center m-auto footer" style="border-bottom-right-radius: 0.6em; border-bottom-left-radius: 0.6em;">
                      <hr class="col-12 p-0">
                      <a href="{{route('exibir.bens.administrativo')}}" class="btn btn-danger btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
                        <i class="mdi mdi-arrow-left pr-2"></i> 
                        <span>Voltar</span>
                      </a>
                      @if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
                      <a href="{{route('editar.bens.administrativo', $bens->id)}}" class="btn btn-success btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
                        <i class="mdi mdi-pencil pr-2"></i>
                        <span>Editar</span>
                      </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
          </div>
       </div>
    </div>
</div>
@endsection


@section('suporte')
<script type="text/javascript">
  function removeImagem(id){
    $.ajax({
      url: "../removeArquivo/"+id,
      type: 'GET',
      success: function(data){ 
        $('#PreviewImage'+id).remove();
      }
    });
  }
  $(document).ready( function (){
    $('.summernote').summernote({
        height: 350, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });

  });
</script>
@endsection