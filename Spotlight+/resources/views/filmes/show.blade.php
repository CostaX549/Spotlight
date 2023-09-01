@extends('layouts.main')

@section('title', $filme['title'])

@section('content')

<div class="container-fluid p-0">

    <div class="position-relative">
        <img src="https://image.tmdb.org/t/p/original/{{ $filme['backdrop_path'] }}" alt="{{ $filme['title'] }}" class="img-fluid rounded main-image">
        <div class="image-overlay"></div> <!-- Elemento de sobreposição para o gradiente de opacidade -->
    
    </div>
</div>

<div id="infocontainer" class="container mt-5">
  
    <div class="row">
    <div class="col-md-12">
    <h1 class="mb-4">{{ $filme['title'] }}</h1>
    <p class="lead mb-4">{{ $filme['overview'] }}</p>
    
  
    <div class="col-md-12">
        <div class="custom-container custom-flex">
          
            @if(isset($filme['vote_average']))
            <i class="ri-star-fill ri-lg"></i> <!-- Ícone de estrela grande --><h4>{{ number_format($filme['vote_average'], 1) }}/10</h4>
            @else
                <span class="font-lg">Avaliação indisponível</span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="custom-container custom-flex"> <!-- Aplicando a classe personalizada -->
        
                @if(isset($filme['runtime']))
                <i class="ri-time-fill ri-lg"></i><h4>{{ $filme['runtime'] }} minutos</h4>
                @else
                    Duração indisponível
                @endif
          
        </div>
    </div>

    <div class="col-md-12">
        <div class="custom-container custom-flex"> <!-- Aplicando a classe personalizada -->
       
                @if(isset($filme['budget']) && $filme['budget'] > 0)
                <i class="ri-money-dollar-circle-fill ri-lg"></i><h4> Orçamento: ${{ number_format($filme['budget']) }}</h4>
                @else
                <i class="ri-money-dollar-circle-fill ri-lg"></i><h4> Orçamento: Indisponível</h4>
                @endif
            
        </div>
    </div>

    <div class="col-md-12">
        <div class="custom-container custom-flex"> <!-- Aplicando a classe personalizada -->
      
        @if(isset($filme['revenue']) && $filme['revenue'] > 0)
    <i class="ri-money-dollar-circle-fill ri-lg"></i> <h4> Receita: ${{ number_format($filme['revenue']) }}</h4>
@else
<i class="ri-money-dollar-circle-fill ri-lg"></i> <h4> Receita: Indisponível</h4>
@endif
           
        </div>
    </div>

    
    <!-- Adicione o iframe do trailer aqui -->
    
    <!-- Resto do seu código HTML -->

    <div class="col-md-12">
        <div class="row mt-5">
    <h2 class="mb-3 mt-5">Trailer</h2>
@php
$apiKey = '9549bb8a29df2d575e3372639b821bdc';
$movieId = $filme['id'];

$client = new \GuzzleHttp\Client();
$responsePt = $client->get("https://api.themoviedb.org/3/movie/{$movieId}/videos?api_key={$apiKey}&language=pt-BR");
$videoDataPt = json_decode($responsePt->getBody(), true);

// Procurar por trailers em português
$trailersPt = array_filter($videoDataPt['results'], function($video) {
    return $video['type'] === 'Trailer';
});

if (!empty($trailersPt)) {
    // Se houver trailers em português, pegue o primeiro trailer encontrado
    $firstTrailer = reset($trailersPt);
    $trailerKey = $firstTrailer['key'];
    $youtubeEmbedUrl = "https://www.youtube.com/embed/{$trailerKey}";
    echo '<iframe width="1250" height="700" src="' . $youtubeEmbedUrl . '" allowfullscreen></iframe>';
} else {
    // Se não encontrar trailers em português, tente encontrar em inglês
    $responseEn = $client->get("https://api.themoviedb.org/3/movie/{$movieId}/videos?api_key={$apiKey}");
    $videoDataEn = json_decode($responseEn->getBody(), true);

    // Procurar por trailers em inglês
    $trailersEn = array_filter($videoDataEn['results'], function($video) {
        return $video['type'] === 'Trailer';
    });

    if (!empty($trailersEn)) {
        // Se houver trailers em inglês, pegue o primeiro trailer encontrado
        $firstTrailer = reset($trailersEn);
        $trailerKey = $firstTrailer['key'];
        $youtubeEmbedUrl = "https://www.youtube.com/embed/{$trailerKey}";
        echo '<iframe width="1250" height="700" src="' . $youtubeEmbedUrl . '" allowfullscreen></iframe>';
    } else {
        echo '<p>Nenhum trailer disponível.</p>';
    }
}
@endphp

</div>
    </div>

<div class="col-md-12 mt-5">
    @if(auth()->check())
        @php
        
        $isFavorite = auth()->user()->favoriteMovies->contains('movie_id', $filme['id']);
        @endphp
        @if($isFavorite)
            <form action="{{ route('favorite.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $filme['id'] }}">
                <button type="submit" class="btn btn-danger mt-3 ml-5">Remover dos Favoritos</button>
            </form>
        @else
            <form action="{{ route('favorite.add') }}" method="POST">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $filme['id'] }}">
                <button type="submit" class="btn btn-primary mt-3 ml-5">Adicionar aos Favoritos</button>
            </form>
        @endif
    @endif
</div>


    <!-- Botão para favoritar ou desfavoritar -->
  

<!-- Resto do seu código HTML -->

    </div>
</div>
@endsection










