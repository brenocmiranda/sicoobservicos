<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Relatório do painel comercial</title>
  <style type="text/css">
    @font-face {
      font-family: 'Asap';
      font-style: normal;
      font-weight: 400;
      src: url('{{public_path().'/fonts/Asap-Regular.ttf'}}') format("truetype");
    }

    body {
      margin:1em;
      padding:0px;
      line-height: 1.3em !important;
      color: #003641 !important;
      font-size: 13px;
    }

    h1, h2, h3, h4, h5, h5 {
      margin: 0;
      font-family: asap;
    }

    td {
      padding-left: 10px;
      padding-right: 10px;
    }

  </style>
</head>
<body>
  <div>
    <table style="width: 100%">
      <tbody>
        <tr>
          <td style="width: 25%;padding:0px">
            <div style="text-align: center;">
              <img src="{{public_path('img/logo.png')}}" style="width: 150px;">
            </div>
          </td>
          <td style="width: 65%;padding:0px">
            <div style="text-align: center;">
              <h1>Painel Comercial</h1>
            </div>
          </td>
          <td style="width: 25%;padding:0px">
            <small style="font-size: 12px; line-height: 15px !important; text-align: right;">
              <b>Data de impressão</b> 
              <br>
              <span>{{date('d/m/Y H:i')}}</span>
            </small>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>
  <div style="text-align: center; margin-bottom: 30px">
    <h2>Associado</h2>
    <h3 style="font-weight: normal; margin-top: 6px;"> {{$associado->nome}} </h3>
  </div>

  @if(isset($imprimir['atividades']))
  <div style="margin-bottom: 20px;">
    <h2>Últimas atividades</h2>
    <hr>
    @if(isset($atividades[0]))
    <div>
      <div style="margin-bottom: 10px; margin-left: 10px">
        @foreach($atividades->take(5) as $atividade)
        <div>
          <label style="text-transform: capitalize; font-weight: bold">{{$atividade->tipo}}</label>
          <br>          
          <label>{{$atividade->descricao}}</label>
          <div style="font-size: 12px; line-height: 15px !important;">
            <label style="text-transform: capitalize;">Contato: <b>{{$atividade->contato}}</b></label>
            <br>
            <small><b>{{$atividade->RelationUsuarios->RelationAssociado->nome}}</b> - {{date('d/m/Y H:i:s', strtotime($atividade->created_at))}}</small>
          </div>
        </div>
        <br>
        @endforeach
      </div>
    </div>
    @else
    <div style="text-align: left">
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['cadastro']))
  <div style="margin-bottom: 30px;">
    <h2>Dados cadastrais</h2>
    <hr>
    <div>
      <div>
        <table style="width: 100%">
          <tbody style="width: 100%">
            <tr>
              <td>
                <h5>Nome</h5>
                <label>{{$associado->nome}}</label>
              </td>
              <td>
                <h5>CPF/CNPJ</h5>
                <label>{{(strlen($associado->documento) == 11 ? substr($associado->documento, 0, 3).'.'.substr($associado->documento, 3, 3).'.'.substr($associado->documento, 6, 3).'-'.substr($associado->documento, 9, 2) : substr($associado->documento, 0, 2).'.'.substr($associado->documento, 2, 3).'.'.substr($associado->documento, 5, 3).'/'.substr($associado->documento, 8, 4).'-'.substr($associado->documento, 12, 2))}}</label>
              </td>
              <td>
                <h5>{{($associado->descricao_identidade != 'NÃO SE APLICA' ? $associado->descricao_identidade : 'Documento de identificação')}}</h5>
                <label>{{($associado->numero_identidade != '-1' ? $associado->numero_identidade : '-')}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Razão social</h5>
                <label>{{$associado->nome_fantasia}}</label>
              </td>
              <td>
                <h5>Atividade econônmica</h5>
                <label>{{$associado->atividade_economica}}</label>
              </td>
              <td>
                <h5>Escolaridade</h5>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->escolaridade : '-')}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Profissão</h5>
                <label>{{$associado->profissao}}</label>
              </td>
              <td>
                <h5>Data de Nascimento</h5>
                <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
              </td>
              <td>
                <h5>Estado Cívil</h5>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->estado_civil : '-')}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Sexo</h5>
                <label>{{($associado->sexo == 'M' ? 'Masculino' : ($associado->sexo == 'F' ? 'Feminino' : 'Não classificado'))}}</label>
              </td>
              <td>
                <h5>Data de Nascimento</h5>
                <label>{{date('d/m/Y', strtotime($associado->data_nascimento))}}</label>
              </td>
              <td>
                <h5>Estado Cívil</h5>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->estado_civil : '-')}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Nível CRL <small>(Vigência até: {{(isset($associado->RelationConsolidado) ? (date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) != date('d/m/Y', strtotime('1899-12-31')) ? date('d/m/Y', strtotime($associado->RelationConsolidado->data_crl)) : '-') : '-')}})</small></h5>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->nivel_risco_crl : '-')}}</label>
              </td>
              <td>
                <h5>Nível de risco</h5>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->nivel_risco : '-')}}</label>
              </td>
              <td>
                <h5>Data de relacionamento</h5>
                <label>{{date('d/m/Y', strtotime($associado->data_relacionamento))}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Data de renovação</h5>
                <label style="{{( strtotime(date('Y-m-d', strtotime($associado->data_renovacao.'+ 1 year'))) < strtotime(date('Y-m-d')) ? 'color: red' : '')}}" style="{{( strtotime(date('Y-m-d', strtotime($associado->data_renovacao.'+ 1 year'))) < strtotime(date('Y-m-d')) ? 'border-radius:15px' : '')}}">{{date('d/m/Y', strtotime($associado->data_renovacao))}}</label>
              </td>
              <td>
                <h5>Gerente</h5>
                <label>{{$associado->nome_gerente}}</label>
              </td>
              <td>
                <h5>CNAE</h5>
                <label>{{$associado->cod_cnae}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>PA</h5>
                <label>{{$associado->PA}}</label>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
        <h4>Avaliação financeira</h4>
        <hr>
        <table style="width: 100%">
          <tbody style="width: 100%">
            <tr>
              <td>
                <h5>Tipo de renda</h5>
                <label>{{$associado->tipo_renda}}</label>
              </td>
              <td>
                <h5>Renda/Faturamento <small>(Mensal bruto)</small></h5>
                <label>R$ {{number_format($associado->renda, 2, ',', '.')}}</label>
              </td>
              <td>
                <h5>Valor bens móveis <small>(Total)</small></h5>
                <label>R$ {{(isset($associado->RelationConsolidado) ? number_format(@$associado->RelationConsolidado->valor_movel, 2, ',', '.') : '-')}}</label>
              </td>
              <td>
                <h5>Valor bens imóveis <small>(Total)</small></h5>
                <label>R$ {{(isset($associado->RelationConsolidado) ? number_format(@$associado->RelationConsolidado->valor_imovel, 2, ',', '.') : '-')}}</label>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
        <h4>Conglomerado</h4>
        <hr>
        <table style="width: 100%">
          <tbody style="width: 100%">
            <tr>
              <td>
                <h5>Participa de conglomerado?</h5>
                <label>{{(isset($associado->RelationConglomerados) ? 'Sim' : 'Não')}}</label>
              </td>
              <td>
                <h5>Nome</h5>
                <label>{{(isset($associado->RelationConglomerados) ? $associado->RelationConglomerados->descricao : '-')}}</label>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <h5>Participantes</h5>
                @if(isset($conglomerado))
                @foreach($conglomerado as $participante)
                <label class="d-block">{{$participante->RelationAssociado->nome}}</label>
                <br>
                @endforeach
                @else
                <label>-</label>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
        <h4>Produtor Rural</h4>
        <hr>
        <table style="width: 100%">
          <tbody style="width: 100%">
            <tr>
              <td>
                <h5>Indicador de Produtor</h5>
                <label>{{(isset($associado->RelationConsolidado) ? ($associado->RelationConsolidado->indicador_rural == 1 ? 'Sim' : 'Não') : '-')}}</label>
              </td>
              <td>
                <h5>Categoria de Produtor</h5>
                <label>{{(isset($associado->RelationConsolidado) ? $associado->RelationConsolidado->categoria_rural : '-')}}</label>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
        <h4>Endereço</h4>
        <hr>
        <table style="width: 100%">
          <tbody style="width: 100%">
            <tr>
              <td>
                <h5>Lagadouro</h5>
                <label>{{$associado->RelationEnderecos->rua}}</label>
              </td>
              <td>
                <h5>Bairro</h5>
                <label>{{$associado->RelationEnderecos->bairro}}</label>
              </td>
              <td>
                <h5>Número</h5>
                <label>{{$associado->RelationEnderecos->numero}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Complemento</h5>
                <label>{{$associado->RelationEnderecos->complemento}}</label>
              </td>
              <td>
                <h5>Cidade</h5>
                <label>{{$associado->RelationEnderecos->cidade}}</label>
              </td>
              <td>
                <h5>Estado</h5>
                <label>{{$associado->RelationEnderecos->estado}}</label>
              </td>
            </tr>
            <tr>
              <td>
                <h5>País</h5>
                <label>{{$associado->RelationEnderecos->pais}}</label>
              </td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
        <h4>Contatos</h4>
        <hr>
        <table style="width: 100%">
          <tbody style="width: 100%">
            <tr>
              <td>
                <h5>Telefone celular</h5>
                <label>{{($associado->RelationTelefones->numero_celular != '-2' ? $associado->RelationTelefones->numero_celular : '-')}}</label>
              </td>
              <td>
                <h5>Telefone comercial</h5>
                <label>{{($associado->RelationTelefones->numero_comercial != '-2' ? $associado->RelationTelefones->numero_comercial : '-')}}</label>
              </td>
              <td>
                <h5>Telefone residencial</h5>
                <label>{{($associado->RelationTelefones->numero_residencial != '-2' ? $associado->RelationTelefones->numero_residencial : '-')}}</label>
              </td>
              <td>
                <h5>Telefone recado</h5>
                <label>{{($associado->RelationTelefones->numero_recado != '-2' ? $associado->RelationTelefones->numero_recado : '-')}}</label>
              </td>
            </tr>
            <tr>               
              <td colspan="4">
                <h5>Email</h5>
                <label style="text-transform: lowercase;">{{(isset($associado->RelationEmails->email) ? $associado->RelationEmails->email : '-')}}</label>
              </td>
            </tr>           
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  @if(isset($imprimir['bacen']))
  <div style="margin-bottom: 30px;">
    <h2>Sistema Financeiro Nacional
      <small style="font-weight: normal; font-size: 12px; padding-left: 2px">
        @if(isset($associado->RelationBacen[0]))
        (Data base: {{date('m/Y', strtotime($associado->RelationBacen->first()->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationBacen[0]))
    <table style="width: 100%">
      <tbody style="width: 100%">
        <tr>
          <td style="width: 25%;">
            <h5>Total a vencer</h5>
            <label>R$ {{number_format($associado->RelationBacen->sum('saldo_avencer'), 2, ',', '.')}}</label>
          </td>
          <td style="width: 25%;">
            <h5>Total vencido</h5>
            <label class="{{(!empty($associado->RelationBacen->sum('saldo_vencido')) ? 'text-danger' : '')}}">R$ {{number_format($associado->RelationBacen->sum('saldo_vencido'), 2, ',', '.')}}</label>
          </td>
          <td style="width: 25%;">
            <h5>Prejuízo</h5>
            <label class="{{(!empty($associado->RelationBacen->sum('saldo_prejuizo')) ? 'text-danger' : '')}}">R$ {{number_format($associado->RelationBacen->sum('saldo_prejuizo'), 2, ',', '.')}}</label>
          </td>
          <td style="width: 25%;">
            <h5>Respon. Total</h5>
            <label>R$ {{number_format(($associado->RelationBacen->sum('saldo_prejuizo')+$associado->RelationBacen->sum('saldo_vencido')+$associado->RelationBacen->sum('saldo_avencer')), 2, ',', '.')}}</label>
          </td>
        </tr>
      </tbody>
    </table>
    <div style="border: 1px solid light; margin-top: 15px; margin-left: 10px; margin-right: 10px;  padding-bottom: 15px"> 
      @foreach($associado->RelationBacen->sortBy('modalidade') as $dados)
      <div style="margin-left: 10px; margin-right: 10px;">
        <h5 style="padding-left: 10px; padding-top: 12px">{{$dados->modalidade}} &#183 {{$dados->submodalidade}}</h5>
        <hr style="margin-bottom: 5px">
        <div>
          <table class="col-12">
            <tbody class="col-12">
              @if(!empty($dados->saldo_avencer_30))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER ATÉ 30 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_30, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_3160))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 31 A 60 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_3160, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_6190))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 61 A 90 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_6190, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_91180))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 91 A 180 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_91180, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_181360))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 181 A 360 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_181360, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_361720))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 361 A 720 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_361720, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_7211080))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 721 A 1080 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_7211080, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_10811440))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 1081 A 1440 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_10811440, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_14411800))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 1441 A 1800 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_14411800, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_18015400))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 1801 A 5400 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_18015400, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_5400))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER ACIMA DE 5401 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_5400, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer_indeterminado))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">A VENCER DE 361 A 720 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_avencer_indeterminado, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_avencer))
              <tr>
                <td style="width: 300px;"><h5 class="my-1">TOTAL A VENCER</h5></td>
                <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_avencer), 2, ',', '.')}}</label></td>
              </tr>
              @endif

              <!-- Dados vencidos -->

              @if(!empty($dados->saldo_vencido_1530))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 15 A 30 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_1530, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_3160))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 31 A 60 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_3160, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_6190))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 61 A 90 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_6190, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_91120))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 91 A 120 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_91120, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_121150))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 121 A 150 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_121150, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_151180))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 151 A 180 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_151180, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_181240))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 181 A 240 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_181240, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_241300))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 241 A 300 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_241300, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_301360))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 301 A 360 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_301360, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_361540))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS DE 361 A 540 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_361540, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido_540))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">VENCIDOS ACIMA DE 540 DIAS</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_vencido_540, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_vencido))
              <tr>
                <td style="width: 300px;"><h5 class="my-1">TOTAL VENCIDO</h5></td>
                <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_vencido), 2, ',', '.')}}</label></td>
              </tr>
              @endif

              <!-- Dados de prejuízo -->

              @if(!empty($dados->saldo_prejuizo))
              <tr class="text-danger">
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">CRÉDITOS BAIXADOS PARA PREJUIZO</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_prejuizo, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_prejuizo))
              <tr>
                <td style="width: 300px;"><h5 class="my-1">TOTAL PREJUÍZO</h5></td>
                <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_prejuizo), 2, ',', '.')}}</label></td>
              </tr>
              @endif

              <!-- Créditos a liberar -->

              @if(!empty($dados->saldo_credito_liberar))
              <tr>
                <td style="width: 300px;"><h5 class="my-1 font-weight-normal">LIMITE DE CRÉDITO</h5></td>
                <td><label class="pl-5 ml-5 my-1">R$ {{number_format($dados->saldo_credito_liberar, 2, ',', '.')}}</label></td>
              </tr>
              @endif
              @if(!empty($dados->saldo_credito_liberar))
              <tr>
                <td style="width: 300px;"><h5 class="my-1">TOTAL LIMITE</h5></td>
                <td><label class="pl-5 ml-5 my-1 font-weight-bold">R$ {{number_format( ($dados->saldo_credito_liberar), 2, ',', '.')}}</label></td>
              </tr>
              @endif

            </tbody>
          </table>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div style="text-align: center">
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['contacapital']))
  <div style="margin-bottom: 30px;">
    <h2>Conta capital
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px"> 
        @if(isset($associado->RelationCapital))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationCapital->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationCapital))
    <div>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Nº matrícula</h5>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->num_capital : '-')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Situação</h5>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->situacao_capital : '-')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data da matrícula</h5>
              <label>{{(isset($associado->RelationCapital) ? date('d/m/Y', strtotime($associado->RelationCapital->data_matricula)) : '-')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data de saída da matrícula</h5>
              <label>{{(isset($associado->RelationCapital) ? (date('d/m/Y', strtotime($associado->RelationCapital->saida_matricula)) != '31/12/9999' ? date('d/m/Y', strtotime($associado->RelationCapital->saida_matricula)) : '-')  : '-')}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Tem direito ao voto?</h5>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->direito_voto : '-')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tem direito ao rateio?</h5>
              <label>{{(isset($associado->RelationCapital) ? $associado->RelationCapital->direito_rateio : '-')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor integralizado</h5>
              <label>R$ {{(isset($associado->RelationCapital) ? number_format($associado->RelationCapital->valor_integralizado, 2, ',', '.') : '-')}}</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @else
    <div style="text-align: center">
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['contacorrente']))
  <div style="margin-bottom: 30px;">
    <h2>Conta corrente
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px"> 
        @if(isset($associado->RelationContaCorrente[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationContaCorrente[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationContaCorrente[0]))  
    @foreach($associado->RelationContaCorrente->sortByDesc('data_abertura') as $conta)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$conta->num_contrato}}</b> <small>({{$conta->situacao}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Modalidade</h5>
              <label>{{$conta->modalidade_conta}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tipo de conta</h5>
              <label>{{$conta->tipo_conta}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Categoria</h5>
              <label>{{$conta->categoria_conta}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Utilizando o limite</h5>
              <label>{{$conta->utilizacao_limite}} dias</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Taxa de limite</h5>
              <label>{{number_format($conta->taxa_limite, 2, ',', '.')}} %</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor contratado</h5>
              <label>R$ {{number_format($conta->valor_contratado, 2, ',', '.')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor utilizado</h5>
              <label>R$ {{number_format($conta->valor_utilizado, 2, ',', '.')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor pacote tarifário</h5>
              <label>R$ {{number_format($conta->valor_pacote, 2, ',', '.')}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Saldo atual em conta</h5>
              <label>R$ {{number_format($conta->valor_saldo, 2, ',', '.')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Última movimentação</h5>
              <label>{{date('d/m/Y', strtotime($conta->ultima_movimentacao))}} <small>({{$conta->sem_movimentacao}} dias)</small></label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['cartaocredito']))
  <div style="margin-bottom: 30px;">
    <h2>Conta cartão
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationCartaoCredito[0])) 
        (Data base: {{date('d/m/Y', strtotime($associado->RelationCartaoCredito[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationCartaoCredito[0]))  
      @foreach($associado->RelationCartaoCredito->sortBy('situacao') as $cartao)
      <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
        <h4><b>{{$cartao->num_contrato}}</b> <small>({{$cartao->situacao}})</small></h4>
        <hr>
        <table style="width: 100%">
          <tbody style="width: 100%">
            <tr>
              <td style="width: 25%;" valign="top">
                <h5>Produto</h5>
                <label>{{$cartao->produto_cartao}}</label>
              </td>
              <td style="width: 25%;" valign="top">
                <h5>Função do cartão</h5>
                <label>{{$cartao->funcao_cartao}}</label>
              </td>
              <td style="width: 25%;" valign="top">
                <h5>Bandeira</h5>
                <label>{{$cartao->bandeira_cartao}}</label>
              </td>
              <td style="width: 25%;" valign="top">
                <h5>Fatura</h5>
                <label>{{$cartao->fatura}}</label>
              </td>
            </tr>
            <tr>
              <td style="width: 25%;" valign="top">
                <h5>Data de implantação</h5>
                <label>{{(date('d/m/Y', strtotime($cartao->data_limite)) != '01/01/1900' ? date('d/m/Y', strtotime($cartao->data_limite)) : '-')}}</label>
              </td>
              <td style="width: 25%;" valign="top">
                <h5>Valor contratado</h5>
                <label>R$ {{number_format($cartao->valor_atribuido, 2, ',', '.')}}</label>
              </td>
              <td style="width: 25%;" valign="top">
                <h5>Valor utilizado</h5>
                <label>R$ {{number_format($cartao->valor_utilizado, 2, ',', '.')}}</label>
              </td>
              <td style="width: 25%;" valign="top">
                <h5>Valor disponivel</h5>
                <label>R$ {{number_format($cartao->valor_disponivel, 2, ',', '.')}}</label>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['carteiracredito']))
  <div style="margin-bottom: 30px;">
    <h2>Carteira de crédito
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationCarteiraCredito[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationCarteiraCredito[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationCarteiraCredito[0]))  
    @foreach($associado->RelationCarteiraCredito->sortByDesc('data_operacao') as $carteira)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$carteira->num_contrato}}</b> <small>({{$carteira->situacao}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Produto</h5>
              <label>{{$carteira->RelationArquivos->RelationProdutos->nome}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Modalidade</h5>
              <label>{{$carteira->modalidade}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Finalidade</h5>
              <label>{{$carteira->finalidade}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Renegociação?</h5>
              <label>{{$carteira->renegociacao}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Nível de risco</h5>
              <label>{{$carteira->nivel_risco}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data da operação</h5>
              <label>{{date('d/m/Y', strtotime($carteira->data_operacao))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data da vencimento</h5>
              <label>{{date('d/m/Y', strtotime($carteira->data_vencimento))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data de quitação</h5>
              <label>{{($carteira->data_quitacao != "1900-01-01" ? date('d/m/Y', strtotime($carteira->data_quitacao)) : '-')}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Taxa da operação</h5>
              <label>{{number_format($carteira->taxa_operacao, 2, ',', '')}} %</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Taxa de mora</h5>
              <label>{{number_format($carteira->taxa_mora, 2, ',', '')}} %</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Taxa de multa</h5>
              <label>{{number_format($carteira->taxa_multa, 2, ',', '')}} %</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor contratado</h5>
              <label>R$ {{number_format($carteira->valor_contrato, 2, ',', '.')}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Qtd de parcelas</h5>
              <label>{{$carteira->qtd_parcelas}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Qtd de parcelas pagas</h5>
              <label>{{$carteira->qtd_parcelas_pagas}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor da parcela</h5>
              <label>R$ {{($carteira->RelationParcelas->last()['valor_parcela'] > 0 ? number_format($carteira->RelationParcelas->last()['valor_parcela'], 2, ',', '.') : number_format($carteira->RelationParcelas->last()['valor_devedor_parcela'], 2, ',', '.'))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Saldo devedor*</h5>
              <label>R$ {{number_format($carteira->valor_devido, 2, ',', '.')}}</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['poupanca']))
  <div style="margin-bottom: 30px;">
    <h2>Poupança
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationPoupancas[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationPoupancas[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationPoupancas[0]))  
    @foreach($associado->RelationPoupancas->sortByDesc('data_abertura') as $poupanca)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$poupanca->num_conta}}</b> <small>({{$poupanca->situacao}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Tipo de conta</h5>
              <label>{{$poupanca->tipo_conta}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tipo de poupança</h5>
              <label>{{$poupanca->tipo_poupanca}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data de abertura</h5>
              <label>{{date('d/m/Y', strtotime($poupanca->data_abertura))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor saldo</h5>
              <label>R$ {{number_format($poupanca->valor_saldo, 2, ',', '.')}}</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['aplicacoes']))
  <div style="margin-bottom: 30px;">
    <h2>Aplicações
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationAplicacoes[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationAplicacoes[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationAplicacoes[0]))  
    @foreach($associado->RelationAplicacoes->sortByDesc('data_abertura') as $aplicacao)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$aplicacao->num_conta}}</b> <small>({{$aplicacao->tipo}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Conta corrente</h5>
              <label>{{$aplicacao->RelationContaCorrente->num_contrato}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Modalidade</h5>
              <label>{{$aplicacao->modalidade}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tipo</h5>
              <label>{{$aplicacao->tipo}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor inicial</h5>
              <label>R$ {{number_format($aplicacao->valor_inicial, 2, ',', '.')}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Valor da correção monetária</h5>
              <label>R$ {{number_format($aplicacao->valor_correcao, 2, ',', '.')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor saldo</h5>
              <label>R$ {{number_format($aplicacao->valor_saldo, 2, ',', '.')}}</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['iap']))
  <?php $count = 0; ?>
  <div style="margin-bottom: 30px;">
    <h2>IAP
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationIAP))
        (Data base: {{date('m/Y', strtotime($associado->RelationIAP->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationIAP))  
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">    
      <h5><b>Veja os produtos/serviços do associado:</b></h5>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td>
              @if($associado->RelationCartaoCredito->sum('valor_atribuido') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Cartão de crédito  </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> CCartão de crédito  </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationContaCorrente->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Cheque especial  </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Cheque especial  </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationCobrancas->where('situacao', 'ATIVO')->count() > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Cobrança </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Cobrança  </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'VEICULOS AUTOMOTORES NAO INCLUIDOS NO SEGMENTO ANTERIOR, EXCETO MOTOCICLETAS E MOTONETAS')->sum('valor_contratado') > 0 || $associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'TRATORES,EQUIP. RODOVIARIOS,MAQ. E EQUIP. AGRICOLAS,EMBARCACOES,AERONAVES,VEICULOS AUTOMOTORES DESTINADOS TRANSP. CARGAS CAPACIDADE SUPERIOR A 1.500 KG. E VEICULOS AUTOMOTORES DESTINADOS TRANSP. COLETIVO CAPACIDADE PARA 20 (VINTE) PASSAGEIROS OU MAIS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Cons. de automóvel </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Cons. de automóvel  </label>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td>
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'IMÓVEIS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Cons. de imóvel </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Cons. de imóvel  </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'SERVICOS TURISTICOS (BILHETES DE PASSAGEM AEREA E/OU PACOTES TURISTICOS)')->sum('valor_contratado') > 0 || $associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'OUTROS BENS MOVEIS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Cons. de serviços </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Cons. de serviços  </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationConsorcios->where('versao', 'ATIVA')->where('segmento', 'MOTOCICLETAS E MOTONETAS')->sum('valor_contratado') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Cons. de moto. </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Cons. de moto  </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10006')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10052')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10053')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10054')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '10055')->count() > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Crédito rural </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Crédito rural </label>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td>
                @if($associado->RelationIAP->indicador_debito)
                <?php $count++; ?>
                <div>
                  <input type="radio" checked>
                  <label> Debito automático </label>
                </div>
                @else
                <div>
                  <input type="radio">
                  <label> Debito automático </label>
                </div>
                @endif
            </td>
            <td>
              @if($associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '!=', '10006')->where('codigo_modalidade', '!=', '10052')->where('codigo_modalidade', '!=', '10053')->where('codigo_modalidade', '!=', '10054')->where('codigo_modalidade', '!=', '10055')->where('codigo_modalidade', '!=', '1018')->where('codigo_modalidade', '!=', '1024')->count() > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Emprestimos </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Emprestimos </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '1018')->count() > 0 || $associado->RelationCarteiraCredito->where('situacao', 'ENTRADA NORMAL')->where('codigo_modalidade', '1024')->count() > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Financiamentos </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Financiamentos </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationPoupancas->sum('valor_saldo') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Poupança </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Poupança </label>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td>
              @if($associado->RelationPrevidencias->sum('valor_proposta') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Previdência </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Previdência </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationAplicacoes->where('tipo', 'RDC')->sum('valor_saldo') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> RDC </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> RDC </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationAplicacoes->where('tipo', 'LCA')->sum('valor_saldo') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> LCA </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> LCA </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationSeguros->where('familia', 'AUTOMÓVEL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'CONSÓRCIO AUTO')->sum('premio_bruto') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Seguro de auto. </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Seguro de auto. </label>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td>
              @if($associado->RelationIAP->indicador_prestamista)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Seguro prestamista </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Seguro prestamista. </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationSeguros->where('familia', 'PRESTAMISTA')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'RESIDENCIAL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'EMPRESARIAL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'DEMAIS')->sum('premio_bruto') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Seguro massificado </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Seguro massificado </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationIAP->indicador_seguro_rural)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Seguro rural </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Seguro rural </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationSeguros->where('familia', 'VIDA EMPRESARIAL')->sum('premio_bruto') > 0 || $associado->RelationSeguros->where('familia', 'VIDA INDIVIDUAL')->sum('premio_bruto') > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Seguro de vida </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Seguro de vida </label>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td>
              @if($associado->RelationSipag->where('status', 'ATIVO')->count() > 0)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> SIPAG </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> SIPAG </label>
              </div>
              @endif
            </td>
            <td>
              @if($associado->RelationIAP->indicador_titulo_descontado)
              <?php $count++; ?>
              <div>
                <input type="radio" checked>
                <label> Títulos descontados </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Títulos descontados </label>
              </div>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
      <h5 class="font-weight-normal"><b>Outros produtos/serviços </b></h5>
      <hr class="mt-2">
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%">
              @if(isset($associado->RelationCapital) && $associado->RelationCapital->valor_integralizado > 0)
              <div>
                <input type="radio" checked>
                <label> Conta capital </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Conta capital </label>
              </div>
              @endif
            </td>
            <td style="width: 25%">
              @if($associado->RelationContaCorrente->sum('valor_pacote') > 0)
              <div>
                <input type="radio" checked>
                <label> Pacote de tarifas </label>
              </div>
              @else
              <div>
                <input type="radio">
                <label> Pacote de tarifas </label>
              </div>
              @endif
            </td>
            <td style="width: 25%"></td>
            <td style="width: 25%"></td>
          </tr>
        </tbody>
      </table>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['cobranca']))
  <div style="margin-bottom: 30px;">
    <h2>Cobrança
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationCobrancas[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationCobrancas[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationCobrancas[0]))  
    @foreach($associado->RelationCobrancas->sortByDesc('data_adesao') as $cobranca)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$cobranca->perfil}}</b> <small>({{$cobranca->situacao}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Ramo</h5>
              <label>{{$cobranca->ramo}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Grupo</h5>
              <label>{{$cobranca->grupo}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tipo de DDA</h5>
              <label>{{$cobranca->tipo_dda}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Possui cotrato?</h5>
              <label>{{($cobranca->indicador_contrato == 1 ? 'SIM' : 'NÃO')}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Data de adesão</h5>
              <label>{{date('d/m/Y', strtotime($cobranca->data_adesao))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Float</h5>
              <label>{{$cobranca->float}} dia(s)</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['consorcio']))
  <div style="margin-bottom: 30px;">
    <h2>Consórcios
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationConsorcios[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationConsorcios[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationConsorcios[0]))  
    @foreach($associado->RelationConsorcios->sortBy('versao') as $consorcios)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$consorcios->n_contrato}}</b> <small>({{$consorcios->versao}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Segmento</h5>
              <label>{{$consorcios->segmento}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Bem de referência</h5>
              <label>{{$consorcios->bem_referencia}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Situação</h5>
              <label>{{$consorcios->situacao}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Taxa de administração</h5>
              <label>{{number_format($consorcios->taxa_administracao, 2, ',', '.')}} %</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Grupo</h5>
              <label>{{$consorcios->grupo}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Cota</h5>
              <label>{{$consorcios->cota}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Forma de pagamento</h5>
              <label>{{$consorcios->forma_pagamento}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tipo de comtemplação</h5>
              <label>{{$consorcios->tipo_contemplacao}}</label>
            </td>
          </tr>
          <tr>       
            <td style="width: 25%;" valign="top">
              <h5>Data de adesão</h5>
              <label>{{date('d/m/Y', strtotime($consorcios->data_adesao))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data de cancelamento</h5>
              <label>{{(date('d/m/Y', strtotime($consorcios->data_cancelamento)) != '31/12/1969' ? date('d/m/Y', strtotime($consorcios->data_cancelamentoo)) : '-')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor contratado</h5>
              <label>R$ {{number_format($consorcios->valor_contratado, 2, ',', '.')}}</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['previdencia']))
  <div style="margin-bottom: 30px;">
    <h2>Previdências
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationPrevidencias[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationPrevidencias[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationPrevidencias[0]))  
    @foreach($associado->RelationPrevidencias->sortByDesc('data_adesao') as $previdencias)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$previdencias->n_registro}}</b> <small>({{$previdencias->situacao_participante}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Plano</h5>
              <label>{{$previdencias->plano}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Regime</h5>
              <label>{{$previdencias->regime}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tipo de participante</h5>
              <label>{{$previdencias->tipo_participante}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Situação</h5>
              <label>{{$previdencias->situacao_participante}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Forma de pagamento</h5>
              <label>{{$previdencias->forma_pagamento}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data de adesão</h5>
              <label>{{date('d/m/Y', strtotime($previdencias->data_adesao))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Data de cancelamento</h5>
              <label>{{(date('d/m/Y', strtotime($previdencias->data_desligamento)) != '01/01/1900' ? date('d/m/Y', strtotime($previdencias->data_desligamento)) : '-')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Valor da proposta</h5>
              <label>R$ {{number_format($previdencias->valor_proposta, 2, ',', '.')}}</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['seguros']))
  <div style="margin-bottom: 30px;">
    <h2>Seguros
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationSeguros[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationSeguros[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationSeguros[0]))  
    @foreach($associado->RelationSeguros->sortByDesc('data_vigencia') as $seguros)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{$seguros->produto}}</b> <small>(Vigente)</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Nº da apólice</h5>
              <label>{{$seguros->n_apolice}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Ramo</h5>
              <label>{{$seguros->ramo}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Família</h5>
              <label>{{$seguros->familia}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Tipo proposta</h5>
              <label>{{$seguros->tipo_proposta}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Corretora</h5>
              <label>{{$seguros->corretora}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Seguradora</h5>
              <label>{{$seguros->seguradora}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Início de vigência</h5>
              <label>{{date('d/m/Y', strtotime($seguros->data_vigencia))}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Final de vigência</h5>
              <label>{{(date('d/m/Y', strtotime($seguros->data_encerramento)) != '01/01/1900' ? date('d/m/Y', strtotime($seguros->data_encerramento)) : '-')}}</label>
            </td>
          </tr>
          <tr>
            <td style="width: 25%;" valign="top">
              <h5>Prêmio Líquido</h5>
              <label>R$ {{number_format($seguros->premio_liquido, 2, ',', '.')}}</label>
            </td>
            <td style="width: 25%;" valign="top">
              <h5>Prêmio Bruto</h5>
              <label>R$ {{number_format($seguros->premio_bruto, 2, ',', '.')}}</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif

  @if(isset($imprimir['sipag']))
  <div style="margin-bottom: 30px;">
    <h2>SIPAG
      <small style="font-weight: normal; font-size: 12px;padding-left: 2px">
        @if(isset($associado->RelationSipag[0]))
        (Data base: {{date('d/m/Y', strtotime($associado->RelationSipag[0]->RelationFaturamento[0]->data_movimento))}})
        @endif
      </small>
    </h2>
    <hr>
    @if(isset($associado->RelationSipag[0]))  
    @foreach($associado->RelationSipag->sortByDesc('data_credenciamento') as $sipag)
    <div style="margin-top: 10px; margin-left: 10px; margin-right: 10px">
      <h4><b>{{str_replace('_', ' ', $sipag->base)}}</b> <small>({{$sipag->status}})</small></h4>
      <hr>
      <table style="width: 100%">
        <tbody style="width: 100%">
          <tr>
            <td>
              <table style="width: 100%">
                <tr>
                  <td style="width: 50%;" valign="top">
                    <h5>Estabelescimento</h5>
                    <label>{{$sipag->ec}}</label>
                  </td>
                  <td style="width: 50%;" valign="top">
                    <h5>MCC</h5>
                    <label>{{(isset($sipag->descricao_mcc) ? $sipag->descricao_mcc : 'Não possui')}}</label>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%;" valign="top">
                    <h5>Macro Segmento</h5>
                    <label>{{(isset($sipag->segmento) ? $sipag->segmento : 'Não possui')}}</label>
                  </td>
                  <td style="width: 50%;" valign="top">
                    <h5>Domicílio <small>(Banco/Agência)</small></h5>
                    <label>{{$sipag->domicilio_banco}} - {{$sipag->domicilio_agencia}}</label>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%;" valign="top">
                    <h5>Data de credênciamento</h5>
                    <label>{{date('d/m/Y', strtotime($sipag->data_credenciamento))}}</label>
                  </td>
                  <td style="width: 50%;" valign="top">
                    <h5>Faturamento acumulado<small>({{date('Y')}})</small></h5>
                    <label>R$ {{number_format($sipag->RelationFaturamento->sum('total_cnpj'), 2, ',', '.')}}</label>
                  </td>
                </tr>
              </table>
            </td>
            <td>
              @if($sipag->RelationFaturamento->sum('total_cnpj') > 0)
                <table width="100%" border="1">
                  <thead>
                    <th>Data de movimento</th>
                    <th>Valor faturado</th>
                  </thead>
                  <tbody>
                    @foreach($sipag->RelationFaturamento->sortByDesc('data_movimento') as $faturamento)
                    <tr>
                      <td>{{date('m/Y', strtotime($faturamento->data_movimento))}}</td> 
                      <td>{{number_format($faturamento->total_cnpj, 2, ',', '.')}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <div>
                  <h5>Não possui faturamento.</h5>
                </div>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endforeach
    @else
    <div class="text-center">
      <i class="mdi mdi-36px mdi-close-octagon-outline"></i>
      <h3 style="font-weight: normal">Nenhuma informação encontrada.</h3>
    </div>
    @endif
  </div>
  @endif
</body>
</html>