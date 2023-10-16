<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public $user;
    public $movieDetails;
    public $seriesDetails; 

    
    public function mount()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $favoriteMovies = $user->favoriteMovies->pluck('movie_id');
            $favoriteSeries = $user->favoriteSeries->pluck('serie_id');
            $apiKey = env('TMDB_API_KEY');
            $movieDetails = [];
            $seriesDetails = [];
            if (!empty($favoriteMovies)) {
            foreach ($favoriteMovies as $movieId) {
                $cacheKey = "movie_details_{$movieId}";

                // Tente buscar os detalhes do filme no cache
                $cachedMovieDetails = Cache::get($cacheKey);

                if ($cachedMovieDetails === null) {
                    // Se não estiver em cache, faça a solicitação à API
                    $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}&language=pt-BR");
                    $movieDetails[] = json_decode($response->getBody(), true);

                    // Armazene os detalhes do filme em cache por um período específico (por exemplo, 24 horas)
                    Cache::put($cacheKey, $movieDetails[count($movieDetails) - 1], 1440);
                } else {
                    // Se estiver em cache, use os detalhes do filme armazenados em cache
                    $movieDetails[] = $cachedMovieDetails;
                }
            }
        }
        
        if (!empty($favoriteSeries)) {
            foreach ($favoriteSeries as $serieId) {
                $cacheKey = "series_details_{$serieId}";

                $cachedSeriesDetails = Cache::get($cacheKey);

                if ($cachedSeriesDetails === null) {
                    $response = Http::get("https://api.themoviedb.org/3/tv/{$serieId}?api_key={$apiKey}&language=pt-BR");
                    $seriesDetails[] = json_decode($response->getBody(), true);
                    Cache::put($cacheKey, $seriesDetails[count($seriesDetails) - 1], 1440);
                } else {
                    $seriesDetails[] = $cachedSeriesDetails;
                }
            }
        }

            $this->user = $user;
            $this->movieDetails = $movieDetails;
            $this->seriesDetails = $seriesDetails;
        }
    }
    
    public function render()
    {
        return view('livewire.spotlight.dashboard');
    }
}