<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Filme;

use App\Models\HistoricoVisualizacao;
use Auth;

class FilmeController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $apiKey = env('TMDB_API_KEY');

        // Chave única para este cache com base no ID do filme
        $cacheKey = "filme_{$id}";

        $filme = Cache::remember($cacheKey, now()->addHours(2), function () use ($apiKey, $id) {
            $response = Http::get("https://api.themoviedb.org/3/movie/{$id}?api_key={$apiKey}&language=pt-BR");
            $filmeData = $response->json();

            return [
                'title' => $filmeData['title'],
                'id' => $filmeData['id'],
                'overview' => $filmeData['overview'],
                'vote_average' => $filmeData['vote_average'],
                'backdrop_path' => $filmeData['backdrop_path'],
                'runtime' => $filmeData['runtime'],
                'budget' => $filmeData['budget'],
                'revenue' => $filmeData['revenue'],
            ];
        });

       
        $media_type = 'filme';

    

        // Verifique se o usuário está autenticado
        if (Auth::check()) {
            // Verifique se o filme já está no histórico do usuário
            $historicoDoUsuario = $user->historicoVisualizacao()
                ->where('media_id', $id)
                ->where('media_type', 'filme') // Defina o tipo de mídia como 'filme'
                ->exists();

            if (!$historicoDoUsuario) {
                // Adicione o filme_id ao histórico
                $historico = new HistoricoVisualizacao();
                $historico->user_id = $user->id;
                $historico->media_id = $id;
                $historico->media_type = 'filme'; // Defina o tipo de mídia como 'filme'
                $historico->save();
            }
        }

        return view('filmes.show', compact('filme', 'media_type'));
    }

}
