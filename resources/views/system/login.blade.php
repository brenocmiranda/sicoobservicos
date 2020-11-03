@section('title')
Login
@endsection

@include('layouts.header')             
<div class="container-fluid p-0">
  <div class="row vh-100">

    <div class="col-8 d-none d-lg-block" style="background: url('{{(isset($login[0]) ? asset('storage/app/').'/'.$login->last()->endereco : asset('public/img/logo.png').'?'.rand())}}'); background-size: 100% 100%; height: inherit; background-position: center; /*filter: brightness(0.6);*/">
    </div>

    <div class="content-wrapper col-12 col-lg-4 p-5">
      <div class="text-center">
        <!-- Logomarca -->
        <img src="{{asset('public/img/logo.png').'?'.rand()}}" class="my-5 pb-5" style="width:16em">

        <!-- Form -->
        <div class="col-12 mt-5">
          @if($errors->any())
          <div class="mx-3 col-sm-11 alert alert-danger font-weight-normal">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
          </div>
          @endif

          @if(Session::has('login'))
          <div class="mx-3 col-sm-11 rounded alert alert-{{ Session::get('login')['class'] }}">
            {{ Session::get('login')['mensagem'] }}
          </div>
          @endif
          <form method="POST" action="{{ route('redirect') }}" id="formLogin">
            @csrf
            <div class="form-group col-12">
              <div class="input-group">
                <span class="input-group-addon bg-white border-bottom border-left-0 border-top-0">
                  <i class="ti-user"></i> 
                </span>
                <input type="text" class="login form-control form-control-line floating-labels @error('login') is-invalid @enderror" placeholder="Usuário" name="login" style="font-size: 13px;" required>
              </div>
            </div>                    
            <div class="form-group col-12">
              <div class="input-group">
                <span class="input-group-addon bg-white border-bottom border-left-0 border-top-0">
                  <i class="ti-key"></i> 
                </span>
                <input type="password" class="password form-control form-control-line floating-labels @error('password') is-invalid @enderror" placeholder="Senha" name="password" style="font-size: 13px;" autocomplete="off" required>
              </div>
            </div>
            <div class="col text-left pb-4">
              <p>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-solicitar" class="redefinir">Esqueceu sua senha?</a>
              </p> 
            </div> 

            <div class="form-group col-12 py-4">
              <button type="submit" class="btn btn-success btn-lg d-flex ml-auto waves-effect waves-light">
                <span class="my-auto px-2">Entrar</span>
                <i class="mdi mdi-arrow-right px-2"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
      <footer class="col-12 footer text-center"> 
        <div>
          <label>2020 © GTI Sicoob Sertão Minas <b>&#183</b> v.1.1</label>
          <br>
          <a href="{{route('homepage')}}" target="_blank">Homepage</a> 
          <b>&#183</b>
          <a href="http://www.sicoobsertaominas.com.br" target="_blank">Website</a> 
        </div>
      </footer>
    </div>
  </div>
</div> 

@include('system.solicitar')

@section('suporte')
<script type="text/javascript">
  $(document).ready(function (){
        $('.redefinir').on('click', function(e){
          $('#err').html('');
          $('.login').val('');
          $('.carregamento').html('');
          $('#modal-solicitar #formSolicitar').removeClass('d-none');
        });

         // Enviando email de recuperação
        $('#modal-solicitar #formSolicitar').on('submit', function(e){
          e.preventDefault();
          $.ajax({
            url: '{{ route("recuperar.password") }}',
            type: 'POST',
            data: $('#modal-solicitar #formSolicitar').serialize(),
            beforeSend: function(){
              $('input[name="login"]').removeClass('border border-bottom-danger');
              $('#err').html('');
              $('#modal-solicitar #formSolicitar').addClass('d-none');
              $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Enviando e-mail de recuperação...</label></div>');
            },
            success: function(data){
              if(data.success == true){
                setTimeout(function(){
                  $('.carregamento').html('<div class="row col-12 mx-auto text-center my-5 justify-content-center"><div class="col-sm-12 col-md-12 col-lg-12"><i class="mdi mdi-check-all my-3 text-success" style="font-size:62px;"></i></div><h5>E-mail enviado com sucesso!</h5><label class="mx-4">Verifique o recebimento da mensagem na sua <b>caixa de entrada ou na área de spam</b>. Caso não esteja recebendo o e-mail de redefinição, entre em contato com o administrador.</label><div class="col-12 mt-5 text-center"><hr><button type="button" class="btn btn-danger btn-outline btn-lg shadow-none col-4" data-dismiss="modal" aria-label="Close">Fechar</button></div></div> ');
                }, 800);
              }else{
                setTimeout(function(){
                  $('#modal-solicitar #formSolicitar').removeClass('d-none');
                  $('.carregamento').html('');
                  $('#modal-solicitar #err').html('<div class="alert alert-danger mx-2">Nenhum usuário foi encontrado.</div>');
                  $('#modal-solicitar input[name="login"]').addClass('border border-bottom-danger');
                }, 800);
              }
            }, error: function (data) {
              setTimeout(function(){
                $('#modal-solicitar #formSolicitar').removeClass('d-none');
                $('.carregamento').html('');
                $('#modal-solicitar #err').html('<div class="alert alert-danger mx-2"Encontramos um problema ao solicitar sua senha, tente novamente. Caso persista, entre em contato com o administrador.</div>');
                $('#modal-solicitar input[name="login"]').addClass('border border-bottom-danger');
              }, 800);
            }
          });
        });
       });
     </script>
     @endsection

     @include('layouts.footer')
