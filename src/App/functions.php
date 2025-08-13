<?php

declare(strict_types=1);

use Framework\Http;

function dd(mixed $value)
{

    echo "<pre>";
    print_r($value);
    echo "</pre>";
    die();
}

function e(mixed $value): string 
{
    return htmlspecialchars((string)$value);

}

function redirectTo(string $path)
{
    error_log("Redirecting to: {$path}"); // 👈 zapis do logów
    header("location: {$path}");
    http_response_code(Http::REDIRECT_STATUS_CODE);
    exit;
}
