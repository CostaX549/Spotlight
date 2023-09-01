@extends('layouts.main')


@section('title', 'Spotlight+')

@section('content')


<header>

</header>

<!-- Exibir resultados da pesquisa -->
<!-- Exibir resultados da pesquisa -->
<div class="container">
    @if(!empty($resultados) && request()->is('pesquisa'))
    <div id="teste" class="container mb-2">
        <div class="row align-items-center">
            <div class="col">
                <p class="h3 text-white mb-0 d-inline">Resultados</p>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($resultados as $resultado)
        @if(isset($resultado['poster_path']))
            @php
                $routeName = isset($resultado['title']) ? 'filmes.show' : 'series.show';
                $routeParameters = ['id' => $resultado['id']];
            @endphp

            <div class="col-md-3 mb-4">
                <a href="{{ route($routeName, $routeParameters) }}">
                    <img src="https://image.tmdb.org/t/p/w500/{{ $resultado['poster_path'] }}" alt="{{ $resultado['title'] ?? $resultado['name'] }}" class="img-fluid rounded">
                </a>
            </div>
        @endif
        @endforeach
    </div>
    @elseif(request()->is('pesquisa')) 
      <p>Nenhum resultado encontrado.</p>
    @else
 
    @endif

<!-- Filmes Relacionados aos Termos de Pesquisa Mais Frequentes -->
@if (request()->is('/'))
@if(count($frequentSearchTerms) > 0)
   
  <div id="teste"class="container mt-2 mb-2">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Recomendados para você</p>
        </div>
      
      </div>
    </div>

    <div class="container mb-4">
    <div id="myCarouselMovies" class="carousel slide">
        <div class="carousel-inner" id="carouselMoviesInner">
        @php
            $apiKey = '9549bb8a29df2d575e3372639b821bdc';
            $maxMoviesPerTerm = 4;
            $maxMoviesToShow = $maxMoviesPerTerm * count($frequentSearchTerms);
            $moviesShown = 0;
            $itemIndex = 0;
            $minPopularity = 5;
            $unwantedMovieId = 617932; // Substitua pelo ID do filme indesejado
        @endphp

        @foreach ($frequentSearchTerms as $term)
            @php
                $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                    'api_key' => $apiKey,
                    'language' => 'pt-BR',
                    'query' => $term,
                ]);
                $data = $response->json();
            @endphp

            @if (!empty($data['results']))
                <div class="carousel-item{{ $itemIndex === 0 ? ' active' : '' }}">
                    <div class="row">
                        @foreach ($data['results'] as $result)
                            @if (isset($result['poster_path']) && $result['popularity'] > $minPopularity && $result['id'] !== $unwantedMovieId)
                                <div class="col-md-3">
                                    <a href="{{ route('filmes.show', ['id' => $result['id']]) }}">
                                        <img src="https://image.tmdb.org/t/p/w500/{{ $result['poster_path'] }}" class="img-fluid rounded mb-3" alt="Poster do Filme">
                                    </a>
                                </div>
                                @php
                                    $moviesShown++;
                                @endphp

                                @if ($moviesShown >= $maxMoviesToShow)
                                    @break 3;
                                @endif

                                @if ($moviesShown % $maxMoviesPerTerm === 0)
                                    @break;
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
                @php
                    $itemIndex++;
                @endphp
            @endif

            @if ($moviesShown >= $maxMoviesToShow)
                @break;
            @endif
        @endforeach

        </div>
        <a class="carousel-control-prev" href="#myCarouselMovies" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#myCarouselMovies" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </a>
    </div>
</div>
@endif

<div id="teste"class="container mt-4 mb-2">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Filmes</p>
        </div>
      
      </div>
    </div>


    <div  class="container mb-4" id="filmes">
      <div id="myCarouselThree" class="carousel slide">
        <div class="carousel-inner" id="carouselInner">
          <!-- Itens do carrossel para as imagens serão preenchidos dinamicamente -->
        </div>
        <a class="carousel-control-prev" href="#myCarouselThree" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#myCarouselThree" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Próximo</span>
        </a>
      </div>
    </div>

    <div id="teste" class="container mb-2">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Séries</p>
        </div>
        
      </div>
    </div>
 
    <div class="container mb-4">
      <div id="myCarouselSeries" class="carousel slide">
        <div class="carousel-inner" id="carouselSeriesInner">
          <!-- Itens do carrossel para as séries serão preenchidos dinamicamente -->
        </div>
        <a class="carousel-control-prev" href="#myCarouselSeries" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#myCarouselSeries" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Próximo</span>
        </a>
      </div>
    </div>


   

    <div id="teste"class="container mb-2">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Documentários</p>
        </div>
      
      </div>
    </div>
 
    <div class="container mb-4">
      <div id="myCarouselDocumentaries" class="carousel slide">
        <div class="carousel-inner" id="carouselDocumentariesInner">
          <!-- Itens do carrossel para os documentários serão preenchidos dinamicamente -->
        </div>
        <a class="carousel-control-prev" href="#myCarouselDocumentaries" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#myCarouselDocumentaries" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Próximo</span>
        </a>
      </div>
    </div>





@endif



  

    







    
  
@endsection

  

          
          
   
           
    


