@extends('layouts.main')
@section('title', 'Read Books- Register')

@section('meta_title', 'Read Books- Registre-se')
@section('meta_description', 'Crie uma conta no Read Books')
@section('meta_keywords', 'livros, leitura, rede social, Read Books, registro, criar conta, cadastro')
@section('meta_image', asset('img/pacoca-sem-braco-rounded.png'))
@section('meta_url', url()->current())

@section('content')
    <div class="container container-login">
        <div class="col-7 col-left-register">
            <h2 class="titulo-login">Criar Conta</h2>
            <form class="form-register row" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nome --}}
                <div class="col-md-6 col-sm-6 mb-3">
                    <label for="name" class="text-md-right">{{ __('Nome') }}</label>

                    <div class="col">
                        <input id="name" type="text" class="input-login form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- Nome de usuário --}}
                <div class="col-md-6 col-sm-6 mb-3">
                    <label for="user_name" class="text-md-right">{{ __('Nome de usuário') }}</label>

                    <div class="input-group">
                        <span class="input-group-text" style="border: 0;">@</span>

                        <input id="user_name" type="text" class="input-login form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" autocomplete="off">

                        @error('user_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div id="passwordHelp" class="form-text">Deve começar com letra e conter apenas letras, números e sublinhados (_)</div>
                </div>

                {{-- Email --}}
                <div class="col-md-12  mb-3">
                    <label for="email" class="text-md-right">{{ __('Email') }}</label>

                    <div class="col">
                        <input id="email" type="email" class="input-login form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- Senha --}}
                <div class="col-md-6 mb-3">
                    <label for="password" class="col-md-4 text-md-right">{{ __('Senha') }}</label>

                    <div class="col" style="position: relative">
                        <input id="password" type="password" class="input-login form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" autocomplete="current-password">
                        {{-- IMAGEM DE VER SENHA --}}
                        <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div id="passwordHelp" class="form-text">Sua senha deve conter no mínimo 8 caracteres.</div>
                </div>

                {{-- Confirmar Senha --}}
                <div class="col-md-6 mb-3">
                    <label for="password-confirm" class="text-md-right">{{ __('Confirmar Senha') }}</label>

                    <div class="col" style="position: relative">
                        <input id="password-confirm" type="password" class="input-login form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="new-password">
                        {{-- IMAGEM DE VER SENHA --}}
                        <img class="view-password" id="view-password-confirm" src="{{asset('img/eye.svg')}}" onclick="showPasswordConfirm()" srcset="">
                    </div>
                </div>



                <div class="col mb-3 mt-3">
                    <input class="form-check-input" type="checkbox" {{ old('termos') ? 'checked' : '' }} name="termos"  id="termos">

                    <label class="form-check-label" for="termos">
                        Concordo com os
                        <input class="link" type="button" data-bs-toggle="modal" data-bs-target="#modal-termos-de-uso" value="termos de uso"/> e as
                        <input class="link" type="button" data-bs-toggle="modal" data-bs-target="#modal-politicas-de-privacidade" value="diretrizes"/>
                        do Paçoca
                    </label>

                    @error('termos')
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                {{-- Criar Conta --}}
                <div class="form-group mt-5">
                    <div class="col link-criar-conta">
                        <button type="submit" class="btn btn-login">
                            {{ __('Criar Conta') }}
                        </button>

                        <a class="link-criar-conta" href="{{route('login')}}">Já tem uma conta? Faça Login</a>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Esqueci minha senha') }}
                            </a>
                        @endif
                    </div>
                </div>

            </form>
            </div>

        <div class="col-5 col-right-register div-text-register" style="overflow: hidden;">
            {{-- <h1>Bem Vindo</h1>
            <p>Faça login e acesse seus livros</p> --}}
            <div class="div img-index" style="position: relative;">
                <div class="col col-img-index">
                    <img class="img-index" src="{{asset('img_index/1984.webp')}}">
                    <img class="img-index" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - maldicao do tita.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                </div>
                <div class="col col-img-index">
                    <img class="img-index" src="{{asset('img_index/percy - a maldicao do tita 2.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/herry - a pedra filosofal.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/harry - a ordem de fenix.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/harry - enigma do principe.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/assim que acaba.jpeg')}}">
                </div>

                <div class="col col-img-index">
                    <img class="img-index" src="{{asset('img_index/percy - e os olimpianos.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/biblioteca da meia noite.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - a batalha do labirinto.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/diario de anne frank.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/harry - prsioneiro de azkaban.jpg')}}">
                </div>

                <div class="col col-img-index">
                    <img class="img-index" src="{{asset('img_index/harry - o calice de fogo.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - ladrao de raios.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/harry - e a camara secreta.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/harry - as reliquias da morte.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/biblioteca da meia noite.jpg')}}">
                </div>

                <div class="col col-img-index">
                    <img class="img-index" src="{{asset('img_index/1984.webp')}}">
                    <img class="img-index" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - maldicao do tita.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                    <img class="img-index" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                </div>
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

<!-- MODAL DE TERMOS DE USO -->
<div class="modal fade" style="overflow: hidden" id="modal-termos-de-uso" tabindex="-1" aria-labelledby="modal-termos-de-uso" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-termos-de-uso">Termos de uso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="max-height: 80vh!important; overflow: auto">
            @include('components.termos-uso')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" data-bs-dismiss="modal" id="btnCheck" class="btn btn-blue">Aceitar</button>
        </div>
        </div>
    </div>
</div>

{{-- MODAL DE POLITICAS SE PRIVACIDADE --}}
<div class="modal fade" style="overflow: hidden" id="modal-politicas-de-privacidade" tabindex="-1" aria-labelledby="modal-politicas-de-privacidade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-politicas-de-privacidade">Diretrizes</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="max-height: 80vh!important; overflow: auto">
            @include('components.diretrizes')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" data-bs-dismiss="modal" id="btnCheck" class="btn btn-blue">Aceitar</button>
        </div>
        </div>
    </div>
</div>

<style>
    nav{
        z-index: 9!important;
    }
    .col-img-index{
        /* position: absolute; */
        gap: 5px;
        display: flex;
        flex-direction: column;
        z-index: 5;
    }

    .col-img-index:nth-child(1){
        margin-top: 0px;
    }

    .col-img-index:nth-child(2){
        margin-top: 40px;
    }

    .col-img-index:nth-child(3){
        margin-top: 0px;
    }

    .col-img-index:nth-child(4){
        margin-top: 40px;
    }
    .col-img-index:nth-child(5){
        margin-top: 0px;
    }

    .img-index{
        height: 200px;
        border-radius: 7px;
        display: flex;
        gap: 5px;
    }

    .row-index, .container-index{
        /* overflow: hidden !important; */
        position: relative;
    }



    @media (max-width: 1175px) {
        .img-index{
            /* height: 229.3; */
            /* 229,3; */
            height: 250px;
            /* height: 351.15; */
        }


        .col-img-index:nth-child(1){
            top: -250px;
            right: 170px;
        }

        .col-img-index:nth-child(2){
            top: -200px;
        }

        .col-img-index:nth-child(3){
            top: -250px;
            right: -170px;
        }

        .col-img-index:nth-child(4){
            top: -200px;
            right: -350px;
        }
    }

    @media (max-width: 890px) {
        .img-index{
            height: 200px;
        }
        .col-img-index:nth-child(1){
            display: grid;
            right: 280px;
            top: -50;
        }

        .col-img-index:nth-child(2){
            top: -250px;
            right: 100px
        }

        .col-img-index:nth-child(3){
            right: -50px;
            top: -150px;
        }

        .col-img-index:nth-child(4){
            top: -250px;
            right: -200px
        }
    }

    @media (max-width: 790px) {
        .col-img-index:nth-child(1){
            display: none;
        }
    }

    @media (max-width: 480px) {
        .col-index{
            position: relative;
            height: 100vh;
            overflow: hidden;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }


        .container {
            max-width: 95% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .col-btn-home{
            padding: 200px 20px 0 20px!important;
        }

        .col-img-index:nth-child(1){
            display: grid;
        }

        .col-btn-home{
            margin-top: -200px !important;
            min-width: 100%!important;
            height: 500px;
        }

        .col-img-index:nth-child(1){
            top: 200px;
            right: 400px
        }

        .col-img-index:nth-child(2){
            top: 90px;
            right: 245px
        }

        .col-img-index:nth-child(3){
            top: 200px;
            right: 90px;
        }

        .col-img-index:nth-child(4){
            top: 90px;
            right: -60px;
        }

        .main-index{
            overflow: auto;
        }
    }

    @media (max-width: 450px) {
        .img-index{
            height: 170px;
        }

        .col-img-index:nth-child(1){
            top: 200px;
            left: -40;
        }

        .col-img-index:nth-child(2){
            top: 90px;
            left: 90px;
            right: auto;
        }

        .col-img-index:nth-child(3){
            top: 200px;
            right: 80px;
        }

        .col-img-index:nth-child(4){
            top: 90px;
            right: -40;
        }
    }

    @media (max-width: 395px) {

        .col-btn-home {
            margin-top: 0px !important;
            height: auto;
        }

        .col-img-index:nth-child(1){
            top: 150px;
            left: -50;
        }

        .col-img-index:nth-child(2){
            top: 50px;
            left: 70px;
            right: auto;
        }

        .col-img-index:nth-child(3){
            top: 150px;
            right: 70px;
        }

        .col-img-index:nth-child(4){
            top: 50;
            right: -50;
        }


        .col-index {
            padding: 0 10px !important;
        }
    }

    @media (max-width: 365px) {
        .img-index{
            height: 150px;
        }
    }

    @media (max-width: 340px) {
        .img-index{
            height: 120px;
        }

        .col-img-index:nth-child(1){
            left: 0;
        }

        .col-img-index:nth-child(2){
            left: 90px;
        }

        .col-img-index:nth-child(3){
            right: 90px;
        }

        .col-img-index:nth-child(4){
            right: 0;
        }

        @media (max-width: 320px) {
            .col-img-index:nth-child(3){
                display: none;
            }
        }
    }
</style>

@endsection

