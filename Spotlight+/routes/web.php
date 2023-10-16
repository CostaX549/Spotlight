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
use App\Http\Livewire\MovieDetail;
use App\Http\Livewire\SerieDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\NoCacheMiddleware;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use App\Http\Controllers\ApiKeyController;
use App\Http\Livewire\Dashboard;

use App\Http\Livewire\Historico;
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



Route::get('/historico', Historico::class);

  Route::get('/filmes/{filmeId}', MovieDetail::class)->name('filmes.show')
  ->middleware(\App\Http\Middleware\CheckMovieAccess::class);

  Route::get('/series/{serieId}', SerieDetail::class)->name('series.show'); 

Route::get('/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa.index');

Route::get('/ranking', [RankingController::class, 'rankingAvaliacao'])->name('ranking');

Route::get('/filmes', [FilmeController::class, 'index'])->name('filmes.index');
Route::get('/dashboard', Dashboard::class)->name('dashboard');

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




