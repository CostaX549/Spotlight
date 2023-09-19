@extends('layouts.main')

@section('title', 'Meus Favoritos')

@section('content')
<a href="javascript:history.back()" class="back-link text-primary">
    <i class="ri-arrow-left-line ri-lg arrow-icon"></i>
</a>

@guest 
<div class="container text-center text-white">
    <div class="text-center text-white">
        <i class="ri-star-fill ri-lg"></i><!-- Ícone de estrela Remix Icon -->
    </div>
    <h1 class="text-center text-white mt-3">Favorite os filmes e séries que você mais ama</h1>
    <p class="text-center text-white mt-3">Os favoritos não são exibidos quando você está desconectado.</p>
    <div class="text-centertext-white  mt-3">
        <a href="{{ route('login') }}" class="btn btn-primary">Fazer login</a>
    </div>
</div>
@endguest
@auth
@if(session('success'))
<div id="flash-message" class="alert alert-success">
    {{ session('success') }}
</div>

<script>
    setTimeout(function() {
        $('#flash-message').fadeOut('slow');
    }, 5000); // 5000 milissegundos = 5 segundos
</script>
@endif
<div class="container mb-1" id="teste">
    <div class="row align-items-center">
        <div class="col">
            <p class="h3 text-white mb-0 d-inline">Meus Favoritos</p>
        </div>
    </div>
</div>

<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(count($favoriteMovies) > 0 || count($favoriteSeries) > 0)
                <div class="row">
                    @foreach ($favoriteMovies as $index => $favoriteMovie)
                    <div class="col-6 col-md-3 mb-4"> <!-- Use col-6 para dispositivos móveis e col-3 para PCs -->
                        <a href="{{ route('filmes.show', [$favoriteMovie['movie_id']]) }}">
                            <img src="{{ 'https://image.tmdb.org/t/p/original/' . $favoriteMovie->moviePosterPath }}" alt="" class="d-block w-100 rounded">
                        </a>
                    </div>
                    @if(($index + 1) % 4 == 0)
                    </div><div class="row">
                    @endif
                    @endforeach

                    @foreach ($favoriteSeries as $index => $favoriteSerie)
                    <div class="col-6 col-md-3 mb-4"> <!-- Use col-6 para dispositivos móveis e col-3 para PCs -->
                        <a href="{{ route('series.show', [$favoriteSerie['serie_id']]) }}">
                            <img src="{{ 'https://image.tmdb.org/t/p/original/' . $favoriteSerie->seriePosterPath }}" class="img-fluid rounded">
                        </a>
                    </div>
                    @if(($index + 1) % 4 == 0)
                    </div><div class="row">
                    @endif
                    @endforeach
                </div>
                @else
                <h5 class="text-white">Você não possui filmes ou séries favoritas.</h5>
                <a href="/">Conheça novos filmes e séries</a>
                @endif
            </div>
        </div>
    </div>
</div>

@endauth

@endsection
