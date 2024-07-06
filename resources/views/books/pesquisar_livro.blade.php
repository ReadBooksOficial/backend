@extends('layouts.main')

@section('title', 'Pagina principal')



@section('content')

    <div class="container">

            @if (count($livros))
                <h1 class="text-center " style="font-size: 30px; margin-top: 20px">Meus livros com: </h1>
                <h2 class="text-center">"{{$_GET['livro']}}"</h2>
                <p class="text-center text-quantidade-livros">livros encontrados: {{count($livros)}}</p>
            @else
                <h2 class="text-center" style="margin-bottom: 50px">Nenhum livro encontrado com: "{{$_GET['livro']}}"</h2>
            @endif

            {{-- PESQUISA --}}
            <div class="row row-pesquisa-livro" style="margin-bottom: 100px">
                <div class="col">
                    <form class="d-flex" method="GET" action="/pesquisa">
                        @csrf
                        <input class="form-control me-2" type="search" id="livro" name="livro" value="{{$_GET['livro']}}" placeholder="Nome do Livro" aria-label="Search">
                        <button class="btn" style="background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important; color: #fff; padding: 0; min-width: 50px;" type="submit">
                            <img height="40px" src="{{asset('img/search.png')}}" alt="" srcset="">
                        </button>
                    </form>
                    <form action="{{ route('livros.filtrar') }}" method="get">
                        <select name="filtro" class="form-select mt-4" aria-label="Default select example" onchange="this.form.submit()">
                            <option value="filtro" {{ request('filtro') == 'filtro' ? 'selected' : '' }}>Meus livros</option>
                            <option value="outros" {{ request('filtro') == 'outros' ? 'selected' : '' }}>Outros livros</option>
                            <option value="todos" {{ request('filtro') == 'todos' ? 'selected' : '' }}>Todos</option>
                            <option value="lidos" {{ request('filtro') == 'lidos' ? 'selected' : '' }}>Lidos</option>
                            <option value="nao_lidos" {{ request('filtro') == 'nao_lidos' ? 'selected' : '' }}>Não lidos</option>
                            <option value="lista_desejo" {{ request('filtro') == 'lista_desejo' ? 'selected' : '' }}>Lista de desejo</option>
                        </select>
                    </form>
                </div>
            </div>

        <div class="row row-list-livros">
            @foreach ($livros as $livro)
                <div class="col col-livro">
                    <a class="link-livro" href="/livro/{{ $livro->id_livro }}">
                        <div class="livro"  @if ($livro->img_livro != '../img/book_transparent.png') style="background-image:url('{{ asset($livro->img_livro) }}');" @else style="background-image:url('../img/book_transparent.png');" @endif>
                            @if ($livro->img_livro == '../img/book_transparent.png')
                                <h1>{{ $livro->nome_livro }}</h1>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

