@section('title')
Editar equipamento
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">Editar informações</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Tecnologia</a></li>
        <li class="active"><a href="{{route('exibir.geral.equipamentos')}}">Inventário</a></li>
        <li class="active">Editar</li>
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
  
  <form class="form-sample" action="{{route('salvar.editar.equipamentos', $equipamentos->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="row">
      <div class="col-8">
        <div class="card">
          <div class="card-body">
            <div class="row mx-auto">
              <div class="col-10">
                <div class="form-group">
                  <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                  <div class="">
                    <input class="form-control form-control-line" name="nome" placeholder="Monitor 15.7" onkeyup="this.value = this.value.toUpperCase();" value="{{$equipamentos->nome}}" required/>
                  </div>
                </div>
              </div>
              <div class="row col-12">
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Marca <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="form-control form-control-line" name="marca" onkeyup="this.value = this.value.toUpperCase();" value="{{$equipamentos->marca}}" required/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Modelo <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="form-control form-control-line" name="modelo" onkeyup="this.value = this.value.toUpperCase();" value="{{$equipamentos->modelo}}" required/>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row col-12">
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nº patrimônio</label>
                    <div class="">
                      <input class="form-control form-control-line" name="n_patrimonio" onkeyup="this.value = this.value.toUpperCase();" value="{{$equipamentos->n_patrimonio}}"/>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nº série <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="form-control form-control-line" name="serialNumber" onkeyup="this.value = this.value.toUpperCase();" value="{{$equipamentos->serialNumber}}" required/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row col-12">
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Setor <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" name="id_setor" required>
                      <option value="">Selecione</option>
                      @foreach($setores as $setor)
                      <option value="{{$setor->id}}" {{($setor->id == $equipamentos->id_setor ? 'selected' : '')}}>{{$setor->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">PA <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" name="id_unidade" required>
                      <option value="">Selecione</option>
                      @foreach($unidades as $unidade)
                      <option value="{{$unidade->id}}" {{($unidade->id == $equipamentos->id_unidade ? 'selected' : '')}}>{{$unidade->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="form-group">
                  <label class="col-form-label pb-0">Usuário responsável</label>
                  <div class="">
                    <select class="form-control form-control-line" name="usuario" required>
                      <option value="">Selecione</option>
                      @foreach($usuarios as $usuario)
                      <option value="{{$usuario->id}}" {{($usuario->id == $equipamentos->RelationUsuario->last()->id ? 'selected' : '')}}>{{$usuario->RelationAssociado->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label pb-0">Descrição</label>
                  <div class="">
                    <textarea class="form-control form-control-line descricao" name="descricao" onkeyup="this.value = this.value.toUpperCase();" rows="3" placeholder="Digite suas observações">{{$equipamentos->descricao}}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label col-12 row mb-0">Imagem principal <span class="text-danger">*</span></label>
                  <small>Formatos de imagem aceitos: <b>.png</b>, <b>.jpg</b> ou <b>.svg</b></small>
                  <div class="row col-12 mt-3 mx-0 p-0">
                    <div class="border mx-2 rounded col-2 row p-0 mb-4" style="height: 8em;">
                      <img class="w-100 h-100 p-3" id="PreviewImage" src="{{(isset($equipamentos->RelationImagemPrincipal) ? asset('storage/app/'.$equipamentos->RelationImagemPrincipal->endereco) : asset('public/img/image.png'))}}">
                      <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" name="imagem_principal" accept="image/*" title="Selecione a imagem principal" onchange="image(this)">
                    </div>
                  </div> 
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label col-12 row mb-0">Selecione demais imagens</label>
                  <small>Formatos de imagem aceitos: <b>.png</b>, <b>.jpg</b> ou <b>.svg</b></small>
                  <div class="row col-12 mt-3 preview mx-0 p-0">
                    <div class="border mx-2 rounded col-2 row p-0 mb-4" style="height: 7em;">
                      <i class="mdi mdi-plus mdi-36px m-auto"></i>
                      <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" id="addFotoGaleria" accept="image/*" title="Selecione as imagens do problema" multiple>
                    </div>
                    @foreach($equipamentos->RelationImagem as $imagens)
                    <div class="border mx-2 mb-4 rounded col-2 d-flex p-0" id="PreviewImage{{$imagens->id}}"> 
                      <input type="hidden" name="imagens[]" value="{{$imagens->id}}"> 
                      <img class="p-3 w-100" src="{{asset('storage/app/').'/'.$imagens->endereco}}" style="height: 7em;">
                      <a href="javascript:void(0)" onclick="removeImagem('{{$imagens->id}}')" class="btn btn-light rounded-circle m-n3 border btn-xs" style="height: 26px;">x</a> 
                    </div>
                    @endforeach
                  </div> 
                </div>
              </div>
              <hr class="col-10 mt-0">
              <div class="row col-12 justify-content-center mx-auto">
                <a href="{{route('exibir.geral.equipamentos')}}" class="btn btn-danger btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
                  <i class="mdi mdi-arrow-left pr-2"></i> 
                  <span>Voltar</span>
                </a>
                <button type="submit" class="btn btn-success btn-outline col-4 d-flex align-items-center justify-content-center mx-2">
                  <i class="mdi mdi-check pr-2"></i> 
                  <span>Salvar</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card text-center">
          <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white font-weight-normal">Detalhes do equipamento</h5>
          </div>
          <div class="card-body">
            <div class="">
              <img src="{{(isset($equipamentos->RelationImagemPrincipal) ? asset('storage/app/'.$equipamentos->RelationImagemPrincipal->endereco) : asset('public/img/image.png'))}}" width="120" height="110" class="border p-1 rounded" id="ImagePrincipal">
            </div>
            <div class="d-block">
              <h5 class="d-block mb-0" id="nome">{{$equipamentos->nome}}</h5>
              <label class="d-block mb-0 mt-2">
                <span id="modelo">{{$equipamentos->modelo}}</span>
                &#183 
                <span id="marca">{{$equipamentos->marca}}</span>
              </label>
              <small class="d-block mt-2" id="n_patrimonio">{{$equipamentos->n_patrimonio}}</small>
              <hr class="mx-5">
              <label class="d-block mt-3 mb-0" id="usuario">{{$equipamentos->RelationUsuario->last()->RelationAssociado->nome}}</label>
              <label class="mt-2 d-block" id="id_setor">{{$equipamentos->RelationSetor->nome}}</label>
              <label class="badge badge-info" id="id_unidade">{{$equipamentos->RelationUnidade->nome}}</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection


@section('suporte')
<script type="text/javascript">
  function removeImagem(id){
    $('#PreviewImage'+id).remove();
  }

  $(document).ready( function (){
    // Atualizando detalhes do ativo
    $('form input[name="nome"]').on('keyup', function(){
      $('#nome').html($('input[name="nome"]').val());
    });
    $('form input[name="marca"]').on('keyup', function(){
      $('#marca').html($('input[name="marca"]').val());
    });
    $('form input[name="modelo"]').on('keyup', function(){
      $('#modelo').html($('input[name="modelo"]').val());
    });
    $('form input[name="n_patrimonio"]').on('keyup', function(){
      $('#n_patrimonio').html($('input[name="n_patrimonio"]').val());
    });
    $('form select[name="usuario"]').on('change', function(){
      $('#usuario').html($('select[name="usuario"] option:selected').text());
    });
    $('form select[name="id_setor"]').on('change', function(){
      $('#id_setor').html($('select[name="id_setor"] option:selected').text());
    });
    $('form select[name="id_unidade"]').on('change', function(){
      $('#id_unidade').html($('select[name="id_unidade"] option:selected').text());
    });
    
    $('input[name=imagem_principal]').on('change', function(){
      if(this.files && this.files[0]){
        var reader = new FileReader();
        reader.onload = function (oFREvent){
          $('#ImagePrincipal').attr('src', oFREvent.target.result);
        }
        reader.readAsDataURL(this.files[0]);
      }
    })
    
    // Pré-visualização de várias imagens no navegador
    $('#addFotoGaleria').on('change', function(event) {
      var formData = new FormData();
      formData.append('_token', '{{csrf_token()}}');

      if (this.files) {
        for (i = 0; i < this.files.length; i++) {
          formData.append('imagens[]', this.files[i]);
        }
        $.ajax({
          url: "{{ route('adicionar.imagens.equipamentos') }}",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(data){ 
            for (i = 0; i < data.length; i++) {
              $('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 d-flex p-0" id="PreviewImage'+data[i].id+'"> <input type="hidden" name="imagens[]" value="'+data[i].id+'"> <img class="p-3 w-100" src="{{asset("storage/app")}}/'+data[i].endereco+'" style="height: 7em;"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n3 border btn-xs" style="height: 26px;">x</a> </div>');
            } 
            $('#addFotoGaleria').val('');   
          }
        });
      }
    }); 
  });
</script>
@endsection