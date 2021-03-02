<?php

namespace App\Services\JustWatch;

use App\Services\Http\RequestInterface;
use Illuminate\Http\Request;

class SearchRequest implements RequestInterface
{
    private string $query;
    private string $type;

    public function __construct(string $query, string $type)
    {
        $this->query = $query;
        $this->type = $type;
    }

    public function getUrl(): string
    {
        return 'https://apis.justwatch.com/content/titles/en_NL/popular?language=en&body={"page_size":1,"page":1,"query":"' . $this->query . '","content_types":["' . $this->type . '"]}';
    }

    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getJson(): array
    {
        return [];
    }

    public function getHeaders(): array
    {
        return [];
    }
}