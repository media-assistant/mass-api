<?php

namespace App\Services\Http\Requests;

class TransmissionRequest extends BaseRequest
{
    public function getRoute(): string
    {
        return 'transmission/rpc';
    }

    public function getBaseUrl(): string
    {
        return (string) config('apis.transmission.url');
    }

    public function getPort(): int
    {
        return config('apis.transmission.port');
    }

    public function getHeaders(): array
    {
        return [
            'X-Transmission-Session-Id' => config('apis.transmission.session_id'),
        ];
    }
}
