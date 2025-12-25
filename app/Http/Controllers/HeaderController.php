<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HeaderAnalyzer;
use App\Services\HeaderFetcher;
use App\Models\Analise;

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

        $analise = Analise::create([
            'url' => $request->url,
            'status_code' => $resultado['status_code'],
            'score' => $resultado['score'],
            'nivel' => $resultado['nivel'],
            'security_headers' => $resultado['security_headers'],
            'cookies_inseguros' => $resultado['cookies']['inseguros'],
        ]);
    }

    public function listar()
    {
        $analises = Analise::orderBy('created_at', 'desc')->get();

        return responde()->json($analises);
    }
}
