

@section('title', $filme['title'])


<div>
 
    <a href="javascript:history.back()" class="back-link text-primary">
        <i class="ri-arrow-left-line ri-lg arrow-icon" style="color: white;"></i>
    </a>
    <div class="position-relative">
        <img src="https://image.tmdb.org/t/p/original/{{ $filme['backdrop_path'] }}" alt="{{ $filme['title'] }}" class="rounded main-image">
        <div class="gradient-overlay"></div>
    </div>

    <div id="infocontainer" class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">{{ $filme['title'] }}</h1>
                <p class="lead mb-4">{{ $filme['overview'] }}</p>
            </div>

            <div class="col-md-12">
                <div class="custom-container custom-flex">
                    @if(isset($filme['vote_average']))
                    <i class="ri-star-fill ri-lg"></i>
                    <!-- Ícone de estrela grande -->
                    <h4>{{ number_format($filme['vote_average'], 1) }}/10</h4>
                    @else
                    <span class="font-lg">Avaliação indisponível</span>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="custom-container custom-flex">
                    <!-- Aplicando a classe personalizada -->
                    @if(isset($filme['runtime']))
                    <i class="ri-time-fill ri-lg"></i>
                    <h4>{{ $filme['runtime'] }} minutos</h4>
                    @else
                    Duração indisponível
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="custom-container custom-flex">
                    <!-- Aplicando a classe personalizada -->
                    @if(isset($filme['budget']) && $filme['budget'] > 0)
                    <i class="ri-money-dollar-circle-fill ri-lg"></i>
                    <h4> Orçamento: ${{ number_format($filme['budget']) }}</h4>
                    @else
                    <i class="ri-money-dollar-circle-fill ri-lg"></i>
                    <h4> Orçamento: Indisponível</h4>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="custom-container custom-flex">
                    <!-- Aplicando a classe personalizada -->
                    @if(isset($filme['revenue']) && $filme['revenue'] > 0)
                    <i class="ri-money-dollar-circle-fill ri-lg"></i>
                    <h4> Receita: ${{ number_format($filme['revenue']) }}</h4>
                    @else
                    <i class="ri-money-dollar-circle-fill ri-lg"></i>
                    <h4> Receita: Indisponível</h4>
                    @endif
                </div>
            </div>

            <!-- Adicione o iframe do trailer aqui -->
            <!-- Resto do seu código HTML -->

            <div class="col-md-12">
                <div class="row mt-5">
                    <h2 class="mb-3 mt-5">Trailer</h2>
                    @php
                    $apiKey = env('TMDB_API_KEY');
                    $movieId = $filme['id'];

                    $client = new \GuzzleHttp\Client();
                    $responsePt = $client->get("https://api.themoviedb.org/3/movie/{$movieId}/videos?api_key={$apiKey}&language=pt-BR");
                    $videoDataPt = json_decode($responsePt->getBody(), true);

                    // Procurar por trailers em português
                    $trailersPt = array_filter($videoDataPt['results'], function ($video) {
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
                        $trailersEn = array_filter($videoDataEn['results'], function ($video) {
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
                    <button wire:click="addToFavorites"
                        class="btn btn-{{ $isFavorite ? 'danger' : 'primary' }} mt-3 ml-5"
                        wire:loading.attr="disabled" <!-- Desabilita o botão durante o carregamento -->
                    
                        <span wire:loading.remove>
                            <!-- Conteúdo do botão quando não está em carregamento -->
                            {{ $isFavorite ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}
                        </span>
                        <span wire:loading>
                            <!-- Conteúdo do botão durante o carregamento -->
                            Carregando...
                        </span>
                    </button>
                @endif
            </div>
            @guest
            <a href="/dashboard">
                <button class="btn btn-primary mt-3 ml-5">
                    Adicionar aos favoritos
                </button>
            </a>
            @endguest

            <!-- Botão para favoritar ou desfavoritar -->

            <!-- Resto do seu código HTML -->
        </div>
    </div>
</div>


