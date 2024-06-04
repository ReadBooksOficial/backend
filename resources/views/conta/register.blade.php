@extends('layouts.main')



@section('content')

    <div class="container container-login">

        <div class="col-7 col-left-register" style="margin-top: -10px!important">
            <h1>Criar Conta</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    {{-- NOME --}}
                    <div class="form-group row mb-3">
                        <div class="col">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                            <input id="name" type="text" class="form-border-bottom-blue form-control form-control-login @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group row mb-3">
                        <div class="col">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <input id="email" type="text" class="form-border-bottom-blue form-control form-control-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- SENHA --}}
                    <div class="form-group row mb-3">
                        <div class="col-">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>
                            <div style="position: relative;">
                                <input id="password" type="password" class="form-border-bottom-blue form-control form-control-login @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" autocomplete="new-password">
                                {{-- IMAGEM DE VER SENHA --}}
                                <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert" style="display: block!important">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- CONFIRMAR SENHA --}}
                    <div class="form-group row mb-3">
                        <div class="col">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Senha') }}</label>
                            
                            <div style="position: relative;">
                                <input id="password-confirm" type="password" class="form-border-bottom-blue form-control form-control-login" value="{{ old('password') }}" name="password_confirmation" autocomplete="new-password">
                                {{-- IMAGEM DE VER SENHA --}}
                                <img class="view-password" id="view-password-confirm" src="{{asset('img/eye.svg')}}" onclick="showPasswordConfirm()" srcset="">
                            </div>
                        </div>
                    </div>
    
                    <button type="submit" class="btn btn-register  btn-blue">
                        {{ __('Criar Conta') }}
                    </button>
                    <div class="row" style="margin-top: 15px!important; text-align: center;">
                        <div class="col">
                            <a href="/login">Já tem conta? Faça login</a>
                        </div>
                    </div>
                </form>
            </div>

        <div class="col-5 col-right-register div-text-register">
            <h1>Bem Vindo</h1>
            <p>Faça login e acesse seus livros</p>
        </div>
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
    //BOTÃO PARA MOSTRAR SENHA    
    function showPasswordConfirm() {//Botao de olho para mostrar e esconder a senha (pagina entrar)
        var senha = document.querySelector("#password-confirm");
        var imgShow = document.querySelector("#view-password-confirm");
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

