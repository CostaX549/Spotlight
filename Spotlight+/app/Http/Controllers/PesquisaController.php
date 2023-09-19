<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSearchTerm; // Importe o modelo UserSearchTerm
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB; // Importe a classe DB

class PesquisaController extends Controller
{
    private function getFrequentSearchTerms($user, $limit = 5)
    {
        // Verifique se o usuário está autenticado
        if (Auth::check()) {
            // O usuário está autenticado, podemos continuar com a consulta
            $frequentTerms = UserSearchTerm::where('user_id', $user->id)
                ->groupBy('search_term')
                ->select('search_term', DB::raw('count(*) as total'))
                ->orderBy('created_at', 'desc')
                ->pluck('search_term');
    
            return $frequentTerms;
        } else {
            // O usuário não está autenticado, retorne um valor vazio ou lance uma exceção, dependendo dos requisitos do seu aplicativo.
            return [];
        }
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        $resultados = [];
        $recommendedMovieIds = [];
        
        if ($request->has('termo')) {
            $termo = $request->input('termo');
            $apiKey = env('TMDB_API_KEY');

            // Consulta de cache
           $resultados = Cache::remember('search_results_'.$termo, now()->addHours(1), function () use ($termo, $apiKey) {
            $response = Http::get("https://api.themoviedb.org/3/search/multi", [
                'api_key' => $apiKey,
                'language' => 'pt-BR',
                'query' => $termo,
                'certification_country' => 'BR',
                'certification.lte' => '16'
            ]);

            $data = $response->json();

            if (!empty($data['results'])) {
                $unwantedMovieIds = [617932]; // Substitua pelos IDs dos filmes indesejados
                
                // Filtrar os resultados, excluindo os filmes indesejados pelo ID e pela popularidade
                $resultados = array_filter($data['results'], function ($result) use ($unwantedMovieIds) {
                    $isUnwanted = in_array($result['id'], $unwantedMovieIds);
                    $isPopular = $result['popularity'] > 5; // Ajuste o valor da popularidade conforme necessário
                    return !$isUnwanted && $isPopular;
                });
                
                // Reindexar o array resultante para evitar índices vazios
                $resultados = array_values($resultados);
                
                return $resultados; // Retorna os resultados filtrados
            }
            
            return []; // Retorna um array vazio se não houver resultados
        });
        if (!empty($resultados)) {
            // Salvar o termo de pesquisa do usuário
            if (Auth::check()) {
                $searchTerm = $request->input('termo');
                UserSearchTerm::create([
                    'user_id' => $user->id,
                    'search_term' => $searchTerm,
                ]);
        
                // Calcular a frequência dos termos de pesquisa
                $termFrequencies = UserSearchTerm::where('user_id', $user->id)
                    ->select('search_term', \DB::raw('count(*) as count'))
                    ->groupBy('search_term')
                    ->orderBy('count', 'desc')
                    ->get();
            }
        }
    } else {
        return view('welcome', compact('resultados'));
    }

        $frequentSearchTerms = $this->getFrequentSearchTerms($user);
        return view('welcome', compact('resultados', 'frequentSearchTerms', 'user'));
    }   

    public function welcome(Request $request)
    {
         // Configuração da API do The Movie DB
         $apiKey = env('TMDB_API_KEY');
         $language = 'pt-BR';
 
         // Preparar dados para Filmes
    $filmes = Cache::remember('filmes_cache_key', now()->addHours(2), function () use ($apiKey, $language) {
        $apiUrl = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language={$language}&certification_country=BR&certification.lte=12&page=1";
        return $this->fetchCarouselData($apiUrl);
    });

    // Preparar dados para Séries
    $series = Cache::remember('series_cache_key', now()->addHours(2), function () use ($apiKey, $language) {
        $disneyPlusSeries = $this->fetchCarouselData(
            "https://api.themoviedb.org/3/discover/tv?api_key={$apiKey}&language={$language}&with_networks=2739"
        );

        $netflixSeries = $this->fetchCarouselData(
            "https://api.themoviedb.org/3/discover/tv?api_key={$apiKey}&language={$language}&with_networks=213"
        );

        return array_merge($disneyPlusSeries, $netflixSeries);
    });

    // Preparar dados para Documentários
    $documentarios = Cache::remember('documentarios_cache_key', now()->addHours(2), function () use ($apiKey, $language) {
        $apiUrl = "https://api.themoviedb.org/3/discover/movie?api_key={$apiKey}&with_genres=99&language={$language}&certification_country=BR&certification.lte=12";
        return $this->fetchCarouselData($apiUrl);
    });
    
 // Preparar dados para Animes (adicione esta parte)
 $animes = Cache::remember('animes_cache_key', now()->addHours(2), function () use ($apiKey, $language) {
    $apiUrl = "https://api.themoviedb.org/3/discover/tv?api_key={$apiKey}&language={$language}&with_genres=16&certification_country=BR&certification.lte=12";
    return $this->fetchCarouselData($apiUrl);
});

        $user = Auth::user();
        

        // Reutilizar a lógica do método index para buscar termos frequentes e filmes relacionados
        $frequentSearchTerms = $this->getFrequentSearchTerms($user);
       

       

        return view('welcome', compact('frequentSearchTerms','user', 'series', 'filmes', 'documentarios', 'animes'));
        
    }

      // Função para buscar dados da API e formatá-los conforme necessário
      private function fetchCarouselData($apiUrl)
      {
          $response = Http::get($apiUrl);
          $data = $response->json();
  
          // Aqui, você pode formatar os dados conforme necessário, selecionando apenas os campos que deseja exibir nos carrosséis.
          // Certifique-se de estruturar os dados de acordo com a sua view.
  
          return $data['results'] ?? [];
      }

  

}

  



    

