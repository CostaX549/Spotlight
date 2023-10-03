<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Dashboard extends Component
{
    public $user;
    public $movieDetails;

    public function loadFavoriteMovieDetails()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $favoriteMovies = $user->favoriteMovies->pluck('movie_id');
            $apiKey = env('TMDB_API_KEY');
            $movieDetails = [];

            foreach ($favoriteMovies as $movieId) {
                $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}&language=pt-BR");
                $movieDetails[] = json_decode($response->getBody(), true);
            }

            $this->user = $user;
            $this->movieDetails = $movieDetails;
        }
    }
    
    public function mount()
    {
        $this->loadFavoriteMovieDetails();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}