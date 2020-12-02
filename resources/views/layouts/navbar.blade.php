<nav class="navbar navbar-default navbar-static-top p-0">
    <div class="navbar-header">

        <!-- Logo -->
        <div class="top-left-part text-center">
            <a class="logo-min mx-4" href="{{ route('inicio') }}">
                <img src="{{asset('public/img/favicon.png').'?'.rand()}}" alt="logo" height="45"/>
            </a>
            <a class="logo" href="{{ route('inicio') }}">
                <img src="{{asset('public/img/logo.png').'?'.rand()}}" alt="logo" height="40"/>
            </a>
        </div>
        <!-- /Logo -->

        <!-- Homepage -->
        <ul class="nav navbar-top-links navbar-left">
            <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
            <li>
                <a href="{{route('homepage')}}" title="Homepage">
                    <i class="mdi mdi-home-outline"></i>
                </a>
            </li>
            
        </ul>
        <!-- /Homepage -->

        <!-- Perfil e notificações -->
        <ul class="nav navbar-top-links navbar-right pull-right">
            <!-- Notificações 
            <li class="dropdown">
                <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-bell-outline"></i>
                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                </a>
                <ul class="dropdown-menu mailbox animated bounceInDown">
                    <li>
                        <div class="drop-title">4 novas notificações</div>
                    </li>
                    <li>
                        <div class="message-center">
                            <a href="#">
                                <div class="user-img img-circle bg-light text-center text-dark" style="padding-top: 8px;padding-bottom: 8px;"> <i class="mdi mdi-plus mdi-18px"></i>  </div>
                                <div class="mail-contnet">
                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                            </a>
                            <a href="#">
                                <div class="user-img img-circle bg-light text-center text-dark" style="padding-top: 8px;padding-bottom: 8px;"> <i class="mdi mdi-pencil mdi-18px"></i>  </div>
                                <div class="mail-contnet">
                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                            </a>
                            <a href="#">
                                <div class="user-img img-circle bg-light text-center text-dark" style="padding-top: 8px;padding-bottom: 8px;"> <i class="mdi mdi-close mdi-18px"></i>  </div>
                                <div class="mail-contnet">
                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                            </a>
                            <a href="#">
                                <div class="user-img img-circle bg-light text-center text-dark" style="padding-top: 8px;padding-bottom: 8px;"> <i class="mdi mdi-delete mdi-18px"></i>  </div>
                                <div class="mail-contnet">
                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                            </a>
                        </div>
                    </li>
                    <li>
                        <a class="text-center" href="javascript:void(0);"> <strong>Veja todas notificações</strong> <i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </li> 
            /Notificações -->

            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> 
                    <img src="{{(isset(Auth::user()->RelationImagem) ? asset('storage/app/'.Auth::user()->RelationImagem->endereco) : asset('public/img/user.png'))}}" alt="Imagem usuário" width="36" height="36" class="img-circle">
                    <b class="hidden-xs">{{explode(" ", ucfirst(strtolower(Auth::user()->RelationAssociado->nome)))[0]}}</b>
                    <span class="caret"></span> 
                </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <div class="dw-user-box">
                            <div class="col-3 p-0 u-img">
                                <img src="{{(isset(Auth::user()->RelationImagem) ? asset('storage/app/'.Auth::user()->RelationImagem->endereco) : asset('public/img/user.png'))}}" alt="user" />
                            </div>
                            <div class="col-8 pr-0 u-text">
                                <h4 class="text-capitalize text-truncate">{{ strtolower(Auth::user()->RelationAssociado->nome) }} </h4>
                                <p class="text-muted">{{ strtolower(Auth::user()->login) }}</p>
                            </div>
                        </div>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{{route('perfil')}}">
                            <i class="ti-user pr-2"></i> Meu perfil
                        </a>
                    </li>
                    <li>
                        <a href="{{route('atividades')}}">
                        <i class="ti-layers-alt pr-2"></i> Minhas atividades
                        </a>
                    </li>
                    <li>
                        <a href="#">
                        <i class="ti-comment-alt pr-2"></i> Minhas notificações
                        </a>
                    </li>

                    <li role="separator" class="divider"></li>
                    
                    @if(Auth::user()->RelationFuncao->ver_configuracoes || Auth::user()->RelationFuncao->gerenciar_configuracoes)
                    <li>
                        <a href="{{route('configuracoes')}}">
                            <i class="ti-settings pr-2"></i> Configurações
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="javascript:" class="sobre">
                            <i class="ti-info pr-2"></i> Sobre
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>

                    <li>
                        <a href="javascript:" class="logout">
                            <i class="fa fa-power-off pr-2"></i> Sair
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- /Perfil e notificações -->
    </div>
</nav>