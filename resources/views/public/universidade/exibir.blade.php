@section('title')
Sicoob Universidade
@endsection

@include('layouts.header')

@include('layouts.preloader')

<div class="col-12 h-100 position-absolute imagem" style="background: url({{ (isset($homepage[0]) ? asset('storage/app/').'/'.$homepage->last()->endereco : asset('public/img/home.png').'?'.rand())}})"></div>
    <div class="container-fluid h-100 row justify-content-center mx-auto">
        <div class="col-12 row mx-auto px-lg-5 pt-5">
            <div class="col-lg-5 col-sm-4 col-6 px-0 row mx-auto justify-content-center">
                <img src="{{ asset('public/img/logo.png').'?'.rand() }}" class="col-lg-4 col-sm-5 col-xl-5 col-12 px-0 h-75 h-lg-100">
            </div>
        </div>
        
        <div class="row col-12 col-sm-11 col-lg-11 mx-auto py-5 justify-content-center text-left">
            <div class="col-lg-8 col-12 px-0 px-lg-4 mb-4">
                <div class="mx-2 mb-4 p-4 shadow h-100" style="background-color: white; border-radius: 10px">
                    <div class="text-center pb-5">
                        <h3>Olá, seja bem-vindo!</h3>
                        <p> Para que possa acessar o Sicoob Universidade precisamos seguir os passos listados abaixo:</p>
                    </div>
                    <ul class="px-5" style="line-height: 30px">
                        <li><b>1.</b> Baixar o arquivo para conexão o computador, <a href="{{asset('storage/app/documentos/cursos.rdp')}}" download>clicando aqui.</a></li>
                        <li><b>2.</b> Em seguida, aceite a conexão clicando em <b>Conectar</b>.</li>
                        <li><b>3.</b> O próximo passo é validar a conexão, utilizando a senha <b>Sicoob@4133</b>.</li>
                        <li><b>4.</b> Após logar na máquina, abra o Google Chrome. Insira suas credências do Sisbr e em seguida, valide o Qrcode com seu dispositivo.</li>
                    </ul>
                </div>
            </div>
        </div>  
    </div>
</div>

@include('layouts.footer')
