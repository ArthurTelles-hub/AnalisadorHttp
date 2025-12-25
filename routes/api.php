<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeaderController;

Route::post('/analisar', [HeaderController::class, 'analisar']);
Route::get('/analises', [HeaderController::class, 'listar']);