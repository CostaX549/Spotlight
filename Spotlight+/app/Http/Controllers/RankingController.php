<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RankingController extends Controller
{
    public function rankingAvaliacao()
    {
        $apiKey = env('TMDB_API_KEY');

        // Defina os critérios de classificação
        $minPopularidade = 100; // Defina a popularidade mínima desejada

        // Consulte a API TMDb para obter os filmes que atendem aos critérios, classificados por popularidade e idioma em pt-BR
        $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
            'api_key' => $apiKey,
            'sort_by' => 'popularity.desc', // Classificar por popularidade em ordem decrescente
            'popularity.gte' => $minPopularidade,
            'page' => 1, // Página de resultados (você pode ajustar conforme necessário)
            'language' => 'pt-BR', // Definir idioma para pt-BR
        ]);

        $filmes = $response->json()['results']; // Obtenha os filmes que atendem aos critérios

        return view('ranking', compact('filmes'));
    }
}
