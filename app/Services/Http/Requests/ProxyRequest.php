<?php

namespace App\Services\Http\Requests;

use Exception;
use Illuminate\Http\Request;

class ProxyRequest extends BaseRequest
{
    private Request $request;
    private string $config_key;
    private string $route_prefix;

    public function __construct(Request $request, string $config_key, string $route_prefix)
    {
        $this->request      = $request;
        $this->config_key   = $config_key;
        $this->route_prefix = $route_prefix;
    }

    public function getMethod(): string
    {
        return $this->request->method();
    }

    public function getJson(): array
    {
        return $this->request->all();
    }

    public function getHeaders(): array
    {
        if ('transmission' === $this->config_key) {
            return [
                'X-Transmission-Session-Id' => config('docker.transmission.session_id'),
            ];
        }

        return [];
    }

    protected function getBaseUrl(): string
    {
        return (string) config("docker.{$this->config_key}.url");
    }

    protected function getRoute(): string
    {
        $split = preg_split("/\\/{$this->config_key}\\//", $this->request->url()) ?: [];

        if (2 !== count($split)) {
            throw new Exception('Route not splittable');
        }

        return "{$this->route_prefix}/{$split[1]}";
    }

    public function getApiString(): string
    {
        if ('transmission' === $this->config_key) {
            return '?';
        }

        $api_key = config("docker.{$this->config_key}.api_key");

        return "?apikey={$api_key}";
    }

    public function getParameters(): string
    {
        if ('transmission' === $this->config_key) {
            return '';
        }

        return "&{$this->request->getQueryString()}" ?? '';
    }
}
