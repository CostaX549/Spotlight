<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http; // Importe a classe Http

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cache;

class FavoriteMovieController extends Controller
{
    public function addToFavorites(Request $request)
{
    $user = Auth::user();
    $movieId = $request->input('movie_id');
    $favoriteMovies = $user->favoriteMovies()->get();
    
    // Verificar se o filme já foi adicionado aos favoritos desse usuário
    if (!$user->favoriteMovies()->where('movie_id', $movieId)->exists()) {
        $user->favoriteMovies()->create([
            'movie_id' => $movieId,
        ]);
  // Limpe o cache dos dados dos filmes favoritos
  Cache::forget('user_favorite_movies_' . $user->id);
        return redirect('/dashboard')->with('success', 'Filme adicionado aos favoritos com sucesso.');
    }

    return redirect()->back()->with('error', 'Filme já está nos favoritos.');
}

public function removeFromFavorites(Request $request)
{
    $user = Auth::user();
    $movieId = $request->input('movie_id');
    
    // Remove o filme dos favoritos do usuário
    $user->favoriteMovies()->where('movie_id', $movieId)->delete();
    Cache::forget('user_favorite_movies_' . $user->id);
    return redirect('/dashboard');
 
}





// ...


// ...















}
