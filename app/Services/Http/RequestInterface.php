<?php

namespace App\Services\Http;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface RequestInterface
{
    public function getPort(): int;

    public function getHost(): string;

    public function getMethod(): string;

    public function getApiString(): string;

    public function getRoute(): string;

    public function getUrl(): string;

    public function getParameters(): string;

    public function getJson(): array;

    public function getHeaders(): array;

    public function getResponseData(PsrResponseInterface $response): ResponseInterface;
}
