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

        <!-- Search input and Toggle icon -->
        <ul class="nav navbar-top-links navbar-left">
            <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
            <li>
                <a href="{{route('homepage')}}" title="Homepage">
                    <i class="mdi mdi-home-outline"></i>
                </a>
            </li>
            
            <!--
            <li class="dropdown">
                <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-gmail"></i>
                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                </a>
                <ul class="dropdown-menu mailbox animated bounceInDown">
                    <li>
                        <div class="drop-title">You have 4 new messages</div>
                    </li>
                    <li>
                        <div class="message-center">
                            <a href="#">
                                <div class="user-img"> <img src="{{asset('public/img/user.png')}}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                <div class="mail-contnet">
                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                            </a>
                            <a href="#">
                                <div class="user-img"> <img src="{{asset('public/img/user.png')}}" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                <div class="mail-contnet">
                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                            </a>
                            <a href="#">
                                <div class="user-img"> <img src="{{asset('public/img/user.png')}}" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                <div class="mail-contnet">
                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                            </a>
                            <a href="#">
                                <div class="user-img"> <img src="{{asset('public/img/user.png')}}" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                <div class="mail-contnet">
                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                            </a>
                        </div>
                    </li>
                    <li>
                        <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-check-circle"></i>
                    <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                </a>
                <ul class="dropdown-menu dropdown-tasks animated slideInUp">
                    <li>
                        <a href="#">
                            <div>
                                <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </li>-->
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">
            <!--
            <li>
                <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                    <input type="text" placeholder="Pesquise..." class="form-control"> 
                    <a href=""><i class="fa fa-search"></i></a> 
                </form>
            </li>-->
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
                    <li role="separator" class="divider"></li>
                    @endif

                    <li>
                        <a href="javascript:void(0)" class="logout">
                            <i class="fa fa-power-off pr-2"></i> Sair
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>