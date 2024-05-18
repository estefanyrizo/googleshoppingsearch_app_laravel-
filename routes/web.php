<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;

Route::get('/', [ProductoController::class, 'index']);
Route::post('/buscar', [ProductoController::class, 'buscar'])->name('buscar');


