<!--
    "PRA QUE SERVE
    TANTO CÓDIGO
    SE A VIDA
    NÃO É PROGRAMADA
    E AS MELHORES COISAS
    NÃO TEM LÓGICA".
    Algúem (algum ano)
-->
{{-- VERIFICA SE É ADMINISTRADOR OU NÃO --}}
@php
  $userController = new App\Http\Controllers\UserController();
  $isAdmin =  $userController->isAdmin();
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
     <script src="https://unpkg.com/feather-icons"></script>
     <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/style.css?v=18')}}">
    <link rel="stylesheet" href="{{asset('css/navbar-pc.css')}}">
    <link rel="stylesheet" href="{{asset('css/vars.css?v=16')}}">
    <link rel="shortcut icon" href="{{asset('img/estante_icon_fundo.png')}}" type="image/x-icon">
    <link href="{{asset('bootstrap-5.0.0/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_css_bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="{{asset('bootstrap-5.0.0/cdn.jsdelivr.net_npm_@popperjs_core@2.9.2_dist_umd_popper.min.js')}}" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="{{asset('bootstrap-5.0.0/cdn.jsdelivr.net_npm_bootstrap@5.0.2_dist_js_bootstrap.min.js')}}" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <meta name="description" content="@yield('meta_description', 'Read Books é um sistema de gerenciamento de leitura, onde você pode compartilhar o status da sua leitura!')">
    <meta name="keywords" content="@yield('meta_keywords', 'Read Books, rede social, fazer amigos, conexões online, comunidade digital, rede social brasileira, criar perfil online, compartilhar momentos, paçoca')">
    <meta name="author" content="Read Books Inc.">

    <meta property="og:title" content="@yield('title', 'Read Books - Gerencie e compartilhe sua leitura')">
    <meta property="og:description" content="@yield('meta_description', 'Read Books é um sistema de gerenciamento de leitura, onde você pode compartilhar o status da sua leitura!')">
    <meta property="og:image" content="@yield('meta_image', asset('img/estante_icon_fundo.png'))">
    <meta property="og:url" content="@yield('meta_url', url()->current())">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', 'Read Books - Gerencie e compartilhe sua leitura')">
    <meta name="twitter:description" content="@yield('meta_description', 'Read Books é um sistema de gerenciamento de leitura, onde você pode compartilhar o status da sua leitura!')">
    <meta name="twitter:image" content="@yield('meta_image', asset('img/estante_icon_fundo.png'))">
</head>
<body>

<script>
        const savedMode = localStorage.getItem('dark-mode');
        const isDarkMode = savedMode == "true";
        localStorage.setItem('dark-mode', JSON.stringify(isDarkMode));

        // Adiciona ou remove a classe 'dark' no root
        if (isDarkMode) {
            document.documentElement.classList.add('dark'); // Adiciona a classe 'dark'
            document.documentElement.classList.remove('light'); // Adiciona a classe 'dark'
        } else {
            document.documentElement.classList.add('light'); // Remove a classe 'dark'
            document.documentElement.classList.remove('dark'); // Remove a classe 'dark'
        }

        function ShowLoading() {
          document.querySelector('.loading').style.display = "block"
            // Adicione o código da sua função aqui
        }

        // // Seleciona todos os links da página
        var links = document.querySelectorAll("a");

        // // Adiciona um ouvinte de evento de clique a cada link
        links.forEach(function(link) {
            link.addEventListener("click", ShowLoading);
        });


        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.loading').style.display = "none"
        })

        console.log('%cDesenvolvido pelo João Enrique', 'font-size: 30px; color: red;');
        console.log(`%chttps://github.com/JoaoEnrique`, 'font-size: 20px; color: #5bb4ff;');
        console.log(`%cRead Books ${new Date().getFullYear()}`, 'font-size: 30px; color: #5bb4ff;');

    </script>

<div class="loading">
    <div class="loader"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <main style="overflow: hidden;">
    @include('layouts.menu')
    @yield('content')
  </main>

    <script src="{{asset('js/app.js')}}"></script>
    <script>
      feather.replace();
      lucide.createIcons();
    </script>

    <style>
      .loading{
            height: 100vh;
            width: 100%;
            position: fixed;
            z-index: 9999!important;
            background-color: #1D1F20!important;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader  {
            animation: rotate 1s infinite;
            height: 50px;
            width: 50px;
        }

        .loader:before, .loader:after {
            border-radius: 50%;
            content: '';
            display: block;
            height: 20px;
            width: 20px;
        }
        .loader:before {
            animation: ball1 1s infinite;
            background-color: #cb2025;
            box-shadow: 30px 0 0 #f8b334;
            margin-bottom: 10px;
        }
        .loader:after {
            animation: ball2 1s infinite;
            background-color: #00a096;
            box-shadow: 30px 0 0 #97bf0d;
        }

        @keyframes rotate {
            0% {
                -webkit-transform: rotate(0deg) scale(0.8);
                -moz-transform: rotate(0deg) scale(0.8);
            }
            50% {
                -webkit-transform: rotate(360deg) scale(1.2);
                -moz-transform: rotate(360deg) scale(1.2);
            }
            100% {
                -webkit-transform: rotate(720deg) scale(0.8);
                -moz-transform: rotate(720deg) scale(0.8);
            }
        }

        @keyframes ball1 {
            0% {
                box-shadow: 30px 0 0 #f8b334;
            }
            50% {
                box-shadow: 0 0 0 #f8b334;
                margin-bottom: 0;
                -webkit-transform: translate(15px,15px);
                -moz-transform: translate(15px, 15px);
            }
            100% {
                box-shadow: 30px 0 0 #f8b334;
                margin-bottom: 10px;
            }
        }

        @keyframes ball2 {
            0% {
                box-shadow: 30px 0 0 #97bf0d;
            }
            50% {
                box-shadow: 0 0 0 #97bf0d;
                margin-top: -20px;
                -webkit-transform: translate(15px,15px);
                -moz-transform: translate(15px, 15px);
            }
            100% {
                box-shadow: 30px 0 0 #97bf0d;
                margin-top: 0;
            }
        }
    </style>
</body>
</html>
