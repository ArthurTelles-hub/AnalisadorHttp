<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeaderController;

Route::get('/', [HeaderController::class, 'index']);

Route::get('/analisar', [HeaderController::class, 'analisar']);