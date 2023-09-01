<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use App\Models\Serie;
use App\Models\Temporada;

use Auth;

class SerieController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $apiKey = '9549bb8a29df2d575e3372639b821bdc';
        $response = Http::get("https://api.themoviedb.org/3/tv/{$id}?api_key={$apiKey}&language=pt-BR");

        $serieData = $response->json();

        $serie = new Serie([
            'title' => $serieData['name'],
            'id' => $serieData['id'],
            'overview' => $serieData['overview'],
            'vote_average' => $serieData['vote_average'],
            'backdrop_path' => $serieData['backdrop_path'],
        ]);

        $temporadas = $serieData['seasons']; // Supondo que as informações das temporadas estejam no array 'seasons'

        return view('series.show', compact('serie', 'temporadas'), compact('user'));
    }
}
