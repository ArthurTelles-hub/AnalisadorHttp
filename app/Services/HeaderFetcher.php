<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HeaderFetcher
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'allow_redirects' => true,
            'http_errors' => false,
            'verify' => true,
            'headers' => [
                'User-Agent' => 'HeaderAnalyzer/1.0'
            ],
        ]);
    }

    public function fetch(string $url): array
    {
        try {
            $response = $this->client->head($url);

            return [
                'status' => $reponse->getStatusCode(),
                'headers' => $response->getHeaders()
            ];
        }catch (RequestException $e) {
            return [
                'errors' => 'Erro ao acessar a URL',
                'message' => $e->getMessage()
            ];
        }
    }
}