@extends('layouts.index')

@section('title')
Minhas atividades
@endsection

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Minhas atividades</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('inicio')}}">Home</a></li>
                <li class="active">Minhas atividades</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="border-top-right-radius: 0.6em; border-top-left-radius: 0.6em;">
            <h5 class="section-title text-white font-weight-normal">Últimas atualizações</h5>
        </div>
        <div class="card-body">
            <div class="panel panel-default">
                <div class="panel-body py-0">
                    <div class="steamline">
                        @if(!empty($dados->first() ))
                            @foreach($dados as $atividade)
                                <div class="sl-item">
                                    <div class="sl-left bg-success"> <i class="mdi {{$atividade->icone}}"></i></div>
                                    <div class="sl-right">
                                        <div>
                                            <b><a href="{{$atividade->url}}">{{$atividade->nome}}</a></b>
                                            <span class="sl-date">{{ $atividade->created_at->subMinutes(2)->diffForHumans() }}</span>
                                        </div>
                                        <div class="desc"><small>{{$atividade->descricao}}</small></div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div>
                                <label> Você ainda não possui nenhuma atividade na plataforma.</label>
                            </div>
                        @endif 
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                 {!! (isset($dados) ? $dados->links() : '') !!}
            </div>
        </div>
    </div>
</div>
@endsection