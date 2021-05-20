@extends('layouts.index')

@section('title')
Database
@endsection

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Database dos relatórios</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('inicio')}}">Configurações</a></li>
                <li class="active">Data base</li>
            </ol>
        </div>
    </div>
    
    @if(Session::has('upload'))
    <p class="mx-auto col-12 alert alert-{{ Session::get('upload')['class'] }}">
        {{ Session::get('upload')['mensagem'] }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </p>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="h-100 row col">
                <div class="col-lg-12 position-absolute">
                    <div class="row mx-auto">
                        <a href="{{route('exibir.importacoes')}}" class="btn btn-primary btn-outline ml-auto" title="Importar relatórios" style="z-index: 10">
                            <i class="m-0 pr-lg-1 mdi mdi-upload"></i> 
                            <span class="hidden-xs">Importar relatórios</span> 
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <table class="table table-striped text-center color-table muted-table rounded d-block d-lg-table" style="overflow-y: auto;">
                    <thead>
                        <th>Relatório</th>
                        <th>Tipo</th>
                        <th>Data de movimento</th>
                        <th>Última atualização</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>cli_associados</td>
                            <td>Diário</td>
                            <td>-</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_associados->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_associados->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cli_consolidado</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$cli_consolidado->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_consolidado->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_consolidado->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cli_emails</td>
                            <td>Diário</td>
                            <td>-</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_emails->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_emails->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cli_telefones</td>
                            <td>Diário</td>
                            <td>-</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_telefones->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_telefones->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cli_enderecos</td>
                            <td>Diário</td>
                            <td>-</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_enderecos->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_enderecos->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cli_conglomerados</td>
                            <td>Diário</td>
                            <td>-</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_conglomerados->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_conglomerados->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cli_iap</td>
                            <td>Mensal</td>
                            <td>{{date('d/m/Y', strtotime(@$cli_iap->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_iap->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_iap->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cli_bacen</td>
                            <td>Mensal</td>
                            <td>{{date('d/m/Y', strtotime(@$cli_bacen->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cli_bacen->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cli_bacen->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cca_contacapital</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$cca_contacapital->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cca_contacapital->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cca_contacapital->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cco_contacorrente</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$cco_contacorrente->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cco_contacorrente->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cco_contacorrente->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cre_contratos</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$cre_contratos->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cre_contratos->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_contratos->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cre_avalistas</td>
                            <td>Mensal</td>
                            <td>{{date('d/m/Y', strtotime(@$cre_avalistas->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cre_avalistas->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_avalistas->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>cre_garantias</td>
                            <td>Mensal</td>
                            <td>{{date('d/m/Y', strtotime(@$cre_garantias->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$cre_garantias->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$cre_garantias->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>crt_cartaocredito</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$crt_cartaocredito->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$crt_cartaocredito->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$crt_cartaocredito->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>dep_aplicacoes</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$dep_aplicacoes->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$dep_aplicacoes->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$dep_aplicacoes->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>pop_poupanca</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$pop_poupanca->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$pop_poupanca->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$pop_poupanca->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>pro_seguros</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$pro_seguros->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$pro_seguros->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$pro_seguros->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                         <tr>
                            <td>pro_consorcios</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$pro_consorcios->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$pro_consorcios->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$pro_consorcios->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>pro_previdencias</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$pro_previdencias->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$pro_previdencias->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$pro_previdencias->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                        <tr>
                            <td>pro_cobranca</td>
                            <td>Diário</td>
                            <td>{{date('d/m/Y', strtotime(@$pro_cobranca->data_movimento))}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime(@$pro_cobranca->updated_at))}}</td>
                            <td>{!! ( strtotime(date('Y-m-d', strtotime(@$pro_cobranca->updated_at))) == strtotime(date('Y-m-d')) ? '<i class="mdi mdi-check text-success px-2"></i>'.'Atualizado' : '<i class="mdi mdi-close text-danger px-2"></i>'.'Desatualizado')!!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
    $(document).ready( function (){
       $('table').DataTable({
            order: [0, 'asc'],
            paginate: true,
            pageLength: 20,
            searching: true,       
        });
    });
</script>
@endsection