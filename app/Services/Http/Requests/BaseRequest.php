<?php

namespace App\Services\Http\Requests;

use App\Services\Http\RequestInterface;
use Illuminate\Http\Request;

abstract class BaseRequest implements RequestInterface
{
    public function getUrl(): string
    {
        return "http://{$this->getHost()}:{$this->getPort()}/{$this->getRoute()}{$this->getApiString()}{$this->getParameters()}";
    }

    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getParameters(): string
    {
        return '';
    }

    public function getApiString(): string
    {
        return '';
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
