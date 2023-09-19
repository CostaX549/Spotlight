<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function getApiKey()
    {
        $apiKey = env('TMDB_API_KEY');
        
        return response()->json(['api_key' => $apiKey]);
    }
}
