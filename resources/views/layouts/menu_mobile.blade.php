

{{-- VERIFICA SE É ADMINISTRADOR OU NÃO --}}

@php

  $userController = new App\Http\Controllers\UserController();

  $isAdmin =  $userController->isAdmin();

@endphp



<nav class="navbar navbar-cel navbar-dark fixed-bottom" style="background: #5bb4ff; max-width: 80%!important;">

    <div class="container-fluid" style="padding: 0;">

        <div class="row" style="width: 100%; margin: 0;">

            <div class="col">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="flex-direction: row; justify-content: space-evenly; width: 100%;margin-top: -5px;">

                    <a class="nav-link" href="/" style="margin-left: -18px;">

                        <img src="../img/pacoca.png" height="37"/>

                    </a>

                    {{-- Usuario Logado mostra icones de configurações  --}}

                    @if (auth()->check())

                        {{-- HOME --}}

                        <li class="nav-item  @if(Request::is('/')) active @endif">

                            <a class="nav-link" href="/">

                                {{-- Caso esteja na home (img preenchida) --}}

                                @if(Request::is('/'))

                                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" fill="currentColor" class="icon-menu bi bi-house-door-fill" viewBox="0 0 16 16">

                                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>

                                    </svg>

                                @else

                                {{-- Caso não esteja na home (img normal) --}}

                                    <svg style="opacity: 0.5" xmlns="http://www.w3.org/2000/svg" height="25" width="25" fill="currentColor" class="icon-menu bi bi-house-door" viewBox="0 0 16 16">

                                        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146ZM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5Z"/>

                                    </svg>

                                @endif

                            </a>

                        </li>

        

                        {{-- PESQUISA --}}

                        <li class="nav-item  @if(Request::path() === 'search') active @endif">

                            <a class="nav-link" href="/search">

                                {{-- Caso esteja na home (img preenchida) --}}

                                @if(Request::path() === 'search')

                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="icon-menu bi bi-search-heart-fill" viewBox="0 0 16 16">

                                        <path d="M6.5 13a6.474 6.474 0 0 0 3.845-1.258h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.008 1.008 0 0 0-.115-.1A6.471 6.471 0 0 0 13 6.5 6.502 6.502 0 0 0 6.5 0a6.5 6.5 0 1 0 0 13Zm0-8.518c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018Z"/>

                                    </svg>

                                    

                                @else

                                {{-- Caso não esteja na home (img normal) --}}

                                    <svg style="opacity: 0.5" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="icon-menu bi bi-search-heart" viewBox="0 0 16 16">

                                        <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018Z"/>

                                        <path d="M13 6.5a6.471 6.471 0 0 1-1.258 3.844c.04.03.078.062.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1.007 1.007 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5ZM6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11Z"/>

                                    </svg>

                                @endif

                            </a>

                        </li>

                        

                        {{-- CRIAR POST --}}

                        <li class="nav-item">

                            <a  type="button" data-bs-toggle="modal" data-bs-target="#modal-post" class="nav-link" href="/">

                                <svg style="opacity: 0.5" xmlns="http://www.w3.org/2000/svg" height="25" width="25" fill="currentColor" class="icon-menu bi bi-plus-square" viewBox="0 0 16 16">

                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>

                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>

                                </svg>

                            </a>

                        </li>

                    

                        {{-- Conta do usuário --}}

                        <li class="nav-item dropdown dropup" >

                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                

                            </a>

                            <ul class="dropdown-menu" style="position: absolute; margin-left: -90px!important;">

                                <li>

                                    <a class="dropdown-item" href="/{{auth()->user()->user_name}}">Conta</a> {{-- Abre conta --}}

                                </li>

        

                                {{-- Sai da conta --}}

                                <li>

                                    <a 

                                        class="dropdown-item" 

                                        href="/logout" 

                                        onclick="event.preventDefault();

                                        document.getElementById('logout-form').submit();"

                                    >

                                        {{ __('Sair') }}

                                    </a>

                                </li>

                            </ul>

        

                        {{-- Usuário Não logado --}}

                        @else

                            <a href="/login" class="btn btn-outline-blue">Fazer login</a>

                        @endif

                    </li>

                </ul>



            </div>

        </div>

    </div>

</nav>

    {{-- JQuery --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../js/app.js"></script>

</form>

</div>