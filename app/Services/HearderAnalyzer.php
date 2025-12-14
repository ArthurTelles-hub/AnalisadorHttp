<?php

namespace App\Services;

class HeaderAnalyzer
{
	public function analyze(array $data): array
	{
		$headers = $this->normalizeHeaders($data['headers'] ?? []);
		$status = $data['status'] ?? null;

		$security = $this->analyzeSecurityHeaders($headers);
		$cookies = $this->analyzeCookies($headers);
		$score = $this->calculateScore($security, $cookies);

		return [
			'status_code' => $status,
			'server' => $headers['server'][0] ?? 'Não informado',
			'https' => isset($headers['strict-transport-security']),
			'security_headers' => $security,
			'cookies' => $cookies,
			'score' => $score,
			'nivel' => $this->scoreLevel($score),
		];
	}

    private function normalizeHearders(array $headers): array
    {
        $normalized = [];

        foreach ($headers as $key => $value) {
            $normalized[strtolower($key)] = $value;
        }

        return $normalized;
    }

    private function analyzeSecurityHeaders(array $headers): array
    {
        return [
            'Content-Security-Policy' => isset($headers['content-security-policy']),
            'Strict-Transport-Security' => isset($headers['strict-transport-security']),
            'X-Frame-Options' => isset($headers['x-frame-options']),
            'X-Content-Type-Options' => isset($headers['x-content-type-options']),
            'Referrer-Policy' => isset($headers['referrer-policy']),
            'Permissions-Policy' => isset($headers['permissions-policy']),
        ];
    }

    private function analyzeCookies(array $headers): array 
    {
        $cookies = $headers['set-cookie'] ?? [];

        $insecure = [];

        foreach($cookies as $cookie) {
            if (!str_contains(strtolower($cookie), 'secure') || 
            !str_contains(strtolower($cookie), 'httponly')) {
                $insecure[] = $cookie;
            }
        }

        return [
            'total' => count($cookies),
            'inseguros' => $insecure
        ];
    }

    private function calculateScore(array $security, array $cookies): int 
    {
        $score = 0;

        foreach($security as $present) {
            $score += $present ? 10 : -5;
        }

        if (count($cookies['inseguro']) === 0) {
            $score += 20;
        }

        return max(0, min(100, $score));
    }

    private function scoreLevel(int $score): string 
    {
        return match (true) {
            $score >= 80 => 'Alto',
            $score >= 50 => 'Médio',
            default => 'Baixo',
        };
    }
}
