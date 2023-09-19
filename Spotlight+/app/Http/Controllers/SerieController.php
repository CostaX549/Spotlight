<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoVisualizacao;
use Illuminate\Support\Facades\Http;
use App\Models\Serie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

use Auth;

class SerieController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $apiKey = env('TMDB_API_KEY');

        // Chave única para este cache com base no ID da série
        $cacheKey = "serie_{$id}";

        $serie = Cache::remember($cacheKey, now()->addHours(2), function () use ($apiKey, $id) {
            $response = Http::get("https://api.themoviedb.org/3/tv/{$id}?api_key={$apiKey}&language=pt-BR");
            $serieData = $response->json();

            return [
                'title' => $serieData['name'],
                'id' => $serieData['id'],
                'overview' => $serieData['overview'],
                'vote_average' => $serieData['vote_average'],
                'backdrop_path' => $serieData['backdrop_path'],
                'seasons' => $serieData['seasons'],
            ];
            
        });
        // Verifique se o usuário está autenticado
        if (Auth::check()) {
            // Verifique se a série já está no histórico do usuário
            $historicoDoUsuario = $user->historicoVisualizacao()
                ->where('media_id', $id)
                ->where('media_type', 'serie') // Defina o tipo de mídia como 'serie'
                ->exists();

            if (!$historicoDoUsuario) {
                // Adicione o serie_id ao histórico
                $historico = new HistoricoVisualizacao();
                $historico->user_id = $user->id;
                $historico->media_id = $id;
                $historico->media_type = 'serie'; // Defina o tipo de mídia como 'serie'
                $historico->save();
            }
        }

        $seasonCount = count(array_filter($serie['seasons'], function ($season) {
            return $season['season_number'] > 0;
        }));

        return view('series.show', compact('serie', 'user', 'seasonCount'));
    }

    public function showSeasons($id)
{
    $apiKey = env('TMDB_API_KEY');

    // Defina uma chave única para o cache com base no ID da série
    $cacheKey = "seasons_{$id}";

    // Tente obter os resultados do cache se já estiverem em cache
    list($seasons, $serieName) = Cache::remember($cacheKey, now()->addHours(2), function () use ($apiKey, $id) {
        // Obter os detalhes da série em português
        $portugueseResponse = Http::get("https://api.themoviedb.org/3/tv/{$id}?api_key={$apiKey}&language=pt-BR");
        $portugueseSerieData = $portugueseResponse->json();

        // Obter os detalhes da série em inglês
        $englishResponse = Http::get("https://api.themoviedb.org/3/tv/{$id}?api_key={$apiKey}&language=en-US");
        $englishSerieData = $englishResponse->json();

        $seasons = [];

        // Verificar se há informações em português e usá-las, senão usar em inglês
        if (array_key_exists('seasons', $portugueseSerieData)) {
            $seasons = $portugueseSerieData['seasons'];
            $serieName = $portugueseSerieData['name']; // Nome da série em português
        } elseif (array_key_exists('seasons', $englishSerieData)) {
            $seasons = $englishSerieData['seasons'];
            $serieName = $englishSerieData['name']; // Nome da série em inglês
        }

        return [$seasons, $serieName];
    });

    return view('series.temporadas', compact('seasons', 'serieName'));
}


}
