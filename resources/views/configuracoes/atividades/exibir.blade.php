@section('title')
Atividades dos usuários
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Atividades dos usuários</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{route('inicio')}}">Configurações</a></li>
                <li class="active">Atividades dos usuários</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
        	@if($atividades[0])
            <ul class="timeline">
            	@foreach($atividades as $key => $atividade)
                <li class="{{($key % 2 != 0 ? 'timeline-inverted' : '')}}">
                    <div class="timeline-badge success"><i class="mdi {{$atividade->icone}}"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h5 class="timeline-title font-weight-bold">{{$atividade->RelationUsuarios->RelationAssociado->nome}}</h5>
                            <p><small class="text-muted">{{date('d/m/Y H:i:s', strtotime($atividade->created_at))}} <i class="fa fa-clock-o"></i> {{$atividade->created_at->subMinutes(2)->diffForHumans()}}</small> </p>
                        </div>
                        <div class="timeline-body">
                            <p>{{$atividade->descricao}}</p>
                        </div>
                         <div class="pt-3">
                            <a href="{{$atividade->url}}">{{$atividade->url}}</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="row col-12 my-5 justify-content-center">
                {{$atividades->links()}}
            </div>
            @else
                <div class="row mx-auto col-12 p-0">
                    <label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i>Nenhuma atividade dos seus usuários.</label>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	function image1(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function (oFREvent){
				$('#PreviewImage1').attr('src', oFREvent.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function image2(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function (oFREvent){
				$('#PreviewImage2').attr('src', oFREvent.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection