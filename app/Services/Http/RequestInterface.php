<?php

namespace App\Services\Http;

interface RequestInterface
{
    public function getUrl(): string;

    public function getMethod(): string;

    public function getJson(): array;

    public function getHeaders(): array;
}
