<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http; // Importe a classe Http
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;

class FavoriteSerieController extends Controller
{
 
    public function dashboard()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $favoriteMovies = $user->favoriteMovies->pluck('movie_id');
            $apiKey = env('TMDB_API_KEY');
            
            $movieDetails = Cache::remember('favorite_movie_details', now()->addHours(6), function () use ($favoriteMovies, $apiKey) {
                $movieDetails = [];
    
                foreach ($favoriteMovies as $movieId) {
                    $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}&language=pt-BR");
                    $movieDetails[] = json_decode($response->getBody(), true);
                }
    
                return $movieDetails;
            });
    
            return view('dashboard', compact('user', 'movieDetails'));
        } else {
            return view('dashboard');
        }
    }

}
