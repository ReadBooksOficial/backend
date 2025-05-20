@extends('layouts.main')
@section('title', 'Read Books- Login')

@section('meta_title', 'Read Books- Login')
@section('meta_description', 'Faça login no Read Books')
@section('meta_keywords', 'livros, leitura, rede social, Read Books, login')
@section('meta_image', asset('img/estante_icon_fundo.png'))
@section('meta_url', url()->current())

@section('content')
    <div class="container container-login">
        <div class="col-5 col-left-login" style="overflow:hidden" >
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
        
        <div class="col-7 col-right-login">
            <form class="form-login" method="POST" action="/login">
                @csrf
                
                {{-- MENSAGEM DE CONTA CRIADA --}}
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible alert-account-create fade show" role="alert">
                        {{session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
    
                {{-- MENSAGEM DE CONTA NÃO CRIADA --}}
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible alert-account-create fade show" role="alert">
                        {{session('error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
    
                {{-- MENSAGEM DE CONTA CRIADA --}}
                @if(session()->has('conta-create-success'))
                    <div class="alert alert-success alert-dismissible alert-account-create fade show" role="alert">
                        <strong>Conta Criada!</strong> Entre com seu email e senha.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
    
                {{-- MENSAGEM DE CONTA NÃO CRIADA --}}
                @if(session()->has('conta-create-danger'))
                    <div class="alert alert-danger alert-dismissible alert-account-create fade show" role="alert">
                        <strong>Não foi possivel criar conta!</strong> Tente novamente mais tarde.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
    
    
                <h2 class="titulo-login">login</h2>
                    {{-- Email --}}
                    <div class="form-group mt-5">
                        {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label> --}}
    
                        <div class="col">
                            <input placeholder="Email ou nome de usuário" id="email" type="login" class="input-login form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" autocomplete="login" autofocus>

                            @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    {{-- Senha --}}
                    <div class="form-group mt-3">
                        {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label> --}}
    
                        <div class="col" style="position: relative">
                            <input placeholder="Senha" id="password" type="password" class="input-login form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" autocomplete="current-password">
                            {{-- IMAGEM DE VER SENHA --}}
                            <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
    
                        <div class="col">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Esqueci minha senha') }}
                                </a>
                            @endif
                        </div>
                    </div>
    
                    {{-- Manter logado --}}
                    <div class="form-group mt-5">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                <label class="form-check-label" for="remember">
                                    {{ __('Manter logado') }}
                                </label>
                            </div>
                        </div>
                    </div>
    
    
                    <div class="form-group">
                        <div class="col link-criar-conta">
    
                            {{-- Botao submit --}}
                            <button type="submit" class="btn btn-login">
                                {{ __('login') }}
                            </button>
    
                            {{-- Link pra criar conta --}}
                            <a class="link-criar-conta" href="{{route('register')}}">Não tem uma conta? Cadastre-se</a>
                        </div>
                    </div>
    
    
                </form>
    
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

<style>
    main{
        max-height: 100vh!important;
    }
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
            height: 165px;
        }

        .col-img-index:nth-child(1), .col-img-index:nth-child(3){
            margin-top: 50px;
        }

        .col-img-index:nth-child(2), .col-img-index:nth-child(4){
            margin-top: 30px;
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
            padding: 20px 10px !important;
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

