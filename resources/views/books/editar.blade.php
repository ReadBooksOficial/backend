@extends('layouts.main')

@section('title', 'Editar - ' . $livro->nome_livro)



@section('content')
    <div class="container">
        {{-- o  enctype="multipart/form-data" serve para salvar arquivos --}}

            <form class="form-cadastrar-livro" action="/update" method="post" enctype="multipart/form-data">
                @csrf

                <h1 class="text-center">Edite seu Livro</h1>
                <input class="d-none" type="text" name="id_livro" id="id_livro" value="{{$livro->id_livro}}">
                <div class="mb-3">
                  <label for="nome_livro" class="form-label">Nome do Livro</label>
                  <input type="text" class="form-control @error('nome_livro') is-invalid @enderror" id="nome_livro" name="nome_livro" value="{{$livro->nome_livro}}">

                  @error('nome_livro')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label data-label-image class="form-label">Capa do Livro
                        <input type="file" class="d-none" data-input-image id="img_livro_usuario" name="img_livro_usuario" value="{{$livro->img_livro}}" accept="image/*">
                        <input class="d-none" id="img_livro" name="img_livro" type="text" value="{{$livro->img_livro}}">
                        <div class="img-escolher-capa" style="background-image: url('{{asset($livro->img_livro)}}')">
                            <img data-image-preview height="300px" width="200px" class="img-escolher-capa">
                        </div>
                    </label>
                </div>

                {{-- <div class="mb-4">
                    <label for="lido" class="form-label">Terminou o Livro</label>
                    <input type="text" class="form-control" id="lido" name="lido" value="{{$livro->lido}}">
                </div> --}}

                <div class="mb-4">
                    <label for="total_paginas" class="form-label">Total de Páginas</label>
                    <input min="1" type="number" class="form-control @error('total_paginas') is-invalid @enderror" id="total_paginas" name="total_paginas" value="{{$livro->total_paginas}}">
                    @error('total_paginas')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="paginas_lidas" class="form-label">Páginas Lidas</label>
                    <input type="number" class="form-control @error('paginas_lidas') is-invalid @enderror" id="paginas_lidas" name="paginas_lidas" value="{{$livro->paginas_lidas}}">
                    @error('paginas_lidas')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tempo_lido" class="form-label">Tempo lido</label>
                    <input type="text" class="form-control @error('tempo_lido') is-invalid @enderror" id="tempo_lido" name="tempo_lido" value="{{$livro->tempo_lido}}">

                    @error('tempo_lido')
                        <span class="invalid-feedback" role="alert" style="display: block!important">
                            {{ $message }}
                        </span>
                    @enderror
                </div>


            <div class="mb-4">
                <div class="row">
                    <div class="col">
                        @php
                            $data_inicio = $livro->data_inicio;
                            $data_termino = $livro->data_termino;
                        @endphp


                        <label for="data_inicio" class="form-label">Data de inicio da leitura</label>
                        <input id="data_inicio" name="data_inicio" placeholder="06/06/2023" value="{{$data_inicio}}" type="date" class="form-control @error('data_inicio') is-invalid @enderror">
                        {{-- <input id="data_inicio" name="data_inicio" placeholder="06/06/2023" value="{{$livro->data_inicio}}" type="text" class="form-control @error('data_inicio') is-invalid @enderror"> --}}
                        
                        <div id="passwordHelpBlock" class="form-text">
                            Deixe esse campo em branco para o livro ser adicionado na lista de desejos. Preecnha esse campo se você já começou a ler esse livro
                        </div>
    
                        @error('data_inicio')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="data_termino" class="form-label">Data de término</label>
                        <input id="data_termino" name="data_termino" placeholder="Termino da leitura" value="{{$data_termino}}" type="date" class="form-control @error('data_termino') is-invalid @enderror">
    
                        @error('data_termino')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3 ">
                <label for="descricao_livro" class="form-label">Descrição do Livro</label>
                <textarea class="form-control @error('descricao_livro') is-invalid @enderror" id="descricao_livro" name="descricao_livro" rows="1">{{$livro->descricao_livro}}</textarea>
                @error('descricao_livro')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-blue w-100 mt-3">Atualizar</button>
            </div>
        </form>
    </div>

    <script>
        // Obtém o elemento textarea
        var textarea = document.getElementById('descricao_livro');
      
        // Define a altura inicial com base no conteúdo
        textarea.style.height = (textarea.scrollHeight) + 'px';
      
        // Adiciona um ouvinte de eventos para ajustar a altura quando o conteúdo é modificado
        textarea.addEventListener('input', function () {
          this.style.height = 'auto';
          this.style.height = (this.scrollHeight) + 'px';
        });
      </script>

    <script src="{{asset('js\preview_image.js')}}"></script>

@endsection