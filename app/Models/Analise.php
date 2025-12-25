<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analise extends Model
{
    protected $fillable = [
        'url',
        'status_code',
        'score',
        'nivel',
        'security_headers',
        'cookies_inseguros',
    ];

    protected $casts = [
        'security_headers' => 'array',
        'cookies_inseguros' => 'array',
    ];
}
