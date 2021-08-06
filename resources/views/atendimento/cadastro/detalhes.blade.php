@section('title')
Detalhes do pré-cadastro
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">Detalhes do pré-cadastro</h4> 
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)">Atendimento</a></li>
        <li><a href="{{route('exibir.cadastro.atendimento')}}">Associados</a></li>
        <li class="active">Detalhes</li>
      </ol>
    </div>
  </div>

  <div class="confirm"></div>

  <div class="row">
    <div class="col-lg-7 col-12 mb-4">
      <div class="card h-100">
        <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
          <div class="my-4 px-2 row">
            <div class="d-flex">
              <h5 class="my-auto text-white font-weight-normal text-capitalize"><a href="{{route('exibir.cadastro.atendimento')}}"><i class="mdi mdi-arrow-left m-4 text-white"></i></a>#0{{$dados->id}} &#183 {{($dados->sigla == "PF" ? 'Pessoa física' : 'Pessoa jurídica')}}</h5>
              <div class="badge mx-3 my-auto badge-{{($dados->RelationStatusRecente->status == 'aberto' ? 'success' : ($dados->RelationStatusRecente->status == 'devolvido' ? 'warning' : ($dados->RelationStatusRecente->status == 'andamento' ? 'info' : ($dados->RelationStatusRecente->status == 'finalizado' ? 'dark' : 'danger' ))))}}">{{$dados->RelationStatusRecente->status}}</div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <h5 class="text-uppercase mb-2">
              {{$dados->nome}}
            </h5>
          </div>
          <div class="col-12 mb-4">
            <label class="text-capitalize d-block text-info">
              {{$dados->documento}}
            </label>
          </div>
          <div>
            @if($dados->sigla == "PJ")
            <div class="row px-0 mx-auto col-12">
              <label class="col-12">
                <b>Nome Fantasia</b> 
                <p>{{$dados->nome_fantasia}}</p>
              </label>
              <label class="col-12">
                <b>Atividade econômica</b> 
                <p>{{$dados->atividade_economica}}</p>
              </label>
              <label class="col-4">
                <b>Data de abertura</b> 
                <p>{{date('d/m/Y', strtotime($dados->data_abertura))}}</p>
              </label>  
              <label class="col-4">
                <b>Porte do cliente</b> 
                <p>{{$dados->porte_cliente}}</p>
              </label>
              <label class="col-4">
                <b>Situação</b> 
                <p>{{$dados->situacao}}</p>
              </label>
              <label class="col-12">
                <b>Obervações</b> 
                <p>{{(isset($dados->observacoes) ? $dados->observacoes : 'Nenhuma informação cadastrada.')}}</p>
              </label>
              <label class="col-12">
                <b>Data de solicitação</b> 
                <p>{{date('d/m/Y H:i', strtotime($dados->created_at))}}</p>
              </label>
            </div>
            @else
            <div class="row px-0 mx-auto col-12">
              <label class="col-12">
                <b>Escolaridade</b> 
                <p>{{$dados->escolaridade}}</p>
              </label>
              <label class="col-12">
                <b>Profissão</b> 
                <p>{{$dados->profissao}}</p>
              </label>
              <label class="col-4">
                <b>Sexo</b> 
                <p>{{$dados->sexo}}</p>
              </label>
              <label class="col-4">
                <b>Naturalidade</b> 
                <p>{{$dados->naturalidade}}</p>
              </label>  
              <label class="col-4">
                <b>Estado civíl</b> 
                <p>{{$dados->estadoCivil}}</p>
              </label>
              <label class="col-12">
                <b>Obervações</b> 
                <p>{{(isset($dados->observacoes) ? $dados->observacoes : 'Nenhuma informação cadastrada.')}}</p>
              </label>
              <label class="col-12">
                <b>Data de solicitação</b> 
                <p>{{date('d/m/Y H:i', strtotime($dados->created_at))}}</p>
              </label>
            </div>
            @endif
            <div class="col-12 mt-4">
              <h5 class="mb-3">Contatos</h5>
              <hr class="mt-0 mb-3">
              <div class="col-12 px-0 mb-4">
                <label class="d-block">
                  <b>E-mail</b> 
                  <p>{{$dados->email}}</p>
                </label>
              </div>
              <div class="row px-0 mx-auto col-12 mb-4">
                @foreach($dados->RelationTelefones as $telefone)
                  <label class="px-0 col-4">
                    <b>Telefone {{$telefone->tipoTelefone}}</b> 
                    <p>{{$telefone->numero}}</p>
                  </label>
                @endforeach
              </div>
            </div>
            @if($dados->sigla == "PJ")
            <div class="col-12 mt-4">
              <h5 class="mb-3">Sócios</h5>
              <hr class="mt-0 mb-3">
              <div class="col-12 px-0 mb-4">
                @foreach($dados->RelationSocios as $socios)
                <a href="javascript:" class="row m-auto mb-1"> 
                  <i class="mdi mdi-chevron-right pr-2"></i>
                  <p class="my-auto">{{$socios->RelationAssociado->nome}}</p>
                </a>
                @endforeach
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5 col-12 py-4 py-lg-0">
      <div class="card mb-4">
        <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
          <div class="m-4 row">
            <h5 class="p-1 my-auto text-white font-weight-normal text-capitalize">Documentos</h5>
          </div>
        </div>
        <div class="card-body" style="overflow-y: auto">
          <ul class="p-0" id="statusNews">
            <li class="mx-2">  
              @if(!empty($dados->RelationArquivos[0]))
                @foreach($dados->RelationArquivos as $arquivos)
                  <div class="row mx-auto mb-3"> 
                  <a href="{{asset('storage/app/'.$arquivos->endereco)}}" target="_blank" class="row col-12">
                    <div class="pr-2">
                      @if( explode(".", $arquivos->endereco)[1] == "docx" || explode(".", $arquivos->endereco)[1] == "doc")
                      <i class="mdi mdi-file-word mdi-dark mdi-24px m-auto"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "xls" || explode(".", $arquivos->endereco)[1] == "xlsx" || explode(".", $arquivos->endereco)[1] == "xlsm"
                      || explode(".", $arquivos->endereco)[1] == "csv")
                      <i class="mdi mdi-file-excel mdi-dark mdi-24px m-auto"></i>
                      @elseif( explode(".", $arquivos->endereco)[1] == "pdf")
                      <i class="mdi mdi-file-pdf mdi-dark mdi-24px m-auto"></i>
                      @else
                      <i class="mdi mdi-file-document mdi-dark mdi-24px m-auto"></i>
                      @endif
                    </div>
                    <div class="my-auto">
                      <label class="m-0 pointer">{{$arquivos->pivot->nome}}</label>
                    </div>
                  </a>
                  </div>
                  @endforeach
              @endif
            </li>
  
          </ul>
        </div>
      </div>
      @if($dados->RelationStatusRecente->status == 'aberto')
      <hr class="col-10">
      <div class="row px-0 col-12 justify-content-center mx-auto">
        <button type="submit" class="btn btn-success col-5 col-lg-5 d-flex align-items-center justify-content-center mx-2" name="button" value="salvar">
          <i class="mdi mdi-pencil pr-2"></i> 
          <span>Editar</span>
        </button>
      </div>
      @endif
    </div>  
  </div>
</div>
@endsection

@section('modal')

@endsection

@section('suporte')
<script type="text/javascript">
  $(document).ready( function (){

  });
</script>
@endsection