<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

use App\Models\HistoricoVisualizacao;

use Illuminate\Support\Facades\Cache;

class MovieDetail extends Component
{
    public $filme;
    public $isFavorite;
 
    public function mount($filmeId)
    {
        $apiKey = env('TMDB_API_KEY');
    
        // Gerar uma chave única de cache para o filme
        $cacheKey = "movie_details_{$filmeId}";
    
        // Tente buscar os detalhes do filme no cache
        $cachedMovieDetails = Cache::get($cacheKey);
    
        if ($cachedMovieDetails === null) {
            // Se não estiver em cache, faça a solicitação à API
            $response = Http::get("https://api.themoviedb.org/3/movie/{$filmeId}?api_key={$apiKey}&language=pt-BR");
            $this->filme = json_decode($response->getBody(), true);
    
            // Armazene os detalhes do filme em cache por um período específico (por exemplo, 24 horas)
            Cache::put($cacheKey, $this->filme, 1440);
        } else {
            // Se estiver em cache, use os detalhes do filme armazenados em cache
            $this->filme = $cachedMovieDetails;
        }
    
        // Verifique se o filme já está na lista de favoritos do usuário
        if (auth()->check()) {
            $user = auth()->user();
            $movieId = $this->filme['id'];
            $this->isFavorite = $user->favoriteMovies()->where('movie_id', $movieId)->exists();
        }
    
        $this->addToHistory();
    }

    public function addToFavorites()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $movieId = $this->filme['id'];

            // Verifique se o filme já está na lista de favoritos do usuário
            $isFavorite = $user->favoriteMovies()->where('movie_id', $movieId)->exists();

            if ($isFavorite) {
                // Remova dos favoritos
                $user->favoriteMovies()->where('movie_id', $movieId)->delete();
            } else {
                // Adicione aos favoritos
                $user->favoriteMovies()->create([
                    'movie_id' => $movieId,
                ]);
            }

            // Atualize o status de favoritos
            $this->isFavorite = !$isFavorite;
        }
         Cache::forget('favorite_movie_details');
    }

    public function addToHistory()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $movieId = $this->filme['id'];

            // Verifique se o filme já está no histórico de visualização do usuário
            $historicoDoUsuario = HistoricoVisualizacao::where('user_id', $user->id)
                ->where('media_id', $movieId)
                ->where('media_type', 'filme')
                ->exists();

            if (!$historicoDoUsuario) {
                // Adicione o filme ao histórico de visualização
                HistoricoVisualizacao::create([
                    'user_id' => $user->id,
                    'media_id' => $movieId,
                    'media_type' => 'filme',
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.spotlight.show')
        ->extends('layouts.main')
      
        
        ->section('title', $this->filme['title'])
        ->section('content');
    }
}
