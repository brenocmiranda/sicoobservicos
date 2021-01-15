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
		<div class="card-body px-3 px-lg-5">
			@if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1)
			<h5 class="mx-5">Administrativo</h5>
			<hr class="mt-0 mx-5">
			<div class="row col-12 justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.funcoes.administrativo') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-package-variant mdi-dark mdi-24px"></i>
						</div>
						<div class="col-sm-11 col-9 col-lg-11 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Funções </h5>
							<label> Gerencie as funções responsáveis por dar acessos as funcionalidades da plataforma. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.instituicoes.administrativo') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-city mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Instituições </h5>
							<label> Gerencie as instituições que estarão disponíveis para utilização da plataforma. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.setores.administrativo') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-buffer mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Setores </h5>
							<label> Gerencie os setores que fazem parte da estrutra da cooperativa. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.unidades.administrativo') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							 <i class="mdi mdi-store mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Unidades </h5>
							<label> Gerencie as unidades que fazem parte da estrutura da cooperativa. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.usuarios.administrativo') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-account-settings-variant mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
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
			<div class="row col-12 justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.fontes.chamados') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-content-paste mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Tópicos </h5>
							<label> Cadastre ou remova os tópicos que estarão disponíveis na base de conhecimento. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.fontes.chamados') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-attachment mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Anexos </h5>
							<label> Gerencie os documentos que estarão disponíveis para os usuários. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_credito == 1)
			<h5 class="mx-5">Crédito</h5>
			<hr class="mt-0 mx-5">
			<div class="row col-12  justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.armarios.credito') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-archive mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Armários </h5>
							<label> Gerencie os armários que estarão disponíveis nos contratos de crédito. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.modalidades.credito') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							 <i class="mdi mdi-bookmark-outline mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Modalidades </h5>
							<label> Gerencie as modalidades disponíveis nos contratos de crédito. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.produtos.credito') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-cards-variant mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
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
			<div class="row col-12 justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.fontes.chamados') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-package-variant mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Fontes </h5>
							<label> Gerencie as fontes de problemas que estarão disponíveis na abertura de chamados. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.tipos.chamados') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							 <i class="mdi mdi-webhook mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Tipos </h5>
							<label> Gerencie os tipos que estarão disponíveis para controle de fluxo dos chamados. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.status.chamados') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-stackoverflow mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Status </h5>
							<label> Gerencie os status de problemas que estarão disponíveis na abertura dos chamados. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1)
			<h5 class="mx-5">Controle de Estoque</h5>
			<hr class="mt-0 mx-5">
			<div class="row col-12 justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.todos.materiais') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-lead-pencil mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Materiais </h5>
							<label> Cadastre, altere ou desative os materiais que estarão disponíveis para solicitação. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.categorias.materiais') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							 <i class="mdi mdi-regex mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Categorias </h5>
							<label> Gerencie as categorias que estarão disponiveis para o cadastramento de materiais. </label>
						</div>
					</a>
				</div>
			</div>
			@endif

			@if(Auth::user()->RelationFuncao->gerenciar_configuracoes == 1)
			<h5 class="mx-5">E-mails</h5>
			<hr class="mt-0 mx-5">
			<div class="row col-12 justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.ajustes.emails') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-json mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Ajustes </h5>
							<label> Gerencie quais serão os remetentes responsáveis por receber as solicitações. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.mensagens.emails') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							 <i class="mdi mdi-email-outline mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Mensagens </h5>
							<label> Configure os conteúdos das mensagens que serão enviadas pela plataforma ao executarem as tarefas. </label>
						</div>
					</a>
				</div>
			</div>

			<h5 class="mx-5">Importações</h5>
			<hr class="mt-0 mx-5">
			<div class="row col-12 justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.importacoes') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-update mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Database </h5>
							<label> Analise as datas de atualização de cada um dos relatórios necessários para funcionamento da aplicação. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.importacoes') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-upload mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Importar </h5>
							<label> Execute a importação dos arquivos para atualização dos dados disponíveis na plataforma. </label>
						</div>
					</a>
				</div>
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.logs.importacoes') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-file-document mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Logs </h5>
							<label> Veja o andamento de cada uma das atualizações em tempo real, através dos registros. </label>
						</div>
					</a>
				</div>
			</div>
			
			<h5 class="mx-5">Plataforma</h5>
			<hr class="mt-0 mx-5">
			<div class="row col-12 justify-content-center mb-5 ml-3">
				<div class="row col-12 rounded m-3">
					<a href="{{ route('exibir.plataforma') }}" class="row mx-auto col-12 pr-0">
						<div class="col-3 col-sm-1 col-lg-1 border rounded row align-items-center shadow-sm justify-content-center my-auto" style="height: 50px">
							<i class="mdi mdi-eyedropper mdi-dark mdi-24px px-4"></i>
						</div>
						<div class="col-lg-11 col-sm-11 col-9 text-secondary mx-4 pr-0">
							<h5 class="mb-1 text-primary"> Ajustes </h5>
							<label> Altere as configurações da plataforma, como as imagens que estão disponíveis na tela de login e no fundo da homepage. </label>
						</div>
					</a>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection