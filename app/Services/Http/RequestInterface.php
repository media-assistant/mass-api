<?php

namespace App\Services\Http;

interface RequestInterface
{
    public function getBaseUrl(): string;

    public function getMethod(): string;

    public function getApiString(): string;

    public function getRoute(): string;

    public function getUrl(): string;

    public function getParameters(): string;

    public function getJson(): array;

    public function getHeaders(): array;
}
