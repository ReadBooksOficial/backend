{{-- VERIFICA SE É ADMINISTRADOR OU NÃO --}}
@php
  $userController = new App\Http\Controllers\UserController();
  $isAdmin = $userController->isAdmin();
@endphp


{{-- <nav class="navbar navbar-expand-lg navbar-dark"
  style="width: 100%; background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important;">
  --}}
  <nav class="navbar navbar-pc navbar-dark user-select-none navbar-expand-md @if(auth()->check()) menu-radius @endif">
    <div class="container-fluid">
      <a class="navbar-brand" href="/"><img src="{{asset('img/estante_icon.png')}}" height="50" class="log-menu">
        <span class="text-menu">Read Books</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="navbar-nav navbar-nav-pc me-auto mb-2 mb-lg-0" style="align-items: center;">
        <form class=" d-flex" method="GET" action="/pesquisa">
          @csrf

          <input class="form-control search-menu" type="text" id="livro" name="livro"
            placeholder="Pesquisar meus livros" aria-label="Search">
          <button class="btn btn-search-menu" type="submit">
            <img height="30px" src="{{asset('img/search.png')}}" alt="" srcset="">
          </button>
        </form>
    </div>


    <div class="d-flex div-icons-nav" role="search">
      <ul class="navbar-nav me-auto mb-lg-0 content-menu">
        @if (auth()->check() || (!auth()->check() && !Route::currentRouteName() == 'index')) {{-- CASO ESTEJA LOGADO OU SEJA A PAGINA INICIAL --}}
          <li class="nav-item">
            <a class="nav-link nav-link-pc active" aria-current="page" href="/">
            <i data-lucide="home"></i>
            {{-- Home --}}
            </a>
          </li>
        @endif

        <li class="nav-item dropdown">
          <a class="nav-link nav-link-pc dropdown-toggle" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i data-lucide="layout-grid"></i>
            {{-- Apps --}}
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item d-flex align-items-center" target="_blank" href="{{ config("app.rita_url") }}">
                <i style="height: 19px; margin-right: 3px" data-lucide="clipboard"></i>
                Rita
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" target="_blank" href="{{ config("app.cronos_url") }}">
                <i style="height: 19px; margin-right: 3px" data-lucide="clock"></i>
                Cronos
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" target="_blank" href="{{ config("app.pacoca_url") }}">
                <i style="height: 19px; margin-right: 3px" data-lucide="contact-round"></i>
                Paçoca
              </a>
            </li>
          </ul>
        </li>


        @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}
          <li class="nav-item dropdown">
            <a class="nav-link nav-link-pc dropdown-toggle" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            {{-- <img class="logo-books-menu-cel" height="25px" src="{{asset('img/book.svg')}}" alt="" srcset=""> --}}
            <i data-lucide="book-open"></i>
            {{-- Livros --}}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/criar">
              <i style="height: 19px; margin-right: 3px" data-lucide="circle-plus"></i>
              Novo livro
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/resumo-leitura">
              <i style="height: 19px; margin-right: 3px" data-lucide="layout-dashboard"></i>
              Resumo da Leitura
              </a>
            </li>
            </ul>
          </li>

          <span style="cursor: pointer;" onClick="toggleDarkMode()" id="darkModeToggle"
            className="cursor-pointer link-menu-right dropdown-item d-flex align-items-center justify-content-start">
            <div class="nav-link nav-link-pc mode-dark">
            <i style="color: #fff" data-lucide="sun"></i>
            {{-- <span>Dark</span> --}}
            </div>
            <div class="nav-link nav-link-pc mode-light">
            <i style="color: #fff" data-lucide="moon"></i>
            {{-- <span>Light</span> --}}
            </div>
          </span>
      @endif

        @if(auth()->check())
          <li class="nav-item dropdown">
            <a class="nav-link nav-link-pc dropdown-toggle" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img id="userImage" class="cursor-pointer img-perfil-menu"
              src="{{ config("app.pacoca_api_url") }}/{{auth()->user()->img_account}}" alt="Perfil"
              style="cursor: pointer!important" onerror="this.src='/img/img-account.png';" />
            </a>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/conta">
              <i style="height: 19px; margin-right: 3px" data-lucide="user"></i>
              Conta
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout">
              <i style="height: 19px; margin-right: 3px" data-lucide="log-out"></i>
              Sair
              </a>
            </li>
            </ul>
          </li>
        @endif


        @if (!auth()->check())
        @if (Route::currentRouteName() != 'index')
            <ul class="navbar-nav navbar-nav-pc me-auto mb-2 mb-lg-0" style="align-items: center;">
              <li class="nav-item">
                <a class="nav-link nav-link-pc active" href="/login">
                  <i data-lucide="log-in"></i>
                  {{-- Login --}}
                </a>
              </li>
            <ul class="navbar-nav navbar-nav-pc me-auto mb-2 mb-lg-0" style="align-items: center;">
              <li class="nav-item">
                <a class="nav-link nav-link-pc active" href="/register">
                <i data-lucide="user-plus"></i>
                {{-- Criar conta --}}
                </a>
              </li>
        @endif
    </span>
    @endif
  </ul>
        @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}

      @else{{-- CASO NÃO ESTEJA LOGADO--}}

        <div class="navbar-nav-pc">
        <div class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            {{-- <a class="nav-link nav-link-pc" aria-current="page" href="/register"><Button
              class="btn btn-criar-conta">Criar Conta</Button></a> --}}
          </li>
          <li class="nav-item">
            {{-- <a class="nav-link nav-link-pc" aria-current="page" href="/login"><Button
              class="btn btn-fazer-login">Fazer Login</Button></a> --}}
          </li>
          </ul>
        </div>
        </div>
      @endif
    </div>
    </div>

    {{-- MOBILE --}}
    {{-- <div class="offcanvas text-bg-dark offcanvas-end" tabindex="-1" id="offcanvasNavbar"
      aria-labelledby="offcanvasNavbarLabel"
      style="background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important; max-width: 80%!important; border-radius: 15px 0 0 15px">
      --}}
      <div class="offcanvas text-bg-dark offcanvas-end" tabindex="-1" id="offcanvasNavbar"
        aria-labelledby="offcanvasNavbarLabel"
        style="background: #5bb4ff!important; max-width: 80%!important; border-radius: 15px 0 0 15px">

        <div class="offcanvas-header">

          <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Read Books</h5>

          <button type="buttoan" style="background: 0; border: 0" data-bs-dismiss="offcanvas" aria-label="Close">
            <img src="{{asset('img/close.png')}}" height="30px" alt="" srcset="">
          </button>

        </div>
        <div class="nav-bar offcanvas-body">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}

        <li class="nav-item dropdown">

        <li>
          <a class="nav-link active" href="/livros" style="color: #fff">
          <i data-lucide="home"></i>
          Home
          </a>
        </li>


        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li>
          <a class="dropdown-item" href="/conta">
            <i data-lucide="user"></i>
            Conta
          </a>
          </li>
          <li>
          <a class="dropdown-item" href="/logout">
            <i data-lucide="log-out"></i>
            Sair
          </a>
          </li>
        </ul>
        </li>

        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          {{-- <img class="logo-books-menu-cel" height="41px" src="{{asset('img/books.png')}}" alt="" srcset="">
          --}}
          <i data-lucide="book-open"></i>
          Livros
        </a>


        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="background: #00000029; border:0">
          <li>
          <a class="dropdown-item" href="/criar" style="color: #fff">
            {{-- <img class="logo-books-menu-cel" height="41px" src="{{asset('img/add.png')}}" alt="" srcset="">
            --}}
            <i data-lucide="circle-plus"></i>
            Novo livro
          </a>
          </li>
          <li>
          <a class="dropdown-item" href="/resumo-leitura" style="color: #fff">
            <i data-lucide="layout-dashboard"></i>
            Resumo da Leitura
          </a>
          </li>
        </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <i data-lucide="circle-user"></i>
          {{ explode(" ", auth()->user()->name)[0] }}
          </a>
          <ul style="background: #00000029; border:0" class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li>
            <a style="color: #fff" class="dropdown-item" href="/conta">
            <i data-lucide="user"></i>
            Conta
            </a>
          </li>
          <li>
            <a style="color: #fff" class="dropdown-item" href="/logout">
            <i data-lucide="log-out"></i>
            Sair
            </a>
          </li>
          </ul>
        </li>
        <li>
          <a class="nav-link" href="#" style="color: #fff">
          <span style="cursor: pointer; margin-top: 0px;" onClick="toggleDarkMode()" id="darkModeToggle"
            className="cursor-pointer link-menu-right dropdown-item d-flex align-items-center justify-content-start">
            <div class="mode-dark">
            <i style="color: #fff" data-lucide="sun"></i>
            <span style="margin-left: -7px">Dark</span>
            </div>
            <div class="mode-light">
            <i style="color: #fff" data-lucide="moon"></i>
            <span style="margin-left: -7px">Light</span>
            </div>
          </span>
          </a>
        </li>


      @endif
          </ul>

          @if (auth()->check()) {{-- CASO ESTEJA LOGADO--}}
        <form class="d-flex" method="GET" action="/pesquisa">
        @csrf

        <input class="form-control search-menu" type="search" id="livro" name="livro" placeholder="Nome do Livro"
          aria-label="Search">
        <button class="btn btn-search-menu" type="submit">
          <img height="30px" src="{{asset('img/search.png')}}" alt="" srcset="">
        </button>
        </form>

      @else{{-- CASO NÃO ESTEJA LOGADO--}}
        <div class="d-flex">
        <ul class="navbar-nav d-flex me-auto mb-2 mb-lg-0" style="width: 100%">
          <a class="nav-link " href="#" style="color: #fff">
          <span style="cursor: pointer; margin-top: -20px;" onClick="toggleDarkMode()" id="darkModeToggle"
            className="cursor-pointer link-menu-right dropdown-item d-flex align-items-center justify-content-start">
            <div class="mode-dark">
            <i style="color: #fff" data-lucide="sun"></i>
            <span style="margin-left: -7px">Dark</span>
            </div>
            <div class="mode-light">
            <i style="color: #fff" data-lucide="moon"></i>
            <span style="margin-left: -7px">Light</span>
            </div>
          </span>
          </a>
          </li>

          <div style="display: flex;">
          <li class="nav-item" style="width: 50%">
            <a class="nav-link" aria-current="page" href="/register"><Button class="btn btn-criar-conta">Criar
              Conta</Button></a>
          </li>
          <li class="nav-item" style="width: 50%">
            <a class="nav-link" aria-current="page" href="/login"><Button class="btn btn-criar-conta">Fazer
              Login</Button></a>
          </li>
          </div>
          <li>

        </ul>
        </div>
      @endif
        </div>
      </div>
    </div>
  </nav>

  <script>
    function toggleDarkMode() {
      const savedMode = localStorage.getItem('dark-mode');
      const isDarkMode = savedMode == "true";
      localStorage.setItem('dark-mode', JSON.stringify(!isDarkMode));

      // Adiciona ou remove a classe 'dark' no root
      if (isDarkMode) {
        document.documentElement.classList.add('light'); // Remove a classe 'dark'
        document.documentElement.classList.remove('dark'); // Remove a classe 'dark'
        document.querySelectorAll(".mode-dark").forEach((el) => {
          el.style.display = "block";
        });
        document.querySelectorAll(".mode-light").forEach((el) => {
          el.style.display = "none";
        });
      } else {
        document.documentElement.classList.add('dark'); // Adiciona a classe 'dark'
        document.documentElement.classList.remove('light'); // Adiciona a classe 'dark'
        document.querySelectorAll(".mode-dark").forEach((el) => {
          el.style.display = "none";
        });
        document.querySelectorAll(".mode-light").forEach((el) => {
          el.style.display = "block";
        });
      }
    }
  </script>