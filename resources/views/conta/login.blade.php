@extends('layouts.main')



@section('content')
    <div class="container container-login">
        <div class="col-5 col-left-login">
            <h1>Bem Vindo</h1>
            <p>Faça login e acesse seus livros</p>
        </div>
        <div class="col-7 col-right-login">
            <!-- NOTIFICACAO DE CRIAR CONTA -->
            @if(session()->has('conta-create-success'))
                <!-- MENSAGEM DE CONTA ATUALIZADA-->
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                    <strong>Conta criada com sucesso!</strong> Entre com seu email e senha.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- MENSAGEM DE CONTA NÃO CRIADA-->
            @if(session()->has('conta-create-danger'))
                <div class="alert alert-danger alert-dismissible fade show " role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                    <strong>Não foi possível criar uma conta.</strong> Tente novamente mais tarde.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            

            <h1>Login</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group row mb-3">
                {{-- EMAIL --}}
                <div class="col col-input-login">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                    <input id="email" type="text" class="form-border-bottom-blue form-control form-control-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- SENHA --}}
            <div class="form-group row mb-5">
                <div class="col col-input-login" style="position: relative;">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                    <div style="position: relative;">
                        <input id="password" type="password" class="form-border-bottom-blue form-control form-control-login @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" autocomplete="current-password">
                        {{-- IMAGEM DE VER SENHA --}}
                        <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert" style="display: block!important;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Lembrar conta') }}
                        </label>
                    </div>
                </div>
            </div>
            
                <button type="submit" class="btn  btn-blue btn-login">
                    {{ __('Login') }}
                </button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
                <div class="row" style="margin-top: 15px!important; text-align: center;">
                    <div class="col">
                        <a href="/register">Não tem conta? Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>

        </form>

    </div>



    <script>

        //BOTÃO PARA MOSTRAR SENHA    

        function showPassword() {//Botao de olho para mostrar e esconder a senha (pagina entrar)

            var senha = document.querySelector("#password");

            var imgShow = document.querySelector("#view-password");

            if (senha.type === "password") {

            senha.type = "text";

            imgShow.src = "../img/eye-off.svg"

            } else {

            senha.type = "password";

            imgShow.src = "../img/eye.svg"

            }

        }

    </script>

@endsection

