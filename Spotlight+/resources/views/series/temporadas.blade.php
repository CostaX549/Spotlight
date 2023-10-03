@extends('layouts.main')

@section('content')
@section('title', $serieName )
@php
use Carbon\Carbon;
@endphp
<a href="javascript:history.back()" class="back-link text-primary">
        <i class="ri-arrow-left-line ri-lg arrow-icon" style="color: white;"></i>
    </a>
    <div class="container text-center">
        <h1 class="text-white">Temporadas da Série: {{$serieName}}</h1>

        @foreach ($seasons as $season)
            @if (is_array($season) && $season['season_number'] > 0) <!-- Verifica se é uma temporada válida (número maior do que 0) -->
                <div class="season text-center"> <!-- Adicione a classe text-center para centralizar o texto -->
                    <h2 class="text-white">Temporada {{ $season['season_number'] }}</h2>
                    
                    <div class="col-6 col-md-3 mx-auto"> <!-- Centraliza a coluna -->
                        @if (!empty($season['poster_path']))
                            <img src="https://image.tmdb.org/t/p/original{{ $season['poster_path'] }}" alt="Poster da Temporada {{ $season['season_number'] }}" class="img-fluid">
                        @else
                            <p>Poster não disponível</p>
                        @endif
                    </div>
                    
                    <p class="text-white" style="font-size: 20px;">Data de Lançamento: {{ Carbon::parse($season['air_date'])->format('d/m/Y') }}</p>
                    <p class="text-white" style="font-size: 20px;">Número de Episódios: {{ $season['episode_count'] }}</p>
                    <div class="overview">
                    <p class="lead overview-text">
                            Sinopse: 
                            @if (strlen($season['overview']) > 500)
                            <span class="overview-summary">{{ mb_substr($season['overview'], 0, 800) }}...</span>
                                <span class="overview-full" style="display: none;">{{ $season['overview'] }}</span>
                                <button class="btn btn-primary show-more-button">Mostrar Mais</button>
                            @else
                                {{ $season['overview'] }}
                            @endif
                        </p>
                    </div>
                    <!-- Outras informações relevantes da temporada -->
                </div>
                @if (!$loop->last) <!-- Adicione a linha horizontal após todas as temporadas, exceto a última -->
                    <hr class="season-divider">
                @endif
            @endif
        @endforeach
    </div>
    <script>
    // Adicione um script JavaScript para lidar com a ação de "Mostrar Mais"
    document.querySelectorAll('.show-more-button').forEach(button => {
        button.addEventListener('click', function () {
            const overviewSummary = this.parentElement.querySelector('.overview-summary');
            const overviewFull = this.parentElement.querySelector('.overview-full');

            // Alterna a exibição entre a visão resumida e a visão completa
            if (overviewSummary.style.display === 'none') {
                overviewSummary.style.display = 'inline';
                overviewFull.style.display = 'none';
                this.textContent = 'Mostrar Mais';
            } else {
                overviewSummary.style.display = 'none';
                overviewFull.style.display = 'inline';
                this.textContent = 'Mostrar Menos';
            }
        });
    });
</script>

@endsection
