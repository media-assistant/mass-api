<?php

namespace App\Library;

class Url
{
    public static function baseUrl(string $host, string $port, string $protocol = 'http'): string
    {
        return "{$protocol}://{$host}:{$port}";
    }
}
