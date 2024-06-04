@extends('layouts.main')



@section('content')

<div class="container container-conta">

    <!-- NOTIFICACAO DE EDIÇÃO -->
    @if(session()->has('conta-update-success'))
        <!-- MENSAGEM DE CONTA ATUALIZADA-->
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
            <strong>Conta atualizada com sucesso!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- MENSAGEM DE CONTA NÃO ATUALIZADA-->
    @if(session()->has('conta-update-danger'))
        <div class="alert alert-danger alert-dismissible fade show " role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
            <strong>Não foi possível atualizar a conta.</strong> Tente novamente mais tarde.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- MENSAGEM DE COR NÃO ALTERADA-->
    @if(session()->has('conta-choose-color-danger'))
        <div class="alert alert-danger alert-dismissible fade show " role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
            <strong>Não foi possível mudar a cor do site.</strong> Tente novamente mais tarde.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    <!-- MENSAGEM DE COR ALTERADA-->
    @if(session()->has('conta-choose-color-success'))
        <div class="alert alert-success alert-dismissible fade show " role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
            <strong>Cor principal alterada com sucesso.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="form-conta" method="POST" action="/update-user">
                @csrf

                <h1 class="text-center" style="margin-bottom: 90px; font-size: 40px">Atualizar Conta</h1>
                <input id="id" type="text" class="form-control d-none" name="id" value="5" required>

                {{-- NOME --}}
                <div class="form-group row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>
                    <div class="col">
                        <input id="name" type="text" class="form-border-bottom-blue form-control form-control-login " name="name" value="{{auth()->user()->name}}" required autocomplete="name" autofocus="">
                    </div>

                    @error('name')
                        <span class="invalid-feedback" role="alert" style="display: block!important">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>



                {{-- EMAIl --}}
                <div class="form-group row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                    <div class="col">
                        <input id="email" type="email" class="form-border-bottom-blue form-control form-control-login @error('email') is-invalid @enderror" name="email" value="{{auth()->user()->email}}" required autocomplete="email">
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert" style="display: block!important">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- SENHA --}}
                <div class="form-group row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                    <div class="col">
                        <div style="position: relative;">
                            <input id="password" type="password" class="form-border-bottom-blue form-control form-control-login @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" required autocomplete="new-password">
                            {{-- IMAGEM DE VER SENHA --}}
                            <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                        </div>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" style="display: block!important" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                {{-- CONFIRMAR SENHA --}}
                <div class="form-group row mb-5">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar Senha</label>

                    <div class="col">
                        <div style="position: relative;">
                            <input id="password-confirm" type="password" class="form-border-bottom-blue form-control form-control-login" value="{{ old('password') }}" name="password_confirmation" required autocomplete="new-password">
                            {{-- IMAGEM DE VER SENHA --}}
                            <img class="view-password" id="view-password-confirm" src="{{asset('img/eye.svg')}}" onclick="showPasswordConfirm()" srcset="">
                        </div>
                    </div>

                    @error('password-confirm')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4" style="justify-content: space-between; display: flex">
                        <button type="submit" class="btn btn-atualizar-conta btn-blue" style="width: 70%">
                            Atualizar
                        </button>
                        <a href="/logout" class="btn btn-atualizar-conta btn-outline-danger" style="width: 25%">
                            Sair
                        </a>
                    </div>
                </div>
            </form>


{{-- 
            <form action="/choose-color" method="post">

                @csrf

                <div class="form-group row mb-0">

                    <div class="row">

                        <h3 style="margin-top: 50px">Definir cor principal</h3>

                    </div>

                    <div class="row">

                        <input value="{{auth()->user()->primary_color}}" type="color" class="form-control " name="primary_color" id="primary_color">

                        <button type="submit" class="btn btn-atualizar-conta btn-blue" style="margin-top: 20px">

                            Definir

                        </button>

                    </div>

                </div>

            </form> --}}

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

@endsection

