@extends('layouts.main')

@section('title', 'Página não encontrada')

@section('content')
    <section style="display: grid; justify-content: center;">
        <img class="img-not-found" height="700" src="{{asset('img/page-not-found.jpg')}}" alt="" srcset="">
    </section>
@endsection
