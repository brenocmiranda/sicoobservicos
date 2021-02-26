@section('title')
Editar bens
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">Editar bens</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="{{route('dashboard.administrativo')}}">Administrativo</a></li>
        <li><a href="{{route('exibir.bens.administrativo')}}">Bens</a></li>
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
  
  <form class="form-sample" action="{{route('editando.bens.administrativo', $bens->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white">Informações básicas</h5>
          </div>
          <div class="card-body">
            <div class="row col-12 mx-auto">
              <div class="row col-12 mb-4">
                <div class="col-lg-10 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Nome <span class="text-danger">*</span></label>
                    <input class="form-control form-control-line" name="nome" onkeyup="this.value = this.value.toUpperCase();" placeholder="VEÍCULOS FIAT ESTRADA" value="{{$bens->nome}}" onchange="this.value = this.value.toUpperCase();" required/>
                  </div>
                </div>
                <div class="col-lg-5 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Tipo <span class="text-danger">*</span></label>
                    <select class="form-control form-control-line" name="tipo" required>
                      <option value="">Selecione</option>
                      <option value="veiculos" {{($bens->tipo == 'veiculos' ? 'selected' : '')}}>Veículos</option>
                      <option value="imovel" {{($bens->tipo == 'imovel' ? 'selected' : '')}}>Imóvel</option>
                      <option value="outros" {{($bens->tipo == 'outros' ? 'selected' : '')}}>Outros</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-5 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Valor de venda <span class="text-danger">*</span> <small>(R$)</small></label>
                    <input class="money form-control form-control-line" name="valor" placeholder="30.000,00" value="{{number_format($bens->valor,2,',','.')}}" required/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label">Descrição</label>
                    <textarea class="summernote" name="descricao" placeholder="Digite suas observações" onkeyup="this.value = this.value.toUpperCase();">{{$bens->descricao}}</textarea>
                  </div>
                </div>
                <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label col-12 row mb-0">Imagem principal <span class="text-danger">*</span></label>
                  <small>Formatos de imagem aceitos: <b>.png</b>, <b>.jpg</b> ou <b>.svg</b></small>
                  <div class="row col-12 mt-3 mx-0 p-0">
                    <div class="border mx-2 rounded col-lg-3 col-12 row p-0 mb-4" style="height: 15em;">
                      <img class="w-100 h-100 p-3" id="PreviewImage" src="{{ asset('storage/app/').'/'.$bens->RelationImagemPrincipal->endereco.'?'.rand() }}">
                      <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" name="imagem_principal" accept="image/*" title="Selecione a imagem principal" onchange="image(this)">
                    </div>
                  </div> 
                </div>
              </div>
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label col-12 row mb-0">Selecione outras imagens</label>
                    <small>Todos formatos são aceitos aceitos: <b>.png</b>, <b>.jpg</b>, <b>.jpeg</b></small>
                    <div class="row col-12 mt-3 preview mx-0 p-0">
                      <div class="border mx-2 rounded col-lg-2 col-6 row p-0 mb-4" style="height: 10em;">
                        <i class="mdi mdi-plus mdi-36px m-auto"></i>
                        <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" id="addImagens" title="Selecione as imagens do bem" accept=".png, .jpg, .jpeg" multiple>
                      </div>
                      @foreach($bens->RelationImagem as $imagens)
                        <div class="border mx-2 mb-4 rounded col-2 d-flex p-0" id="PreviewImage{{$imagens->id}}"> 
                          <input type="hidden" name="imagens[]" value="{{$imagens->id}}"> 
                          <img class="p-3 w-100" src="{{asset('storage/app/').'/'.$imagens->endereco}}" style="height: 10em;">
                          <a href="javascript:void(0)" onclick="removeImagem('{{$imagens->id}}')" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="z-index: 10"><i class="mdi mdi-close"></i></a> 
                        </div>
                      @endforeach
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card mt-5">
          <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="text-white">Localização do bem <small class="text-white">(Opcional)</small></h5>
          </div>
          <div class="card-body">
            <div class="row col-12 mx-auto">    
              <div class="row col-12">
                <div class="col-lg-3 col-6">
                  <div class="form-group">
                    <label class="col-form-label pb-0">CEP</label>
                    <input class="form-control form-control-line cep" placeholder="39.270-082" name="cep" value="{{$bens->cep}}"/>
                  </div>
                </div>
                <div class="col-lg-10 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Rua</label>
                    <input class="form-control form-control-line rua" placeholder="AVENIDA ANTONIO NASCIMENTO" name="rua" onkeyup="this.value = this.value.toUpperCase();" value="{{$bens->rua}}"/>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Bairro</label>
                    <input class="form-control form-control-line bairro" placeholder="CENTRO" name="bairro"  onkeyup="this.value = this.value.toUpperCase();" value="{{$bens->bairro}}"/>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Número</label>
                    <input type="number" class="form-control form-control-line numero" name="numero" value="{{$bens->numero}}"/>
                  </div>
                </div>
                <div class="col-lg-8 col-12">
                  <div class="form-group">
                    <label class="col-form-label pb-0">Complemento</label>
                    <input class="form-control form-control-line complemento" name="complemento" onkeyup="this.value = this.value.toUpperCase();" value="{{$bens->complemento}}"/>
                  </div>
                </div>
                <div class="row col-12">
                  <div class="col-lg-5 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Cidade</label>
                      <input class="form-control form-control-line cidade"  placeholder="PIRAPORA" name="cidade" onkeyup="this.value = this.value.toUpperCase();" value="{{$bens->cidade}}"/>
                    </div>
                  </div>
                  <div class="col-lg-5 col-12">
                    <div class="form-group">
                      <label class="col-form-label pb-0">Estado</label>
                      <select class="form-control form-control-line estado" name="estado">
                        <option value="AC" {{($bens->estado == 'AC' ? 'selected' : '')}}>Acre</option>
                        <option value="AL" {{($bens->estado == 'AL' ? 'selected' : '')}}>Alagoas</option>
                        <option value="AP" {{($bens->estado == 'AP' ? 'selected' : '')}}>Amapá</option>
                        <option value="AM" {{($bens->estado == 'AM' ? 'selected' : '')}}>Amazonas</option>
                        <option value="BA" {{($bens->estado == 'BA' ? 'selected' : '')}}>Bahia</option>
                        <option value="CE" {{($bens->estado == 'CE' ? 'selected' : '')}}>Ceará</option>
                        <option value="DF" {{($bens->estado == 'DF' ? 'selected' : '')}}>Distrito Federal</option>
                        <option value="ES" {{($bens->estado == 'ES' ? 'selected' : '')}}>Espírito Santo</option>
                        <option value="GO" {{($bens->estado == 'GO' ? 'selected' : '')}}>Goiás</option>
                        <option value="MA" {{($bens->estado == 'MA' ? 'selected' : '')}}>Maranhão</option>
                        <option value="MT" {{($bens->estado == 'MT' ? 'selected' : '')}}>Mato Grosso</option>
                        <option value="MS" {{($bens->estado == 'MS' ? 'selected' : '')}}>Mato Grosso do Sul</option>
                        <option value="MG" {{($bens->estado == 'MG' ? 'selected' : '')}}>Minas Gerais</option>
                        <option value="PA" {{($bens->estado == 'PA' ? 'selected' : '')}}>Pará</option>
                        <option value="PB" {{($bens->estado == 'PB' ? 'selected' : '')}}>Paraíba</option>
                        <option value="PR" {{($bens->estado == 'PR' ? 'selected' : '')}}>Paraná</option>
                        <option value="PE" {{($bens->estado == 'PE' ? 'selected' : '')}}>Pernambuco</option>
                        <option value="PI" {{($bens->estado == 'PI' ? 'selected' : '')}}>Piauí</option>
                        <option value="RJ" {{($bens->estado == 'RJ' ? 'selected' : '')}}>Rio de Janeiro</option>
                        <option value="RN" {{($bens->estado == 'RN' ? 'selected' : '')}}>Rio Grande do Norte</option>
                        <option value="RS" {{($bens->estado == 'RS' ? 'selected' : '')}}>Rio Grande do Sul</option>
                        <option value="RO" {{($bens->estado == 'RO' ? 'selected' : '')}}>Rondônia</option>
                        <option value="RR" {{($bens->estado == 'RR' ? 'selected' : '')}}>Roraima</option>
                        <option value="SC" {{($bens->estado == 'SC' ? 'selected' : '')}}>Santa Catarina</option>
                        <option value="SP" {{($bens->estado == 'SP' ? 'selected' : '')}}>São Paulo</option>
                        <option value="SE" {{($bens->estado == 'SE' ? 'selected' : '')}}>Sergipe</option>
                        <option value="TO" {{($bens->estado == 'TO' ? 'selected' : '')}}>Tocantins</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <hr class="col-10">
        <div class="row col-12 justify-content-center mx-auto">
          <a href="{{route('exibir.bens.administrativo')}}" class="btn btn-danger col-5 col-lg-3 d-flex align-items-center justify-content-center mx-2">
            <i class="mdi mdi-arrow-left pr-2"></i> 
            <span>Voltar</span>
          </a>
          <button type="submit" class="btn btn-success col-5 col-lg-3 d-flex align-items-center justify-content-center mx-2">
            <i class="mdi mdi-check pr-2"></i> 
            <span>Salvar</span>
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection


@section('suporte')
<script type="text/javascript">
  function removeImagem(id){
    $.ajax({
      url: "../removeImagem/"+id,
      type: 'GET',
      success: function(data){ 
        $('#PreviewImage'+id).remove();
      }
    });
  }
  $(document).ready( function (){
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.cep').mask('00.000-000', {reverse: true});
    $('.summernote').summernote({
            height: 150, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

    // Buscando dados do cep
        $(".cep").blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {

                    $(".rua").val("...");
                    $(".bairro").val("...");
                    $(".cidade").val("...");
                    $(".estado").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $(".rua").val(dados.logradouro.toUpperCase());
                            $(".bairro").val(dados.bairro.toUpperCase());
                            $(".cidade").val(dados.localidade.toUpperCase());
                            $(".estado").val(dados.uf);
                        } 
                        else {
                           //cep é não encontrado.
                            $(".rua").val("");
                      $(".bairro").val("");
                      $(".cidade").val("");
                      $(".estado").val("");
                            alert("CEP não encontrado.");
                        }
                    });
                } 
                else {
                    //cep é inválido.
                    $(".rua").val("");
                  $(".bairro").val("");
                  $(".cidade").val("");
                  $(".estado").val("");
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                $(".rua").val("");
                $(".bairro").val("");
                $(".cidade").val("");
                $(".estado").val("");
            }
        });

        // Pré-visualização de várias imagens no navegador
    $('#addImagens').on('change', function(event) {
      var formData = new FormData();
      formData.append('_token', '{{csrf_token()}}');

      if (this.files) {
        for (i = 0; i < this.files.length; i++) {
          formData.append('imagens[]', this.files[i]);
        }
        $.ajax({
          url: "{{ route('adicionar.imagens.bens.administrativo') }}",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(data){ 
            for (i = 0; i < data.length; i++) {
              $('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 p-0 row text-center" id="PreviewImage'+data[i].id+'" style="height: 10em;"> <input type="hidden" name="imagens[]" value="'+data[i].id+'"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="height: 26px; width: 26px">x</a><img src="{{asset("storage/app/")}}/'+data[i].endereco+'" class="w-100 h-100 p-2"></div>');
            } 
            $('#addImagens').val('');   
          }
        });
      }
    });
       
  });
</script>
@endsection