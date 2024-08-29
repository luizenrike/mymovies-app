<?php

use App\Http\Controllers\FilmeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FilmeController::class, 'index']);
Route::get('/genero/{id}', [FilmeController::class, 'filmesPorGenero']);
Route::get('/search', [FilmeController::class, 'filmesSearch']);