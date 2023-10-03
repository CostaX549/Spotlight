@extends('layouts.main')


@section('title', 'Spotlight+')

@section('content')


<header>

</header>

<!-- Exibir resultados da pesquisa -->
<!-- Exibir resultados da pesquisa -->

@if(!empty($resultados) && request()->is('pesquisa'))
    <a href="javascript:history.back()" class="back-link text-primary">
        <i class="ri-arrow-left-line ri-lg arrow-icon" style="color: white;"></i>
    </a>
    <div id="teste" class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="h3 text-white mb-0 d-inline">Resultados</h3>
            </div>
        </div>
    </div>
  
    <div class="container mb-4">
        <div class="row">
            @foreach($resultados as $resultado)
                @if(isset($resultado['poster_path']))
                    @php
                        $routeName = isset($resultado['title']) ? 'filmes.show' : 'series.show';
                        $routeParameters = [
                        'filmeId' => isset($resultado['title']) ? $resultado['id'] : null,
                        'serieId' => isset($resultado['name']) ? $resultado['id'] : null,
                    ];
                    @endphp

                    <div class="col-6 col-md-3">
                        <a href="{{ route($routeName, $routeParameters) }}">
                            <img src="https://image.tmdb.org/t/p/original/{{ $resultado['poster_path'] }}" alt="{{ $resultado['title'] ?? $resultado['name'] }}" 
                            class="img-fluid rounded mb-4">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
@elseif(request()->is('pesquisa')) 
    <a href="javascript:history.back()" class="back-link text-primary">
        <i class="ri-arrow-left-line ri-lg arrow-icon"></i>
    </a>
    <div class="row" style="margin-left: 295px; margin-top: 10px;">
    <h5 class="text-white">Nenhum resultado encontrado.</h5>
    <a href="/pesquisa?termo=avengers">Pesquise termos mais genéricos.</a>
</div>
@else
 
@endif

<!-- Filmes Relacionados aos Termos de Pesquisa Mais Frequentes -->
@if (request()->is('/'))

@if(count($frequentSearchTerms) > 0)
   
  <div id="teste"class="container  mb-1">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Pesquisados recentemente</p>
        </div>
      
      </div>
    </div>

    <div class="container">
    <div class="owl-carousel" id="myCarouselMovies">
        @php
            $apiKey = env('TMDB_API_KEY');
            $maxMoviesPerTerm = 4;
            $moviesShown = 0;
            $minPopularity = 5;
            $unwantedMovieId = 617932; // Substitua pelo ID do filme indesejado
           
        @endphp

        @foreach ($frequentSearchTerms as $term)
            @php
            
                $cacheKey = 'carousel_movies_' . md5($term); // Crie uma chave de cache única para cada termo de pesquisa
                $cachedMovies = Cache::get($cacheKey);
     
                if (!$cachedMovies) {
                    $response = Http::get("https://api.themoviedb.org/3/search/multi", [
                        'api_key' => $apiKey,
                        'language' => 'pt-BR',
                        'query' => $term,
                    ]);
                    $data = $response->json();

                    $cachedMovies = $data['results'] ?? [];
                    
                    // Filtrar e armazenar em cache apenas os resultados válidos
                    $cachedMovies = array_filter($cachedMovies, function ($result) use ($minPopularity, $unwantedMovieId) {
                        return isset($result['poster_path']) && $result['popularity'] > $minPopularity && $result['id'] !== $unwantedMovieId;
                    });
                    $cachedMovies = array_slice($cachedMovies, 0, $maxMoviesPerTerm);
                    
                    Cache::put($cacheKey, $cachedMovies, now()->addHours(1)); // Armazenar em cache por uma hora
                }
                
            @endphp

            @if (!empty($cachedMovies))
           
        
                    @foreach ($cachedMovies as $result)
                        @php
                        
                            $routeName = isset($result['title']) ? 'filmes.show' : 'series.show';
                            $routeParameters = [
                        'filmeId' => isset($result['title']) ? $result['id'] : null,
                        'serieId' => isset($result['name']) ? $result['id'] : null,
                    ];
                        @endphp
                      
                        <div class="item">
                            <a href="{{ route($routeName, $routeParameters) }}">
                                <img src="https://image.tmdb.org/t/p/original/{{ $result['poster_path'] }}" class="img-fluid rounded mb-4 " alt="Poster do Filme">
                            </a>
                            </div>
                            
                    @endforeach
             
            @endif
        @endforeach
              
        
       

@endif
</div>
        </div>
<div id="teste"class="container mt-1 mb-1">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Filmes</p>
        </div>
      
      </div>
    </div>



    <div class="container">
    <div id="myCarouselThree" class="owl-carousel">
    @foreach ($filmes as $filme)
    <div class="item">
        <a href="{{ route('filmes.show', ['filmeId' => $filme['id']]) }}">
            <img src="{{ 'https://image.tmdb.org/t/p/original/' . $filme['poster_path'] }}" alt="{{ $filme['title'] }}" class="img-fluid rounded mb-4">
        </a>
    </div>
@endforeach




    </div>
    
   

</div>

    

    <div id="teste" class="container mt-1 mb-1">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Séries</p>
        </div>
        
      </div>
    </div>
 
    <div class="container">
  <div id="myCarouselSeries" class="owl-carousel">
  @foreach ($series as $serie)
  <div class="item">
              <a href="{{ route('series.show', ['serieId' => $serie['id']]) }}">
                <img src="{{ 'https://image.tmdb.org/t/p/original/' . $serie['poster_path'] }}" alt="{{ $serie['name'] }}" class="img-fluid rounded mb-4">
                </a>
            </div>
            @endforeach
  </div>
</div>


   

    <div id="teste"class="container mt-1 mb-1">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Documentários</p>
        </div>
      
      </div>
    </div>
 
    <div class="container">
  <div id="myCarouselDocumentaries" class="owl-carousel">
  @foreach ($documentarios as $documentario)
  <div class="item">
  <a href="{{ route('filmes.show', ['filmeId' => $documentario['id']]) }}">
                <img src="{{ 'https://image.tmdb.org/t/p/original/' . $documentario['poster_path'] }}" alt="{{ $documentario['title'] }}" class="img-fluid rounded mb-4">
                </a>
            </div>
 
  @endforeach
  </div>
</div>
<div id="teste"class="container mt-1 mb-1">
      <div class="row align-items-center">
        <div class="col">
          <p class="h3 text-white mb-0 d-inline">Desenhos e animes</p>
        </div>
      
      </div>
    </div>

<div class="container">
    <div id="myAnimeCarousel" class="owl-carousel">
    @foreach ($animes as $anime)
    <div class="item">
        <a href="{{ route('series.show', ['serieId' => $anime['id']]) }}">
            <img src="{{ 'https://image.tmdb.org/t/p/original/' . $anime['poster_path'] }}" alt="{{ $anime['name'] }}" class="img-fluid rounded mb-4">
        </a>
    </div>
@endforeach


                   


@endif












    
  
@endsection



  

          
          
   
           
    


