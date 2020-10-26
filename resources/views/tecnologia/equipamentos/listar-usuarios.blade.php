@section('title')
Invetário por usuário
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Invetário por usuário</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.gti')}}">Tecnologia</a></li>
				<li><a href="javascript:void(0)">Inventário</a></li>
				<li class="active">Por usuário</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12 row mb-4 mx-auto">
				@include('layouts.search')
				<div class="col-lg-12 position-absolute">
					<div class="row mx-auto">
						<a href="{{route('adicionar.equipamentos')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo equipamento" style="z-index: 10">
							<i class="m-0 pr-1 mdi mdi-plus"></i> 
							<span>Novo equipamento</span> 
						</a>
					</div>
				</div>
			</div>
			<div class="row mx-auto mt-5">
				<div id="treeview" class="col-7"></div>

				<div class="col-5 border" id="equipamentos" style="display: none">
					<div class="p-3" >
						<h5>Descrições do equipamento</h5>
						<hr class="mt-2">
						<div class="row">
							<div class="col-4 row m-auto justify-content-center">
								<img src="{{ asset('public/img/image.png').'?'.rand() }}" id="imagem" height="80" width="80">
							</div>
							<div class="col-8 p-0">
								<label class="d-block">
									<span>Nome:</span>
									<span id="nome" class="font-weight-bold"></span>
								</label>
								<label class="d-block">
									<span>Marca:</span>
									<span id="marca" class="font-weight-bold"></span>
								</label>
								<label class="d-block">
									<span >Modelo:</span>
									<span id="modelo" class="font-weight-bold"></span>
								</label>
								<label class="d-block">
									<span>Nº patrimônio:</span>
									<span id="n_patrimonio" class="font-weight-bold"></span>
								</label>
								<label class="d-block">
									<span>Serial Number:</span>
									<span id="serialNumber" class="font-weight-bold"></span>
								</label>
								<label class="d-block">
									<span>Localização:</span>
									<span id="localizacao" class="font-weight-bold"></span>
								</label>
								<label class="d-block">
									<span>Descrição:</span>
									<span id="descricao" class="font-weight-bold"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	$(document).ready( function (){
		// Campo de pesquisa
		$("input[type=search]").keyup(function(){
			var texto = $(this).val().toUpperCase();
			$("#treeview li").css("display", "block");
			$("#treeview li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});

		// Carregando dados do treeview
		var defaultData = [
          @foreach($usuarios as $usuario)
	      	{
	      	text: "{{$usuario->RelationAssociado->nome}}",
	        href: "usuarios/detalhes/{{$usuario->id}}",
	        nodes: [
	        	@foreach($ativos as $ativo)
	        		@if($ativo->RelationUsuario->first()->id == $usuario->id)
		        	{
		        	text: "{{$ativo->nome}} {{$ativo->marca}} {{$ativo->modelo}}",
	                href: 'equipamentos/detalhes/{{$ativo->id}}'
	            	},
	            	@endif
            	@endforeach
	        ]
	    	},
	      @endforeach
        ];

        // Inicilizando o treeview
		$('#treeview').treeview({
	         selectedBackColor: "#03a9f3",
	         onhoverColor: "rgba(0, 0, 0, 0.05)",
	         expandIcon: "ti-angle-right",
	         collapseIcon: "ti-angle-down",
	         nodeIcon: "fa fa-folder",
	         showTags: true,
	         silent : true,
	         data: defaultData
        });

        // Mostrando detalhes do item selecionado
        $('#treeview').on('nodeSelected', function(event, data) {
        	$('#equipamentos').fadeOut();
			$.get("{{url('app/gti')}}/"+data.href, function(data){
				$('#imagem').attr('src', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('#nome').html(data.nome);
				$('#marca').html(data.marca);
				$('#modelo').html(data.modelo);
				$('#n_patrimonio').html(data.n_patrimonio);
				$('#serialNumber').html(data.serialNumber);
				$('#localizacao').html(data.setor+" - "+data.unidade);
				$('#descricao').html(data.descricao);
				$('#equipamentos').fadeIn();
			});
		});

        // Fechando todos os equipamentos
        $('#treeview').treeview('collapseAll', { silent: true });
	});
</script>
@endsection