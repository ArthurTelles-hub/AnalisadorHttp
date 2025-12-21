<?php

use App\Http\Controllers\HeaderController;

Route::post('/analisar', [HeaderController::class, 'analisar']);