<?php

namespace App\Http\Controllers;

use App\Models\HistoricoVisualizacao;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class HistoricoController extends Controller
{
   public function mostrarHistorico()
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
   
   
    // Passar os dados para a view e renderizar a página
    return view('historico', ['mediaComDetalhes' => $mediaComDetalhes, 'historico' => $historico,]);
}


    public function limparHistorico()
    {
        $userId = auth()->id();

        // Exclua todos os registros de histórico para o usuário
        HistoricoVisualizacao::where('user_id', $userId)->delete();

        return redirect()->back()->with('success', 'Histórico limpo com sucesso');
    }
    public function removerSelecionados(Request $request)
    {
        $userId = auth()->id();
        $itensSelecionados = $request->input('itens_selecionados',[]);
    
        // Verifique se há itens selecionados
        if (count($itensSelecionados) === 0) {
            return redirect()->back()->with('error', 'Nenhum item selecionado para remover');
        }
    
        // Exclua os registros de histórico correspondentes aos itens selecionados
        HistoricoVisualizacao::where('user_id', $userId)
            ->whereIn('media_id', $itensSelecionados)
            ->delete();
    
        return redirect()->back()->with('success', 'Itens selecionados removidos com sucesso');
    }

}


