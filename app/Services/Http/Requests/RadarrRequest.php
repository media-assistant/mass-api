<?php

namespace App\Services\Http\Requests;

abstract class RadarrRequest extends BaseRequest
{
    public function getBaseUrl(): string
    {
        return (string) config('docker.radarr.url');
    }

    public function getApiString(): string
    {
        $api_key = config('docker.radarr.api_key');

        return "?apikey={$api_key}";
    }
}
