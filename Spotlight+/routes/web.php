<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\FavoriteMovieController;
use App\Http\Controllers\FavoriteSerieController;
use App\Http\Controllers\DocumentarioController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\NoCacheMiddleware;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use App\Http\Controllers\ApiKeyController;
use Illuminate\Support\Facades\Gate;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



  // Rota para exibir o painel de controle do usuário
  Route::get('/dashboard', 'App\Http\Controllers\FavoriteSerieController@dashboard')->name('dashboard');



Route::get('/filmes/{id}', [FilmeController::class, 'show'])
    ->name('filmes.show')
    ->middleware(\App\Http\Middleware\CheckMovieAccess::class);
Route::get('/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa.index');
Route::get('/historico', [HistoricoController::class, 'mostrarHistorico'])->name('historico');
Route::get('/ranking', [RankingController::class, 'rankingAvaliacao'])->name('ranking');

Route::get('/filmes', [FilmeController::class, 'index'])->name('filmes.index');
Route::post('/favorite/add', 'App\Http\Controllers\FavoriteMovieController@addToFavorites')->name('favorite.add');
Route::post('/favorite/remove', 'App\Http\Controllers\FavoriteMovieController@removeFromFavorites')->name('favorite.remove');

Route::get('/series/{id}', [SerieController::class, 'show'])->name('series.show'); 
Route::get('/documentarios/{id}', [DocumentarioController::class, 'show'])->name('documentarios.show');

Route::get('/', [PesquisaController::class, 'welcome'])->name('pesquisa.welcome');
Route::get('/api-key', [ApiKeyController::class, 'getApiKey']);

Route::middleware(['auth'])->group(function () {
    // Rota para adicionar uma série aos favoritos
    Route::post('/series/favorite/add', 'App\Http\Controllers\FavoriteSerieController@addToFavorites')->name('series.favorite.add');

    // Rota para remover uma série dos favoritos
    Route::post('/series/favorite/remove', 'App\Http\Controllers\FavoriteSerieController@removeFromFavorites')->name('series.favorite.remove');

  
});

Route::get('/sobrenos',function () {
return view('sobrenos');
});

Route::delete('/historico/removerSelecionados', [HistoricoController::class, 'removerSelecionados'])->name('historico.removerSelecionados');

Route::delete('historico/limpar', 'App\Http\Controllers\HistoricoController@limparHistorico')->name('historico.limpar');
Route::get('/series/{id}/temporadas', [SerieController::class, 'showSeasons'])->name('series.temporadas');




