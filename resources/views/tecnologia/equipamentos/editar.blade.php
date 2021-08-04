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
  
  <form class="form-sample" action="{{route('salvar.editar.equipamentos', $ativo->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="row">
      <div class="col-lg-8 col-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white font-weight-normal">Dados do equipamento</h5>
          </div>
          <div class="card-body">
            <div class="row mx-auto">
              <div class="row col-12 px-0 mx-auto">
                <div class="col-lg-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Equipamento <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" name="id_equipamento" required>
                      <option value="">Selecione</option>
                      @foreach($equipamentos as $equipamento)
                      <option value="{{$equipamento->id}}" {{($ativo->id_equipamento == $equipamento->id ? 'selected' : '')}}>{{$equipamento->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Marca <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" name="id_marca" required>
                      <option value="">Selecione</option>
                      @foreach($marcas as $marca)
                      <option value="{{$marca->id}}" {{($ativo->id_marca == $marca->id ? 'selected' : '')}}>{{$marca->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-8 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Modelo <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="form-control form-control-line text-uppercase" name="modelo" value="{{$ativo->modelo}}" required/>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="checkbox checkbox-success">
                      <input id="checkbox-1" type="checkbox" {{(isset($ativo->sistema_operacional) || isset($ativo->tipo_licenca) || isset($ativo->antivirus) ? 'checked' : '')}}>
                      <label for="checkbox-1"> Mais informações? </label>
                  </div>
                </div>
                <div class="informacoes mt-4" style="{{(isset($ativo->sistema_operacional) || isset($ativo->tipo_licenca) || isset($ativo->antivirus) ? '' : 'display: none;')}}">
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Sistema operacional</label>
                      <select class="form-control form-control-line" name="sistema_operacional">
                        <option value="">Selecione</option>
                        <option value="Windows 10" {{($ativo->sistema_operacional == 'Windows 10' ? 'selected' : '')}}>Windows 10</option>
                        <option value="Windows 8.1" {{($ativo->sistema_operacional == 'Windows 8.1' ? 'selected' : '')}}>Windows 8.1</option>
                        <option value="Linux Ubuntu" {{($ativo->sistema_operacional == 'Linux Ubuntu' ? 'selected' : '')}}>Linux Ubuntu</option>
                        <option value="Linux Mint" {{($ativo->sistema_operacional == 'Linux Mint' ? 'selected' : '')}}>Linux Mint</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Tipo de licença</label>
                      <select class="form-control form-control-line" name="tipo_licenca">
                        <option value="">Selecione</option>
                        <option value="OEM" {{($ativo->tipo_licenca == 'OEM' ? 'selected' : '')}}>OEM</option>
                        <option value="GPL" {{($ativo->tipo_licenca == 'GPL' ? 'selected' : '')}}>GPL</option>
                        <option value="Por volume" {{($ativo->tipo_licenca == 'Por volume' ? 'selected' : '')}}>Por volume</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Antivírus</label>
                      <select class="form-control form-control-line" name="antivirus">
                        <option value="">Selecione</option>
                        <option value="Kaspersky" {{($ativo->antivirus == 'Kaspersky' ? 'selected' : '')}}>Kaspersky</option>
                        <option value="Windows Defender" {{($ativo->antivirus == 'Windows Defender' ? 'selected' : '')}}>Windows Defender</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-4">
          <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white font-weight-normal">Identificação</h5>
          </div>
          <div class="card-body">
            <div class="row mx-auto">
              <div class="row col-12 px-0 mx-auto">
                <div class="col-lg-4 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nº série <span class="text-danger">*</span></label>
                    <div class="">
                      <input class="form-control form-control-line text-uppercase" name="serialNumber" value="{{$ativo->serialNumber}}" required/>
                      <small class="serialNumber d-block"></small>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nº patrimônio</label>
                    <div class="">
                      <input class="form-control form-control-line text-uppercase" name="n_patrimonio" value="{{$ativo->n_patrimonio}}"/>
                      <small class="n_patrimonio d-block"></small>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Service TAG</label>
                    <div class="">
                      <input class="form-control form-control-line text-uppercase" name="serviceTag" value="{{$ativo->serviceTag}}"/>
                    </div>
                  </div>
                </div>
                <div class="row col-12 mx-auto px-0">
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Setor <span class="text-danger">*</span></label>
                      <select class="form-control form-control-line" name="id_setor" required>
                        <option value="">Selecione</option>
                        @foreach($setores as $setor)
                        <option value="{{$setor->id}}" {{($setor->id == $ativo->id_setor ? 'selected' : '')}}>{{$setor->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">PA <span class="text-danger">*</span></label>
                      <select class="form-control form-control-line" name="id_unidade" required>
                        <option value="">Selecione</option>
                        @foreach($unidades as $unidade)
                        <option value="{{$unidade->id}}" {{($unidade->id == $ativo->id_unidade ? 'selected' : '')}}>{{$unidade->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Usuário responsável</label>
                    <div class="">
                      <select class="form-control form-control-line" name="usuario" required>
                        <option value="">Selecione</option>
                        @foreach($usuarios as $usuario)
                        <option value="{{$usuario->id}}" {{($usuario->id == $ativo->RelationUsuario->last()->id ? 'selected' : '')}}>{{$usuario->RelationAssociado->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white font-weight-normal">Outras informações</h5>
          </div>
          <div class="card-body">
            <div class="row mx-auto">
              <div class="row col-12 px-0 mx-auto">
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Descrição</label>
                    <div class="">
                      <textarea class="form-control form-control-line descricao text-uppercase" name="descricao" rows="3" placeholder="Digite suas observações">{{$ativo->descricao}}</textarea>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label col-12 row mb-0">Imagem principal <span class="text-danger">*</span></label>
                    <small>Formatos de imagem aceitos: <b>.png</b>, <b>.jpg</b> ou <b>.svg</b></small>
                    <div class="row col-12 mt-3 mx-0 p-0">
                      <div class="border mx-2 rounded col-lg-2 col-6 row p-0 mb-4" style="height: 8em;">
                        <img class="w-100 h-100 p-3" id="PreviewImage" src="{{(isset($ativo->RelationImagemPrincipal) ? asset('storage/app/'.$ativo->RelationImagemPrincipal->endereco) : asset('public/img/image.png'))}}">
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
                      <div class="border mx-2 rounded col-lg-2 col-4 row p-0 mb-4" style="height: 7em;">
                        <i class="mdi mdi-plus mdi-36px m-auto"></i>
                        <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" id="addFotoGaleria" accept="image/*" title="Selecione as imagens do problema" multiple>
                      </div>
                      @foreach($ativo->RelationImagem as $imagens)
                      <div class="border mx-2 mb-4 rounded col-lg-2 col-4 d-flex p-0" id="PreviewImage{{$imagens->id}}"> 
                        <input type="hidden" name="imagens[]" value="{{$imagens->id}}"> 
                        <img class="p-3 w-100" src="{{asset('storage/app/').'/'.$imagens->endereco}}" style="height: 7em;">
                        <a href="javascript:void(0)" onclick="removeImagem('{{$imagens->id}}')" class="btn btn-light rounded-circle m-n3 border btn-xs" style="height: 26px;">x</a> 
                      </div>
                      @endforeach
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-12 mb-4 mb-lg-0 hidden-xs">
        <div class="card text-center">
          <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white font-weight-normal">Detalhes do equipamento</h5>
          </div>
          <div class="card-body">
            <div class="">
              <img src="{{(isset($ativo->RelationImagemPrincipal) ? asset('storage/app/'.$ativo->RelationImagemPrincipal->endereco) : asset('public/img/image.png'))}}" width="120" height="110" class="border p-1 rounded" id="ImagePrincipal">
            </div>
            <div class="d-block">
              <h5 class="d-block mb-0" id="equipamento">{{$ativo->RelationEquipamento->nome}}</h5>
              <label class="d-block mb-0 mt-2">
                <span id="modelo">{{$ativo->modelo}}</span>
                &#183 
                <span id="marca">{{$ativo->RelationMarca->nome}}</span>
              </label>
              <small class="d-block mt-2" id="n_patrimonio">{{$ativo->n_patrimonio}}</small>
              <hr class="mx-5">
              <label class="d-block mt-3 mb-0" id="usuario">{{$ativo->RelationUsuario->last()->RelationAssociado->nome}}</label>
              <label class="mt-2 d-block" id="id_setor">{{$ativo->RelationSetor->nome}}</label>
              <label class="badge badge-info" id="id_unidade">{{$ativo->RelationUnidade->nome}}</label>
            </div>
          </div>
        </div>
      </div>
      <hr class="col-10 mt-lg-5">
      <div class="row col-12 justify-content-center mx-auto mb-4">
        <a href="{{route('exibir.geral.equipamentos')}}" class="btn btn-danger btn-outline col-lg-3 col-5 d-flex align-items-center justify-content-center mx-2">
          <i class="mdi mdi-arrow-left pr-2"></i> 
          <span>Voltar</span>
        </a>
        <button type="submit" class="btn btn-success btn-outline col-lg-3 col-5 d-flex align-items-center justify-content-center mx-2">
          <i class="mdi mdi-check pr-2"></i> 
          <span>Salvar</span>
        </button>
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
    // Mascara de formatação
    $('form input[name="n_patrimonio"]').mask('00.0000000', {reverse: true});

    // Atualizando detalhes do ativo
    $('form select[name="id_equipamento"]').on('keyup', function(){
      $('#equipamento').html($('select[name="id_equipamento"] option:selected').text());
    });
    $('form select[name="id_marca"]').on('keyup', function(){
      $('#marca').html($('select[name="id_marca"] option:selected').text());
    });
    $('form input[name="modelo"]').on('keyup', function(){
      $('#modelo').html($('input[name="modelo"]').val());
    });
    $('form input[name="serialNumber"]').on('keyup', function(){
      $.get("{{url('app/gti/equipamentos/serialNumber')}}/"+$('input[name="serialNumber"]').val(), function(data){
        if(data.success == true){
          $('input[name="serialNumber"]').removeClass('border-success').addClass('border-danger');
          $('.serialNumber').html('Nº de série já cadastrado.').addClass('text-danger pt-2');
          $('button[type=submit]').attr('disabled', 'disabled');
        }else{
          $('input[name="serialNumber"]').removeClass('border-danger').addClass('border-success');
          $('.serialNumber').html('').removeClass('text-danger pt-2');
          $('button[type=submit]').removeAttr('disabled');
        }
      });
    });
    $('form input[name="n_patrimonio"]').on('keyup', function(){
      $('#n_patrimonio').html($('input[name="n_patrimonio"]').val());
      $.get("{{url('app/gti/equipamentos/patrimonio')}}/"+$('input[name="n_patrimonio"]').val(), function(data){
        if(data.success == true){
          $('input[name="n_patrimonio"]').removeClass('border-success').addClass('border-danger');
          $('.n_patrimonio').html('Nº de patrimônio já cadastrado.').addClass('text-danger pt-2');
          $('button[type=submit]').attr('disabled', 'disabled');
        }else{
          $('input[name="n_patrimonio"]').removeClass('border-danger').addClass('border-success');
          $('.n_patrimonio').html('').removeClass('text-danger pt-2');
          $('button[type=submit]').removeAttr('disabled');
        }
      });
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

    // Inserindo outras informações
    $('#checkbox-1').on('click', function(){
      if($(this).prop('checked')){
        $('.informacoes').fadeIn();
      }else{
        $('.informacoes').fadeOut();
      }
    });

    // Carregando imagem principal
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