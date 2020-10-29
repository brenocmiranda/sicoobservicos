@section('title')
Configurações
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Configurações</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="{{route('inicio')}}">Home</a></li>
				<li class="active">Configurações</li>
			</ol>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			@if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1)
			<h5 class="mx-5">Administrativo</h5>
			<hr class="mt-0 mx-5">
			<div class="row justify-content-center mb-5">
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.funcoes.administrativo') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-package-variant mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Funções </h5>
							<label> Gerencie as funções responsáveis por dar acessos as funcionalidades da plataforma. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.instituicoes.administrativo') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-city mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Instituições </h5>
							<label> Gerencie as instituições que estarão disponíveis para utilização da plataforma. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.setores.administrativo') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-buffer mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Setores </h5>
							<label> Gerencie os setores que fazem parte da estrutra da cooperativa. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.unidades.administrativo') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							 <i class="mdi mdi-store mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Unidades </h5>
							<label> Gerencie as unidades que fazem parte da estrutura da cooperativa. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.usuarios.administrativo') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-account-settings-variant mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Usuários </h5>
							<label> Gerencie os usuários que terão acesso a plataforma quais suas especificidades. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
			<h5 class="mx-5">Aprendizagem</h5>
			<hr class="mt-0 mx-5">
			<div class="row justify-content-center mb-5">
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.fontes.chamados') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-content-paste mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Tópicos </h5>
							<label> Gerencie as funções responsáveis por dar acessos as funcionalidades da plataforma. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.fontes.chamados') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-attachment mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Anexos </h5>
							<label> Gerencie as instituições que estarão disponíveis para utilização da plataforma. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_credito == 1)
			<h5 class="mx-5">Crédito</h5>
			<hr class="mt-0 mx-5">
			<div class="row justify-content-center mb-5">
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.armarios.credito') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-archive mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Armários </h5>
							<label> Gerencie os armários que estarão disponíveis nos contratos de crédito. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.finalidades.credito') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-book mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Finalidades </h5>
							<label> Gerencie as finalidades disponíveis nos contratos de crédito. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.modalidades.credito') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							 <i class="mdi mdi-bookmark-outline mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Modalidades </h5>
							<label> Gerencie as modalidades disponíveis nos contratos de crédito. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.produtos.credito') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-cards-variant mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Produtos </h5>
							<label> Gerencie os produtos que estarão disponíveis nos contratos de crédito. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_gti == 1)
			<h5 class="mx-5">Chamados</h5>
			<hr class="mt-0 mx-5">
			<div class="row justify-content-center mb-5">
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.fontes.chamados') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-package-variant mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Fontes </h5>
							<label> Gerencie as fontes de problemas que estarão disponíveis na abertura de chamados. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.tipos.chamados') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							 <i class="mdi mdi-webhook mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Tipos </h5>
							<label> Gerencie os status que estarão disponíveis para controle de fluxo dos chamados. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.status.chamados') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-stackoverflow mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Status </h5>
							<label> Gerencie os tipos de problemas que estarão disponíveis na abertura dos chamados. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
			<h5 class="mx-5">Controle de Estoque</h5>
			<hr class="mt-0 mx-5">
			<div class="row justify-content-center mb-5">
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.todos.materiais') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-lead-pencil mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Materiais </h5>
							<label> Gerencie as fontes de problemas que estarão disponíveis na abertura de chamados. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.categorias.materiais') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							 <i class="mdi mdi-regex mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Categorias </h5>
							<label> Gerencie os status que estarão disponíveis para controle de fluxo dos chamados. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1)
			<h5 class="mx-5">E-mails</h5>
			<hr class="mt-0 mx-5">
			<div class="row justify-content-center mb-5">
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.ajustes.emails') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-json mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Ajustes </h5>
							<label> Gerencie as fontes de problemas que estarão disponíveis na abertura de chamados. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.mensagens.emails') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							 <i class="mdi mdi-email-outline mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Mensagens </h5>
							<label> Gerencie os status que estarão disponíveis para controle de fluxo dos chamados. </label>
						</div>
					</a>
				</div>
			</div>

			<h5 class="mx-5">Importações</h5>
			<hr class="mt-0 mx-5">
			<div class="row justify-content-center mb-5">
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.importacoes') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-upload mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Importar </h5>
							<label> Execute a importação dos arquivos para atualização dos dados disponíveis na plataforma. </label>
						</div>
					</a>
				</div>
				<div class="col-10 rounded m-3">
					<a href="{{ route('exibir.importacoes') }}" class="row">
						<div class="border rounded row align-items-center shadow-sm">
							<i class="mdi mdi-file-document mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-10 text-secondary mx-4">
							<h5 class="mb-1 text-primary"> Logs </h5>
							<label> Execute a importação dos arquivos para atualização dos dados disponíveis na plataforma. </label>
						</div>
					</a>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection