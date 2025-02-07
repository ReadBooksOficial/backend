{{-- VERIFICA SE É ADMINISTRADOR OU NÃO --}}
@php
  $userController = new App\Http\Controllers\UserController();
  $isAdmin =  $userController->isAdmin();
@endphp

{{-- <nav class="navbar navbar-expand-lg navbar-dark" style="width: 100%; background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important;"> --}}
<nav class="navbar navbar-expand-lg navbar-dark" style="width: 100%; background: #5bb4ff!important;">
    <div class="container-fluid">
      <a class="navbar-brand" href="/"><img src="{{asset('img/estante_icon.png')}}" height="50" class="log-menu"> Read Books</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <ul class="navbar-nav navbar-nav-pc me-auto mb-2 mb-lg-0" style="align-items: center;">
        <li style="margin-left: 30px!important" class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">
            {{-- <img class="logo-home-menu-cel" height="50px" src="{{asset('img/home.png')}}" alt="" srcset=""> --}}
            <img class="logo-home-menu-cel" height="30px" src="{{asset('img/home_white_24dp.svg')}}" alt="" srcset="">
            Home
          </a>
        </li>


        @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}
          <li style="margin-left: 30px!important" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="logo-books-menu-cel" height="30px" src="{{asset('img/book.svg')}}" alt="" srcset="">
              Livros
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="/livros">
                  <img class="logo-books-menu-cel" height="30px" src="{{asset('img/book_black.svg')}}" alt="" srcset="">
                  Meus livros
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/criar">
                  <img class="logo-books-menu-cel" height="30px" src="{{asset('img/add_black.svg')}}" alt="" srcset="">
                  Cadastrar livro
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/resumo-leitura">
                  <img class="logo-books-menu-cel" height="30px" src="{{asset('img/grafico.png')}}" alt="" srcset="">
                  Resumo da Leitura
                </a>
              </li>
            </ul>
          </li>

          @if ($isAdmin)
            <li style="margin-left: 30px!important;" class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <img class="logo-books-menu-cel" height="30px" src="{{asset('img/admin.svg')}}" alt="" srcset="">
                Gerenciar
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="/admins">
                    <img class="logo-books-menu-cel" height="30px" src="{{asset('img/list_black.svg')}}" alt="" srcset="">
                    Administradores
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="/users">
                    <img class="logo-books-menu-cel" height="30px" src="{{asset('img/list_black.svg')}}" alt="" srcset="">
                    Usuários
                  </a>
                </li>
              </ul>
            </li>
          @endif

          <li style="margin-left: 30px!important" class="nav-item">
            <a class="nav-link" aria-current="page" href="/conta">
              <img class="logo-books-menu-cel" height="30px" src="{{asset('img/person.svg')}}" alt="" srcset="">
              Conta
            </a>
          </li>
          
          @else
            <li style="margin-left: 30px!important" class="nav-item">
              <a class=" btn btn-light" href="/login">
                {{-- <img class="logo-home-menu-cel" height="50px" src="{{asset('img/home.png')}}" alt="" srcset=""> --}}
                {{-- <img class="logo-home-menu-cel" height="30px" src="{{asset('img/home_white_24dp.svg')}}" alt="" srcset=""> --}}
                Login
              </a>
            </li>
          
          @endif
      </ul>

          @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}

            <div class="navbar-nav-pc">

                <form class=" d-flex" method="GET" action="/pesquisa"> 

                    @csrf

                    <input class="form-control me-2" type="search" id="livro" name="livro" placeholder="Nome do Livro" aria-label="Search">

                    <button class="btn btn-outline-blue" type="submit">
                      <img height="30px" src="{{asset('img/search.png')}}" alt="" srcset="">
                    </button>

                  </form>

            </div>



          @else{{-- CASO NÃO ESTEJA LOGADO--}}

          <div class="navbar-nav-pc">

                <div class="d-flex">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">

                    {{-- <a class="nav-link" aria-current="page" href="/register"><Button class="btn btn-criar-conta">Criar Conta</Button></a> --}}

                    </li>

                    <li class="nav-item">

                    {{-- <a class="nav-link" aria-current="page" href="/login"><Button class="btn btn-fazer-login">Fazer Login</Button></a> --}}

                    </li>

                </ul>

                </div>

            </div>

          @endif

   </div>

</div>

