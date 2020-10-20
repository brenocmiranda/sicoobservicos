@section('title')
Equipamentos
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Equipamentos</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">GTI</a></li>
				<li class="active">Equipamentos</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div id="treeview6" class=""></div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		var defaultData = [
          @foreach($usuarios as $usuario)
	      	{
	      	text: "{{$usuario->RelationAssociado->nome}}",
	        href: "#{{$usuario->login}}",
	        tags: ['1'],
	        nodes: [
	        	@foreach($ativos as $ativo)
	        		@if($ativo->RelationUsuario->last()->id == $usuario->id)
		        	{
		        	text: "{{$ativo->nome}} {{$ativo->marca}} {{$ativo->modelo}}",
	                href: '#{{$ativo->nome}}',
	                tags: ['0']
	            	},
	            	@endif
            	@endforeach
	        ]
	    	},
	      @endforeach
        ];

		$('#treeview6').treeview({
	         selectedBackColor: "#03a9f3",
	         onhoverColor: "rgba(0, 0, 0, 0.05)",
	         expandIcon: "ti-angle-right",
	         collapseIcon: "ti-angle-down",
	         nodeIcon: "fa fa-folder",
	         showTags: true,
	         data: defaultData
        });
	});
</script>
@endsection