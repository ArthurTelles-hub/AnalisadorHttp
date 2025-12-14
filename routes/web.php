<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [HeaderCrontorller::class, 'index']);

Route::get('/analisar', [HeaderCrontorller::class, 'analisar']);