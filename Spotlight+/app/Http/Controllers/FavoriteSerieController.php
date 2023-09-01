<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http; // Importe a classe Http
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
    
    return redirect('/dashboard');
}

public function dashboard()
{
    $user = auth()->user();

    $favoriteSeries = $user->favoriteSeries;


    foreach ($favoriteSeries as $favoriteSerie) {
        $serieId = $favoriteSerie->serie_id;
        $response = Http::get("https://api.themoviedb.org/3/tv/{$serieId}?api_key=9549bb8a29df2d575e3372639b821bdc&language=pt-BR");
        $serieData = $response->json();

        $favoriteSerie->serie = $serieData; // Adicione os detalhes da série ao objeto $favoriteSerie
    }

   // Verifique se os dados dos filmes favoritos estão em cache
   $favoriteMovies = Cache::remember('user_favorite_movies_' . $user->id, now()->addHours(2), function () use ($user) {
    return $user->favoriteMovies->map(function ($favoriteMovie) {
        $movieId = $favoriteMovie->movie_id;
        $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}?api_key=9549bb8a29df2d575e3372639b821bdc&language=pt-BR");
        $movieData = $response->json();
        $favoriteMovie->movie = $movieData;
        return $favoriteMovie;
    });
});
if ( $user && $user->is_admin==1) {
    return view('layouts.empresa');
} else {
     return view('dashboard',compact('user', 'favoriteSeries','favoriteMovies'));
}


    return view('dashboard', compact('user', 'favoriteSeries','favoriteMovies'));
}
}
