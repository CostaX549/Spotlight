@extends('layouts.main')

@section('title', $serie->title)

@section('content')

<div class="container-fluid p-0">
    <div class="position-relative">
        <img src="https://image.tmdb.org/t/p/original/{{ $serie->backdrop_path }}" alt="{{ $serie->title }}" class="img-fluid rounded main-image">
        <div class="image-overlay"></div>
    </div>
</div>

<div id="infocontainer" class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">{{ $serie->title }}</h1>
            <p class="lead">{{ $serie->overview }}</p>
            <p class="font-weight-bold">
                @if(isset($serie->vote_average))
                    Avaliação: {{ $serie->vote_average }}
                @else
                    Avaliação indisponível
                @endif
            </p>
        </div>
    </div>
    
    <div class="row mt-5">
    <div class="col-md-12">
        <h2>Temporadas</h2>
         <p>Total de temporadas: {{ count($temporadas) }}</p>
    </div>
</div>
    
    <div class="row mt-5">
        <div class="col-md-12">
            <h2>Trailer</h2>
            @php
                $apiKey = '9549bb8a29df2d575e3372639b821bdc';
                $tvId = $serie['id'];
                
                $client = new \GuzzleHttp\Client();
                $response = $client->get("https://api.themoviedb.org/3/tv/{$tvId}/videos?api_key={$apiKey}");
                $videoData = json_decode($response->getBody(), true);

                $trailers = array_filter($videoData['results'], function($video) {
                    return $video['type'] === 'Trailer';
                });

                if (!empty($trailers)) {
                    $firstTrailer = reset($trailers);
                    $trailerKey = $firstTrailer['key'];
                    $youtubeEmbedUrl = "https://www.youtube.com/embed/{$trailerKey}";
                    echo '
                        <iframe width="1250" height="700" src="' . $youtubeEmbedUrl . '" allowfullscreen></iframe>
                    ';
                } else {
                    echo '<p>Nenhum trailer disponível.</p>';
                }
            @endphp
        </div>
    </div>
    <div class="col-md-12 mt-4">
    @if(auth()->check())
        @php
        $isFavorite = auth()->user()->favoriteSeries->contains('serie_id', $serie['id']);
        @endphp
        @if($isFavorite)
            <form action="{{ route('series.favorite.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="serie_id" value="{{ $serie['id'] }}">
                <button type="submit" class="btn btn-danger">Remover dos Favoritos</button>
            </form>
        @else
            <form action="{{ route('series.favorite.add') }}" method="POST">
                @csrf
                <input type="hidden" name="serie_id" value="{{ $serie['id'] }}">
                <button type="submit" class="btn btn-primary">Adicionar aos Favoritos</button>
            </form>
        @endif
    @endif
</div>

@endsection
