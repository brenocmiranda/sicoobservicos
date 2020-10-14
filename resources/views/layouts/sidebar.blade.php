<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav slimscrollsidebar">
    <div class="sidebar-head">
      <h3>
        <span class="fa-fw open-close">
          <i class="ti-close ti-menu"></i>
        </span> 
        <span class="hide-menu">Menu</span>
      </h3> 
    </div>
    <div class="user-profile">
      <hr class="mx-5 mt-0">
      <div class="user-pro-body my-3">
        <div>
          <img src="{{(isset(Auth::user()->RelationImagem) ? asset('storage/app/'.Auth::user()->RelationImagem->endereco).'?'.rand() : asset('public/img/user.png').'?'.rand())}}" alt="Imagem usuário" class="rounded-circle">
        </div>
        <label class="d-block text-capitalize text-truncate font-weight-bold mb-0 px-5">{{ strtolower(Auth::user()->RelationAssociado->nome) }}</label>
        <small class="d-block text-capitalize py-2">{{ strtolower(Auth::user()->RelationSetor->nome) }}</small>
        <small class="badge badge-light border border-dark text-dark font-weight-bold">{{ strtolower(Auth::user()->RelationFuncao->nome) }}</small>
      </div>
    </div>

    <ul class="nav" id="side-menu">
      <li> 
        <a href="{{route('inicio')}}" class="waves-effect {{ (Request::segment(2) == 'home' ? 'active' : '') }}">
          <i class="mdi mdi-home-variant pr-3"></i> 
          <span class="hide-menu">Inicio</span>
        </a> 
      </li>

      @if(Auth::user()->RelationFuncao->ver_administrativo == 1 || Auth::user()->RelationFuncao->gerenciar_administrativo)
      <li> 
        <a href="#" class="waves-effect {{ (Request::segment(2) == 'gti' ? 'active' : '') }}">
          <i class="mdi mdi-bank pr-3" data-icon="v"></i> 
          <span class="hide-menu"> Administrativo <span class="fa arrow"></span> </span>
        </a>
        <ul class="nav nav-second-level">
          <li> <a href="{{route('dashboard.administrativo')}}"><span class="hide-menu">Dashboard</span></a> </li>
          <li> <a href="{{route('exibir.solicitacoes.administrativo')}}"><span class="hide-menu">Materiais</span></a> </li>
        </ul>
      </li>
      @endif

      @if(Auth::user()->RelationFuncao->ver_credito == 1 || Auth::user()->RelationFuncao->gerenciar_credito)
      <li> 
        <a href="#" class="waves-effect">
          <i class="mdi mdi-currency-usd pr-3" data-icon="v"></i> 
          <span class="hide-menu"> Crédito <span class="fa arrow"></span> </span>
        </a>
        <ul class="nav nav-second-level">
          <li> <a href="{{route('dashboard.credito')}}"><span class="hide-menu">Dashboard</span></a> </li>
          <li> <a href="{{ route('exibir.disposicao.credito') }}"><span class="hide-menu">Disposição</span></a> </li>
          <li> <a href="{{ route('exibir.contratos.credito') }}"><span class="hide-menu">Contratos</span></a> </li>
          <li> <a href="{{ route('exibir.garantias.credito')}}"><span class="hide-menu">Garantias</span></a> </li>
          <li> <a href="#"><span class="hide-menu">Solicitações</span></a> </li>
        </ul>
      </li>
      @endif

      <li> 
        <a href="#" class="waves-effect {{ (Request::segment(2) == 'suporte' ? 'active' : '') }}">
          <i class="mdi mdi-hangouts pr-3" data-icon="v"></i> 
          <span class="hide-menu"> Suporte <span class="fa arrow"></span> </span>
        </a>
        <ul class="nav nav-second-level {{ (Request::segment(2) == 'suporte' ? 'collapse in' : '') }}">
          <li> <a href="{{route('exibir.base')}}"><span class="hide-menu">Aprendizagem</span></a> </li>
          <li> <a href="{{route('exibir.chamados')}}"><span class="hide-menu">Chamados</span></a> </li>
          <li> <a href="{{route('exibir.documentos')}}"><span class="hide-menu">Documentos</span></a> </li>
          <li> <a href="{{route('exibir.solicitacoes.materiais')}}"><span class="hide-menu">Materiais</span></a> </li>
        </ul>
      </li>

      @if(Auth::user()->RelationFuncao->ver_gti == 1 || Auth::user()->RelationFuncao->gerenciar_gti)
      <li> 
        <a href="#" class="waves-effect {{ (Request::segment(2) == 'gti' ? 'active' : '') }}">
          <i class="mdi mdi-dns pr-3" data-icon="v"></i> 
          <span class="hide-menu"> Tecnologia <span class="fa arrow"></span> </span>
        </a>
        <ul class="nav nav-second-level">
          <li> <a href="{{route('dashboard.gti')}}"><span class="hide-menu">Dashboard</span></a> </li>
          <li> <a href="{{route('exibir.chamados.gti')}}"><span class="hide-menu">Chamados</span></a> </li>
          <li> <a href="{{route('exibir.ativos')}}"><span class="hide-menu">Equipamentos</span></a> </li>
          <li> <a href="{{route('exibir.homepage')}}"><span class="hide-menu">Homepage</span></a> </li>
          <li> <a href="#"><span class="hide-menu">Relatórios</span></a> </li>
        </ul>
      </li>
      @endif

      @if(Auth::user()->RelationFuncao->ver_configuracoes == 1 || Auth::user()->RelationFuncao->gerenciar_configuracoes)
      <li> 
        <a href="javascript:void(0)" class="waves-effect {{ (Request::segment(2) == 'gestao' ? 'active' : '') }}">
          <i class="mdi mdi-settings pr-3"></i> 
          <span class="hide-menu">Configurações<span class="fa arrow"></span></span>
        </a>
        <ul class="nav nav-second-level {{ (Request::segment(2) == 'gestao' ? 'collapse in' : '') }}">
          <li> 
            <a href="javascript:void(0)" class="waves-effect">
              <span class="hide-menu">Administrativo </span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-third-level {{ (Request::segment(2) == 'gestao' && Request::segment(3) == 'administrativo' ? ' collapse in' : '') }}">
              <li> <a href="{{route('exibir.funcoes.administrativo')}}"><span class="hide-menu">Funções</span></a> </li>
              <li> <a href="{{route('exibir.instituicoes.administrativo')}}"><span class="hide-menu">Instituições</span></a> </li>
              <li> <a href="{{route('exibir.setores.administrativo')}}"><span class="hide-menu">Setores</span></a> </li>
              <li> <a href="{{route('exibir.unidades.administrativo')}}"><span class="hide-menu">Unidades</span></a> </li>
              <li> <a href="{{route('exibir.usuarios.administrativo')}}"><span class="hide-menu">Usuários</span></a> </li>
            </ul>
          </li>

          <li> 
            <a href="{{route('exibir.base.aprendizagem')}}" class="waves-effect {{ (Request::segment(2) == 'gestao' && Request::segment(3) == 'aprendizagem' ? ' collapse in' : '') }}">
              <span class="hide-menu">Aprendizagem</span>
            </a> 
          </li>

          <li> 
            <a href="javascript:void(0)" class="waves-effect">
              <span class="hide-menu">Chamados </span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-third-level {{ (Request::segment(2) == 'gestao' && Request::segment(3) == 'chamados' ? ' collapse in' : '') }}">
              <li> <a href="{{route('exibir.fontes.chamados')}}"><span class="hide-menu">Fontes</span></a> </li>
              <li> <a href="{{route('exibir.tipos.chamados')}}"><span class="hide-menu">Tipos</span></a> </li>
              <li> <a href="{{route('exibir.status.chamados')}}"><span class="hide-menu">Status</span></a> </li>
            </ul>
          </li>

          <li> 
            <a href="javascript:void(0)" class="waves-effect">
              <span class="hide-menu">Crédito </span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-third-level {{ (Request::segment(2) == 'gestao' && Request::segment(3) == 'credito' ? ' collapse in' : '') }}">
              <li> <a href="{{route('exibir.armarios.credito')}}"><span class="hide-menu">Armários</span></a> </li>
              <li> <a href="{{route('exibir.finalidades.credito')}}"><span class="hide-menu">Finalidades</span></a> </li>
              <li> <a href="{{route('exibir.modalidades.credito')}}"><span class="hide-menu">Modalidades</span></a> </li>
              <li> <a href="{{route('exibir.produtos.credito')}}"><span class="hide-menu">Produtos</span></a> </li>

            </ul>
          </li>

          <li> 
            <a href="{{route('exibir.todos.documentos')}}" class="waves-effect">
              <span class="hide-menu">Documentos</span>
            </a> 
          </li>

          <li> 
            <a href="javascript:void(0)" class="waves-effect {{ (Request::segment(2) == 'gestao' && Request::segment(3) == 'documentos' ? ' collapse in' : '') }}">
              <span class="hide-menu">E-mails </span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-third-level {{ (Request::segment(2) == 'gestao' && Request::segment(3) == 'emails' ? ' collapse in' : '') }}">
              <li> <a href="{{route('exibir.ajustes.emails')}}"><span class="hide-menu">Ajustes</span></a> </li>
              <li> <a href="{{route('exibir.mensagens.emails')}}"><span class="hide-menu">Conteúdos</span></a> </li>
            </ul>
          </li>

          <li> 
            <a href="javascript:void(0)" class="waves-effect">
              <span class="hide-menu">Materiais </span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-third-level {{ (Request::segment(2) == 'gestao' && Request::segment(3) == 'materiais' ? ' collapse in' : '') }}">
              <li> <a href="{{route('exibir.todos.materiais')}}"><span class="hide-menu">Todos</span></a> </li>
              <li> <a href="{{route('exibir.categorias.materiais')}}"><span class="hide-menu">Categorias</span></a> </li>
            </ul>
          </li>

        </ul>
      </li>
      @endif

    </ul>
  </div>
</div>