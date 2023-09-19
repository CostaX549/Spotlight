@extends('layouts.main')

@section('title', 'Spotlight+')

@section('content')

<div class="container mb-1" id="teste">
    <div class="row align-items-center">
        <div class="col">
            <p class="h3 text-white mb-0 d-inline">Mais Populares</p>
        </div>
    </div>
</div>

<div class="container mb-4">
    <div id="filmeCarousel" class="owl-carousel owl-theme">
        @foreach ($filmes as $key => $filme)
            <div class="item">
              
                    <a href="{{ route('filmes.show', ['id' => $filme['id']]) }}">
                        <img src="{{ 'https://image.tmdb.org/t/p/original/' . $filme['poster_path'] }}" alt="" class="img-fluid rounded">
                    </a>
             
            </div>
        @endforeach
    </div>

    <button class="owl-prev"><i class="fas fa-chevron-left"></i></button>
    <button class="owl-next"><i class="fas fa-chevron-right"></i></button>
</div>
@endsection 