<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public $user;
    public $movieDetails;


    
    public function mount()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $favoriteMovies = $user->favoriteMovies->pluck('movie_id');
            $apiKey = env('TMDB_API_KEY');
            $movieDetails = [];

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

            $this->user = $user;
            $this->movieDetails = $movieDetails;
        }
    }
    
    public function render()
    {
        return view('livewire.spotlight.dashboard');
    }
}