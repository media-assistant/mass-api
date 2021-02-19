<?php

namespace App\Services\Http\Requests;

abstract class SonarrRequest extends BaseRequest
{
    public function getHost(): string
    {
        return (string) config('apis.sonarr.host');
    }

    public function getPort(): int
    {
        return config('apis.sonarr.port');
    }

    public function getApiString(): string
    {
        $api_key = config('apis.sonarr.api_key');

        return "?apikey={$api_key}";
    }
}
