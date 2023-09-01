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

    private function getFrequentSearchTerms($user, $minFrequency = 5, $limit = 5)
    {
        return UserSearchTerm::where('user_id', $user->id)
            ->groupBy('search_term')
            ->select('search_term', DB::raw('count(*) as total'))
            ->having('total', '>=', $minFrequency) // Filtro para termos com frequência maior ou igual a $minFrequency
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->pluck('search_term');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $resultados = [];
        $recommendedMovieIds = [];
        
        if ($request->has('termo')) {
            $termo = $request->input('termo');
            $apiKey = '9549bb8a29df2d575e3372639b821bdc';

            // Consulta de cache
           $resultados = Cache::remember('search_results_'.$termo, now()->addHours(1), function () use ($termo, $apiKey) {
            $response = Http::get("https://api.themoviedb.org/3/search/multi", [
                'api_key' => $apiKey,
                'language' => 'pt-BR',
                'query' => $termo,
                'certification_country' => 'BR',
                'certification.lte' => '12'
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
            // Salvar o termo de pesquisa do usuário
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

            // Selecionar os termos mais frequentes (pode ser os 3 primeiros, por exemplo)
            $mostFrequentTerms = $termFrequencies->pluck('search_term')->take(3);

            // Encontrar filmes relacionados aos termos mais pesquisados
            $relatedMovieIds = [];
            foreach ($mostFrequentTerms as $term) {
                $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                    'api_key' => $apiKey,
                    'language' => 'pt-BR',
                    'query' => $term,
                ]);

                $data = $response->json();

                if (!empty($data['results'])) {
                    foreach ($data['results'] as $result) {
                        $relatedMovieIds[] = $result['id'];
                    }
                }
            }
            
            // Limitar o número de filmes relacionados
            $relatedMovieIds = array_slice($relatedMovieIds, 0, 8);
        }
      

        $frequentSearchTerms = $this->getFrequentSearchTerms($user);
        return view('welcome', compact('resultados', 'frequentSearchTerms', 'user'));
    }   

    public function welcome(Request $request)
    {
        $user = Auth::user();
        $apiKey = '9549bb8a29df2d575e3372639b821bdc';

        // Reutilizar a lógica do método index para buscar termos frequentes e filmes relacionados
        $frequentSearchTerms = $this->getFrequentSearchTerms($user);
        $relatedMovieIds = [];

        if (session()->has('related_movies')) {
            $relatedMovieIds = session('related_movies');
        }

        return view('welcome', compact('frequentSearchTerms', 'relatedMovieIds', 'user'));
    }

}

  



    

