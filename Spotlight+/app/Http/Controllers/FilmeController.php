<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Filme;
use Auth;

class FilmeController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $apiKey = '9549bb8a29df2d575e3372639b821bdc';
        $response = Http::get("https://api.themoviedb.org/3/movie/{$id}?api_key={$apiKey}&language=pt-BR");

        $filme = $response->json();

    

        return view('filmes.show', compact('filme'), compact('user'));
    }

}
