<?php
/**
 * HTTP/CORS bootstrap for the educational API.
 *
 * Configure APP_ALLOWED_ORIGINS as a comma-separated list in non-local
 * environments. Wildcard origins are intentionally not supported.
 */
function applyJsonCors(): void
{
    header('Content-Type: application/json; charset=UTF-8');
    header('Vary: Origin');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization');

    $configuredOrigins = getenv('APP_ALLOWED_ORIGINS');
    if ($configuredOrigins === false || trim($configuredOrigins) === '') {
        $configuredOrigins = 'http://localhost:4200,http://127.0.0.1:4200';
    }

    $allowedOrigins = array_values(array_filter(array_map('trim', explode(',', $configuredOrigins))));
    $requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? null;

    if ($requestOrigin !== null && in_array($requestOrigin, $allowedOrigins, true)) {
        header('Access-Control-Allow-Origin: ' . $requestOrigin);
    }

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
        http_response_code(204);
        exit();
    }
}
