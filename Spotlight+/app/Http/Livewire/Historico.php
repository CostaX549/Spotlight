<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\HistoricoVisualizacao;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class Historico extends Component
{
    public function render()
    {
        $userId = auth()->id();

    // Recupere o histórico de visualizações do usuário autenticado com paginação
    $historico = HistoricoVisualizacao::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->paginate(8);

    $mediaComDetalhes = [];

    foreach ($historico as $registro) {
        $mediaCacheKey = "media_{$registro->media_id}_{$registro->media_type}";

        // Verifique se os detalhes da mídia estão em cache; se não, eles serão buscados ou armazenados em cache
        $mediaDetalhes = Cache::remember($mediaCacheKey, now()->addHours(2), function () use ($registro) {
            $apiKey = env('TMDB_API_KEY');
            $endpoint = '';

            if ($registro->media_type === 'filme') {
                $endpoint = "movie/{$registro->media_id}";
            } elseif ($registro->media_type === 'serie') {
                $endpoint = "tv/{$registro->media_id}";
            }

            // Verifique se a resposta da API está em cache
            $apiResponseCacheKey = "api_response_{$endpoint}";

            $apiResponse = Cache::remember($apiResponseCacheKey, now()->addHours(2), function () use ($apiKey, $endpoint) {
                $response = Http::get("https://api.themoviedb.org/3/{$endpoint}?api_key={$apiKey}&language=pt-BR");
                return $response->json();
            });

            if (!empty($apiResponse)) {
                // Obtenha os detalhes relevantes da mídia a partir da resposta da API em cache
                return [
                    'media_id' => $registro->media_id,
                    'media_type' => $registro->media_type,
                    'title' => $apiResponse['title'] ?? $apiResponse['name'],
                    'poster_path' => $apiResponse['poster_path'],
                    'data_visualizacao' => $registro->created_at,
                ];
            }

            return null;
        });

        if ($mediaDetalhes !== null) {
            $mediaComDetalhes[] = $mediaDetalhes;
        }
    }
    return view('livewire.spotlight.historico', ['mediaComDetalhes' => $mediaComDetalhes, 'historico' => $historico]);
    }
}
