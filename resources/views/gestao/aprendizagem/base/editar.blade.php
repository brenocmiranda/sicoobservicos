@section('title')
Editar tópico
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">Editar tópico</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Suporte</a></li>
        <li class="active"><a href="{{route('exibir.base.aprendizagem')}}">Base do conhecimento</a></li>
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
  
  <form class="form-sample" action="{{route('salvar.editar.base.aprendizagem', $base->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row mx-auto">
              <div class="col-4">
                <div class="form-group">
                  <label class="col-form-label pb-0">Fonte <span class="text-danger">*</span></label>
                  <select class="form-control form-control-line gti_id_fontes" name="gti_id_fontes" required>
                    <option disabled>Selecione</option>
                    @foreach($fontes as $fonte)
                    <option value="{{$fonte->id}}" {{($fonte->id == $base->gti_id_fontes ? 'selected' : '')}}>{{$fonte->nome}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  <label class="col-form-label pb-0">Tipo</label>
                  <div class="">
                    <select class="form-control form-control-line gti_id_tipos" name="gti_id_tipos" value="{{$base->gti_id_tipos}}" required>
                      <option disabled>Selecione</option>
                      @foreach($tipos as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->nome}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-10">
                <div class="form-group">
                  <label class="col-form-label pb-0">Titulo <span class="text-danger">*</span></label>
                  <div class="">
                    <input class="form-control form-control-line" name="titulo" value="{{$base->titulo}}" required/>
                  </div>
                </div>
              </div>
              <div class="col-11">
                <div class="form-group">
                  <label class="col-form-label pb-0">Sub-título <span class="text-danger">*</span></label>
                  <div class="">
                    <input class="form-control form-control-line" name="subtitulo" value="{{$base->subtitulo}}" required/>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label">Descrição <span class="text-danger">*</span></label>
                  <div class="">
                    <textarea class="summernote" name="descricao" placeholder="Digite suas observações" required>{{$base->descricao}}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="col-form-label col-12 row mb-0">Selecione os anexos</label>
                  <small>Todos formatos são aceitos aceitos: <b>.png</b>, <b>.jpg</b>, <b>.xls</b>, <b>.pdf</b>, <b>.doc</b>, <b>.docx</b></small>
                  <div class="row col-12 mt-3 preview mx-0 p-0">
                    <div class="border mx-2 rounded col-2 row p-0 mb-4" style="height: 7em;">
                      <i class="mdi mdi-plus mdi-36px m-auto"></i>
                      <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" id="addArquivo" title="Selecione os anexos do tópico" multiple>
                    </div>
                    @foreach($base->RelationArquivos as $arquivos)
                    <div class="border mx-2 mb-4 rounded col-2 p-0 row text-center" id="PreviewImage{{$arquivos->id}}"> 
                      <input type="hidden" name="arquivos[]" value="{{$arquivos->id}}">
                      <a href="javascript:void(0)" onclick="removeImagem({{$arquivos->id}})" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="height: 26px;z-index: 10">x</a>
                      @if( explode(".", $arquivos->endereco)[1] == "docx" || explode(".", $arquivos->endereco)[1] == "doc")
                        <i class="mdi mdi-file-word mdi-36px mdi-dark m-auto col-12"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "xls" || explode(".", $arquivos->endereco)[1] == "xlsx" || explode(".", $arquivos->endereco)[1] == "xlsm"
                      || explode(".", $arquivos->endereco)[1] == "csv")
                        <i class="mdi mdi-file-excel mdi-36px mdi-dark m-auto col-12"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "pdf")
                        <i class="mdi mdi-file-pdf mdi-36px mdi-dark m-auto col-12"></i>
                      @else
                        <i class="mdi mdi-file-document mdi-36px mdi-dark m-auto col-12"></i>
                      @endif
                      <span class="col-12 text-truncate">{{str_replace('base/', '', $arquivos->endereco)}}</span>
                    </div>
                    @endforeach
                  </div> 
                </div>
              </div>
              <hr class="col-10 mt-0">
              <div class="row col-12 justify-content-center mx-auto">
                <a href="{{route('exibir.base')}}" class="btn btn-danger btn-outline col-3 d-flex align-items-center justify-content-center mx-2">
                  <i class="mdi mdi-arrow-left pr-2"></i> 
                  <span>Voltar</span>
                </a>
                <button type="submit" class="btn btn-success btn-outline col-3 d-flex align-items-center justify-content-center mx-2">
                  <i class="mdi mdi-check pr-2"></i> 
                  <span>Salvar</span>
                </button>
              </div>
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

    $('.gti_id_fontes').on('change', function(e){
      var fonte = $('.gti_id_fontes').val();
      $.ajax({
        url: "../chamados/tipos/"+fonte,
        type: 'GET',
        success: function(data){ 
          if(data[0]){
            $('.gti_id_tipos').removeAttr('disabled');
            $('.gti_id_tipos').html('<option></option>');
            $('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
            $.each(data, function(count, dados){
              $('.gti_id_tipos').append('<option value='+dados.id+'>'+dados.nome+'</option>');
            });   
          }else{
            $('.gti_id_tipos').attr('disabled', 'disabled');
            $('.gti_id_tipos').html('<option>Nenhum encontrado</option>');
            $('#info-base').fadeIn('slow').html('<label class="text-muted text-center">Após selecionado a sua fonte e o tipo do problema, serão dispostos aqui algumas possíveis soluções cadastrados na nossa base do conhecimento. Fique atento!</label>');
          }   
        }
      });
    });

    // Pré-visualização de vários arquivos no navegador
    $('#addArquivo').on('change', function(event) {
      var formData = new FormData();
      formData.append('_token', '{{csrf_token()}}');

      if (this.files) {
        for (i = 0; i < this.files.length; i++) {
          formData.append('arquivos[]', this.files[i]);
        }
        $.ajax({
          url: "{{ route('adicionar.arquivos.aprendizagem') }}",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(data){ 
            for (i = 0; i < data.length; i++) {
              $('div.preview').append('<div class="border mx-2 mb-4 rounded col-2 p-0 row text-center" id="PreviewImage'+data[i].id+'"> <input type="hidden" name="arquivos[]" value="'+data[i].id+'"><a href="javascript:void(0)" onclick="removeImagem('+data[i].id+')" class="btn btn-light rounded-circle m-n2 mb-auto border btn-xs position-absolute" style="height: 26px;">x</a>'+(data[i].endereco.split('.')[1] == 'docx' || data[i].endereco.split('.')[1] == 'doc' ? '<i class="mdi mdi-file-word mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate">'+data[i].endereco.replace('base/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'xls' || data[i].endereco.split('.')[1] == 'xlsx' || data[i].endereco.split('.')[1] == 'xlsm' || data[i].endereco.split('.')[1] == 'csv' ? '<i class="mdi mdi-file-excel mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate">'+data[i].endereco.replace('base/', '')+'</span>' : (data[i].endereco.split('.')[1] == 'pdf' ? '<i class="mdi mdi-file-pdf mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate">'+data[i].endereco.replace('base/', '')+'</span>' : '<i class="mdi mdi-file-document mdi-36px mdi-dark m-auto col-12"></i><span class="col-12 text-truncate">'+data[i].endereco.replace('base/', '')+'</span>')))+'</div>');
            } 
            $('#addArquivo').val('');   
          }
        });
      }
    }); 
  });
</script>
@endsection