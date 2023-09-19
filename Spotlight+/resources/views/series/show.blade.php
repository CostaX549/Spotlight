@extends('layouts.main')

@section('title', $serie['title'])

@section('content')
<a href="javascript:history.back()" class="back-link text-primary">
        <i class="ri-arrow-left-line ri-lg arrow-icon"></i>
    </a>
<div class="container-fluid p-0">
    <div class="position-relative">
        <img src="https://image.tmdb.org/t/p/original/{{ $serie['backdrop_path'] }}" alt="{{ $serie['title'] }}" class="img-fluid rounded main-image">
        <div class="image-overlay"></div>
    </div>
</div>

<div id="infocontainer" class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">{{ $serie['title']}}</h1>
            <p class="lead">{{ $serie['overview'] }}</p>
            <div class="col-md-12">
        <div class="custom-container custom-flex">
          
           
            <i class="ri-star-fill ri-lg"></i> <!-- Ícone de estrela grande --><h4>{{ number_format($serie['vote_average'], 1) }}/10</h4>
         
           
            
        </div>
    </div>
    <a href="{{ route('series.temporadas', ['id' => $serie['id']]) }}">
    <div class="col-md-12">
        <div class="custom-container custom-flex">
            <h3>Temporadas</h3>
            <h4>{{ $seasonCount }}</h4>
        </div>
    </div>
</a>






        </div>
    </div>
    
    
    
    <div class="row mt-5">
        <div class="col-md-12">
        <div class="row mt-5">
            <h2>Trailer</h2>
            @php
                $apiKey = env('TMDB_API_KEY');
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
    <div class="col-md-12 mt-5">
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

@guest
<a href="/dashboard">
    <button class="btn btn-primary mt-3 ml-5">
        Adicionar aos Favoritos
    </button>
</a>
@endguest

@endsection