{{-- MOBILE --}}
    {{-- <div class="offcanvas text-bg-dark offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important; max-width: 80%!important; border-radius: 15px 0 0 15px"> --}}
    <div class="offcanvas text-bg-dark offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background: #5bb4ff!important; max-width: 80%!important; border-radius: 15px 0 0 15px">

        <div class="offcanvas-header">

        <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Read Books</h5>

        <button type="buttoan" style="background: 0; border: 0" data-bs-dismiss="offcanvas" aria-label="Close">
          <img src="{{asset('img/close.png')}}" height="30px" alt="" srcset="">
        </button>

        </div>

        <div class="nav-bar offcanvas-body">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

             <li class="nav-item">

               {{-- <a class="nav-link active" aria-current="page" href="/">
                <img class="logo-home-menu-cel" height="30px" src="{{asset('img/home_white_24dp.svg')}}" alt="" srcset="">
                Home
              </a> --}}

             </li>

             @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}

             <li class="nav-item dropdown">

               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{-- <img class="logo-books-menu-cel" height="41px" src="{{asset('img/books.png')}}" alt="" srcset=""> --}}
                <img class="logo-books-menu-cel" height="30px" src="{{asset('img/book.svg')}}" alt="" srcset="">
                Livros
               </a>

               <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="background: #00000029; border:0">

                <li>
                  <a class="dropdown-item" href="/livros" style="color: #fff">
                    <img class="logo-books-menu-cel" height="30px" src="{{asset('img/book.svg')}}" alt="" srcset="">
                    Meus livros
                  </a>
                </li>

                 <li>
                  <a class="dropdown-item" href="/criar" style="color: #fff">
                    {{-- <img class="logo-books-menu-cel" height="41px" src="{{asset('img/add.png')}}" alt="" srcset=""> --}}
                    <img class="logo-books-menu-cel" height="30px" src="{{asset('img/add.svg')}}" alt="" srcset="">
                    Cadastrar livro
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="/resumo-leitura" style="color: #fff">
                    <img class="logo-books-menu-cel" height="30px" src="{{asset('img/grafico_white.png')}}" alt="" srcset="">
                    Resumo da Leitura
                  </a>
                </li>
               </ul>
             </li>

             @if ($isAdmin)
               <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{-- <img class="logo-books-menu-cel" height="41px" src="{{asset('img/admin.png')}}" alt="" srcset=""> --}}
                  <img class="logo-books-menu-cel" height="30px" src="{{asset('img/admin.svg')}}" alt="" srcset="">
                   Gerenciar
                 </a>

                 <ul class="dropdown-menu menu-mobile" aria-labelledby="navbarDropdown" style="background: #00000029; border:0">
                   <li>
                    <a class="dropdown-item" href="/admins" style="color: #fff">
                      {{-- <img class="logo-books-menu-cel" height="40px" src="{{asset('img/admin-list.png')}}" alt="" srcset=""> --}}
                    <img class="logo-books-menu-cel" height="30px" src="{{asset('img/list.svg')}}" alt="" srcset="">
                      Administradores
                    </a>
                  </li>

                   <li>
                    <a class="dropdown-item" href="/users" style="color: #fff">
                      {{-- <img class="logo-books-menu-cel" height="40px" src="{{asset('img/user-list.png')}}" alt="" srcset=""> --}}
                      <img class="logo-books-menu-cel" height="30px" src="{{asset('img/list.svg')}}" alt="" srcset="">
                      Usuários
                    </a>
                  </li>
                 </ul>
               </li>
             @endif

             <li class="nav-item">
               <a class="nav-link" aria-current="page" href="/conta">
                {{-- <img class="logo-books-menu-cel" height="41px" src="{{asset('img/account.png')}}" alt="" srcset=""> --}}
                <img class="logo-books-menu-cel" height="30px" src="{{asset('img/person.svg')}}" alt="" srcset="">
                Conta
              </a>
             </li>
             @endif
           </ul>

               @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}
                 <form class="d-flex" method="GET" action="/pesquisa"> 
                   @csrf

                   <input class="form-control me-2" type="search" id="livro" name="livro" placeholder="Nome do Livro" aria-label="Search">
                   <button class="btn btn-outline-blue" type="submit">
                    <img class="" height="30px" src="{{asset('img/search.png')}}" alt="" srcset="">
                   </button>
                 </form>

               @else{{-- CASO NÃO ESTEJA LOGADO--}}
                 <div class="d-flex">
                   <ul class="navbar-nav d-flex me-auto mb-2 mb-lg-0">
                     <li class="nav-item">
                      <a class="nav-link" aria-current="page" href="/register"><Button class="btn btn-criar-conta">Criar Conta</Button></a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" aria-current="page" href="/login"><Button class="btn btn-fazer-login">Fazer Login</Button></a>
                     </li>
                   </ul>
                 </div>
               @endif
        </div>
    </div>
  </div>
</nav>

