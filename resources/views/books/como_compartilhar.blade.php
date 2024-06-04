@extends('layouts.main')
@section('title', 'Como compartilhar')
@section('content')
    <div class="container mt-5">
        {{-- <div class="celular"> --}}
            <p>É possível compartilhar um livro específico ou todos de uma vez</p>
            <h1 class="nome-livro-lido">Compartilhar livro especifico</h1>
            <p>Entre na página do livro que deseja enviar para alguém e clique no botão compartilhar</p>
            <img class="celular" src="{{asset('img/compartilhar-especifico.png?v=1')}}" style="height:600px; width:300px">
            <img class="pc" src="{{asset('img/compartilhar-especifico-pc.png?v=1')}}" style="width:900px; height:500px">

            <p style="margin-top: 20px">Pronto, o link foi copiado e você pode enviar para quem quiser</p>
            <img class="celular" src="{{asset('img/compartilhar-especifico-modal.png?v=1')}}" style="height:600px; width:300px">
            <img class="pc" src="{{asset('img/compartilhar-especifico-pc.png?v=1')}}" style="width:900px; height:500px">

            <h1 style="margin-top: 30px" class="nome-livro-lido">Compartilhar todos os livros</h1>
            <p>Basta ir até a página principal com a listagem dos seus livros e clicar o botão azul na parte inferior direita e ir em compartilhar</p>
            <img class="celular" src="{{asset('img/compartilhar-home.png?v=1')}}" style="height:600px; width:300px">
            <img class="pc" src="{{asset('img/compartilhar-especifico-pc.png?v=1')}}" style="width:900px; height:500px">

            <p style="margin-top: 20px">Pronto, o link foi copiado e você pode enviar para quem quiser</p>
            <img class="celular" src="{{asset('img/compartilhar-home-modal.png?v=1')}}" style="height:600px; width:300px">
            <img class="pc" src="{{asset('img/compartilhar-especifico-pc.png?v=1')}}" style="width:900px; height:500px">
        </div>
    {{-- </div> --}}

    {{-- <div class="pc">

    </div> --}}


    <style>


        .celular{
            display: none;
        }

        .pc {
            display: block;
        }


        @media (max-width: 873px) {
            .celular{
                display: block;
            }

            .pc {
                display: none;
            }
        }
    </style>

@endsection



