@extends('layouts.main')

@section('title', 'Meus Favoritos')

@section('content')

<link rel="stylesheet" href="/css/estilo.css">
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
<div id="teste"class="container mt-4 mb-1">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Meus filmes favoritos</p>
        </div>
      
      </div>
    </div>

<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            @if(count($favoriteMovies) > 0)
                <div class="row">
                    @foreach ($favoriteMovies as $index => $favoriteMovie)
                        <div class="col-md-3 mb-4">
                             <a href="{{ route('filmes.show', [ $favoriteMovie['movie_id']]) }}">
                            <img src="https://image.tmdb.org/t/p/original/{{ $favoriteMovie->movie['poster_path'] }}" alt="{{ $favoriteMovie->movie['title'] }}" class="img-fluid rounded " >
                        </a>
                        </div>

                        @if (($index + 1) % 4 === 0)
                            </div><div class="row">
                        @endif
                    @endforeach
                </div>
                @else
                <h5 class="text-white">Você não possui filmes favoritos.</h5>
                <a href="/">Conheça novos filmes</a>
                @endif
            </div>
        </div>
    </div>
</div>
<div id="teste"class="container mt-4 mb-1">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Minhas séries favoritas</p>
          
        </div>
      
      </div>
    </div>
<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
               
                <div class="row">
                    @foreach ($favoriteSeries as $index => $favoriteSerie)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('series.show', [ $favoriteSerie['serie_id']]) }}">
                                <img src="https://image.tmdb.org/t/p/original/{{ $favoriteSerie->serie['poster_path'] }}" alt="{{ $favoriteSerie->serie['name'] }}" class="img-fluid rounded">
                            </a>
                        </div>

                        @if (($index + 1) % 4 === 0)
                            </div><div class="row">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

