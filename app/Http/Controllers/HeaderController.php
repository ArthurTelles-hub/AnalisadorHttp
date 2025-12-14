<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HeaderAnalyzer;
use App\Services\HeaderFetcher;

class HeaderController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function analisar(
        Request $request,
        HeaderFetcher $fetcher,
        HeaderAnalyzer $analyzer
    )
    {
        $request->validate([
            'url' => ['required','url']
        ]);

        $headers = $fetcher->fetch($request->url);

        $resultado = $analyzer->analyze($headers);

        return response()->json([
            'url' => $request->url,
            'resultado' => $resultado
        ]);
    }
}
