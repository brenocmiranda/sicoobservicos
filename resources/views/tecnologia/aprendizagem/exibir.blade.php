@section('title')
Tópicos
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Tópicos de aprendizagem</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('dashboard.gti')}}">Tecnologia</a></li>
				<li><a href="{{route('configuracoes')}}">Configurações</a></li>
				<li class="active">Aprendizagem</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-12  p-0">
				<div class="col-12 row mb-4 mx-auto">
					@include('layouts.search')
					@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
					<div class="col-2 col-lg-5 col-sm-5 p-0 row mx-auto">
						<a href="{{route('adicionar.base.aprendizagem')}}" class="btn btn-primary btn-outline ml-auto" id="adicionar" name="adicionar" title="Adicionar novo tópico">
							<i class="m-0 pr-lg-1 mdi mdi-plus"></i> 
							<span class="hidden-xs">Cadastrar</span>
						</a>
					</div>
					@endif
				</div>
				<div class="row col-12 mx-auto my-5">
					<div class="col-12 p-0">
						<h5>Todos os tópicos cadastrados</h5>
						<hr class="mt-2">
					</div>
					<div class="col-12 px-0">
						@if(isset($topicos[0]))
							<ul class="p-0" id="topicos">
								@foreach($topicos as $topico)
								<li class="row mx-auto">
									<div class="row mx-auto col-12 border shadow-sm rounded my-2 p-3">
										<div class="col-10">
											<a href="{{route('detalhes.base', $topico->id)}}">
												<div>
													<h6>{{$topico->RelationAmbientes->nome}} &#183 {{$topico->RelationFontes->nome}}</h6>
													<h5>{{$topico->titulo}} <small class="text-capitalize">({{$topico->tipo}})</small></h5>
										            <label>{{$topico->subtitulo}}</label> 
										            <br>
										            
												</div>
											</a>
										</div>
										<div class="col-2 m-auto row text-right">
											<div class="ml-auto">
								              <a href="{{route('editar.base.aprendizagem', $topico->id)}}" class="btn btn-default btn-rounded btn-outline btn-xs px-3 my-1 col-10">
								                <i class="mdi mdi-pencil"></i>
								                <small>Editar</small>
								              </a>
								              <a href="javascript:void(0)" data="{{route('delete.base.aprendizagem', $topico->id)}}" class="btn-delete btn btn-default btn-rounded btn-outline btn-xs px-3 my-1 col-10">
								                <i class="mdi mdi-close"></i>
								                <small>Remover</small>
								              </a>
								            </div>
										</div>
									</div>
								</li>
								@endforeach
							</ul>
						@else
							<div class="row mx-auto">
								<label class="alert alert-secondary col-12 rounded"><i class="mdi mdi-alert-outline mdi-24px pr-4"></i> Você não possui nenhum tópico cadastrado.</label>
							</div>
						@endif
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
			$("#topicos li").css("display", "block");
			$("#topicos li").each(function(){
				if($(this).text().indexOf(texto) < 0)
					$(this).css("display", "none");
			});
		});

		$('.btn-delete').on('click', function(e){
	      // Alterando status
	      e.preventDefault();
	      var url = $(this).attr('data');
	      swal({
	        title: "Tem certeza que deseja remover esse tópico?",
	        icon: "warning",
	        buttons: ["Cancelar", "Deletar"],
	        dangerMode: true,
	      })
	      .then((willDelete) => {
	        if (willDelete) {
	          $.get(url, function(data){
	            if(data.success == true){
	              swal("Tópico removido com sucesso!", {
	                icon: "success",
	                button: false
	              });
	              window.location.href = "{{route('exibir.base.aprendizagem')}}";
	            }else{
	              swal("Não foi possível remover as informações.", {
	                icon: "error",
	              });
	            }
	          });
	        } else {
	          swal.close();
	        }
	      });
	    }); 
	});
</script>
@endsection