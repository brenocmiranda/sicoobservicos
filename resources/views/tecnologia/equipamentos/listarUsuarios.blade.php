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
			<div class="col-12 row mb-4 mx-auto px-0 px-lg-4">
				@include('layouts.search')
				<div class="col-lg-12 position-absolute px-0 px-lg-4">
					@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
					<div class="col-12 row mx-auto px-0 px-lg-4">
						<a href="{{route('adicionar.equipamentos')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo equipamento" style="z-index: 10">
							<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
							<span class="hidden-xs">Cadastrar</span> 
						</a>
					</div>
					@endif
				</div>
			</div>
			<div class="row mx-auto mt-5">
				@if(!empty($usuarios[0]))
					<div id="treeview" class="col-lg-7 col-12 order-1 order-lg-2 px-0 px-lg-4"></div>

					<div class="col-lg-5 col-12 order-1 order-lg-2 border h-100" id="equipamentos" style="display: none">
						<div class="p-3">
							<h5 class="text-center">Descrição do equipamento</h5>
							<hr class="mt-2">
							<div class="row">
								<div class="col-lg-12 col-12 row m-lg-auto mx-auto mb-5 justify-content-center">
									<div class="zoom-gallery border mx-auto rounded col-4 row p-0" style="height: 9em;">
					                    <a href="#" id="ImagemPrincipalUrl">
					                      <img class="p-3" id="ImagemPrincipal" src="{{ asset('public/img/image.png').'?'.rand() }}" width="100%" style="height: 9em;">
					                    </a>
					                </div>
					                <div class="form-group col-12">
					                  <div class="row justify-content-center mt-3 preview zoom-gallery">
					                  </div>
					                </div>
								</div>
								<div class="col-lg-12 col-12 text-center">
									<label class="d-block">
										<span>Equipamento:</span>
										<span id="equipamento" class="font-weight-bold"></span>
									</label>
									<label class="d-block">
										<span>Modelo:</span>
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
										<span>Service TAG:</span>
										<span id="serviceTag" class="font-weight-bold"></span>
									</label>
									<label class="d-block">
										<span>Sistema operacional:</span>
										<span id="sistema_operacional" class="font-weight-bold"></span>
									</label>
									<label class="d-block">
										<span>Tipo de licença:</span>
										<span id="tipo_licenca" class="font-weight-bold"></span>
									</label>
									<label class="d-block">
										<span>Antivírus:</span>
										<span id="antivirus" class="font-weight-bold"></span>
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
								<div class="col-12 text-right py-2">
									<a href="#" id="editar"> Editar</a>
								</div>
							</div>
						</div>
					</div>
				@else
					<div class="col-12 row mx-auto">
						<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhum equipamento cadastrado.</label>
					</div>
				@endif
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
	      	text: "{{$usuario->nome}}",
	        href: "usuarios/detalhes/{{$usuario->id}}",
	        nodes: [
	        	@foreach($ativos as $ativo)
	        		@if($ativo->RelationUsuario->last()->id == $usuario->id)
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
				$('#equipamento').html(data.equipamento+' '+data.marca);
				$('#sistema_operacional').html((data.sistema_operacional ? data.sistema_operacional : '-'));
				$('#tipo_licenca').html((data.tipo_licenca ? data.tipo_licenca : '-'));
				$('#antivirus').html((data.antivirus ? data.antivirus : '-'));
				$('#modelo').html(data.modelo);
				$('#n_patrimonio').html((data.n_patrimonio ? data.n_patrimonio : '-'));
				$('#serialNumber').html(data.serialNumber);
				$('#serviceTag').html((data.serviceTag ? data.serviceTag : '-'));
				$('#localizacao').html(data.setor+" - "+data.unidade);
				if(data.descricao){
					$('#descricao').html(data.descricao);
				}else{
					$('#descricao').html('Não informado');
				}
				$('#ImagemPrincipalUrl').attr('href', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('#ImagemPrincipal').attr('src', "{{url('storage/app')}}/"+data.imagem.endereco);
				$('.preview').html('');
				$.each(data.imagens, function(count,dados){
					$('.preview').append('<a href="{{url("storage/app")}}/'+dados.endereco+'"><img class="border rounded m-1 p-2" src="{{url("storage/app")}}/'+dados.endereco+'" height="50" width="50"></a>')
				});
				$('#editar').attr('href', 'editar/'+data.id);
				$('#equipamentos').fadeIn();
			});
		});

        // Fechando todos os equipamentos
        $('#treeview').treeview('collapseAll', { silent: true });
	});
</script>
@endsection