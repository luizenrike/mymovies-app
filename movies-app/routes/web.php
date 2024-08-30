<?php

use App\Http\Controllers\FavoriteMovieController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PublicFavoriteMovieController;
use App\Models\FavoriteMovie;
use Illuminate\Support\Facades\Route;

Route::get('/', [FilmeController::class, 'index']);
Route::get('/genero/{id}', [FilmeController::class, 'filmesPorGenero']);
Route::get('/search', [FilmeController::class, 'filmesSearch']);
Route::get('/filme/{id}', [FilmeController::class, 'filmeDetails']);
Route::get('/list/favoritos/{username}', [PublicFavoriteMovieController::class, 'getListaFavoritos']);

Route::post('/favoritos/adicionar/{movieId}', [FavoriteMovieController::class, 'store'])->middleware('auth');
Route::get('/favoritos', [FavoriteMovieController::class, 'filmesFavoritos'])->middleware('auth');
Route::delete('/favoritos/deletar/{movieId}', [FavoriteMovieController::class, 'destroy'])->middleware('auth');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
