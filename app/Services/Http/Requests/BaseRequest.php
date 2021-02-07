<?php

namespace App\Services\Http\Requests;

use App\Services\Http\RequestInterface;
use Illuminate\Http\Request;

abstract class BaseRequest implements RequestInterface
{
    public function getUrl(): string
    {
        return "{$this->getBaseUrl()}/{$this->getRoute()}{$this->getApiString()}{$this->getParameters()}";
    }

    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getJson(): array
    {
        return [];
    }

    protected function getBaseUrl(): string
    {
        return '';
    }

    protected function getRoute(): string
    {
        return '';
    }

    protected function getApiString(): string
    {
        return '';
    }

    protected function getParameters(): string
    {
        return '';
    }
}
