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

function formError(array $errors, string $field): string
{
    if (!isset($errors[$field])) {
        return '';
    }

    return '<div class="text-danger fw-bold mt-2 p-2">'
         . e($errors[$field][0])
         . '</div>';
}

function getNowNextYear(): array
{
    return [
        'now' => date('Y-m-d\TH:i'),
        'nextYear' => date('Y-m-d\TH:i', strtotime('+1 year'))
    ];
}
