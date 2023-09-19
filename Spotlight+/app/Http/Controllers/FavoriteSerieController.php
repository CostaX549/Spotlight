<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http; // Importe a classe Http
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;

class FavoriteSerieController extends Controller
{
    public function addToFavorites(Request $request)
{
     
    $user = Auth::user();
    $serieId = $request->input('serie_id');
    $favoriteSeries = $user->favoriteSeries()->get();
    
    // Verificar se a série já foi adicionada aos favoritos desse usuário
    if (!$user->favoriteSeries()->where('serie_id', $serieId)->exists()) {
        $user->favoriteSeries()->create([
            'serie_id' => $serieId,
        ]);

        return redirect('/dashboard')->with('success', 'Série adicionada aos favoritos com sucesso.');
    }

    return redirect()->back()->with('error', 'Série já está nos favoritos.');
}

public function removeFromFavorites(Request $request)
{
    $user = Auth::user();
    $serieId = $request->input('serie_id');
    
    // Remove a série dos favoritos do usuário
    $user->favoriteSeries()->where('serie_id', $serieId)->delete();
    
    return redirect('/dashboard')->with('success', 'Série removida dos favoritos com sucesso.');
}

public function dashboard()
{
    if (Auth::check()) {
        
        $user = auth()->user();
        $favoriteSeries = $user->favoriteSeries;
        $apiKey = env('TMDB_API_KEY');

        foreach ($favoriteSeries as $favoriteSerie) {
            $serieId = $favoriteSerie->serie_id;

            $seriePosterPath = Cache::remember('serie_' . $serieId . '_poster', now()->addHours(2), function () use ($serieId, $apiKey) {
                $response = Http::get("https://api.themoviedb.org/3/tv/{$serieId}?api_key={$apiKey}&language=pt-BR");
                $serieData = $response->json();
                return $serieData['poster_path'];
            });

            $favoriteSerie->seriePosterPath = $seriePosterPath; // Adicione o caminho do pôster da série ao objeto $favoriteSerie
        }

        // Verifique se os dados dos filmes favoritos estão em cache
        $favoriteMovies = Cache::remember('user_favorite_movies_' . $user->id, now()->addHours(2), function () use ($user, $apiKey) {
            return $user->favoriteMovies->map(function ($favoriteMovie) use ($apiKey) {
                $movieId = $favoriteMovie->movie_id;
                $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}&language=pt-BR ");
                $movieData = $response->json();
                $favoriteMovie->moviePosterPath = $movieData['poster_path'];
                return $favoriteMovie;
            });
        });
       


        return view('dashboard', compact('user',  'favoriteSeries', 'favoriteMovies'));
    } else {
        
        return view('dashboard');
    }
}


}
