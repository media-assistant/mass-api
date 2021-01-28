<?php

namespace App\Services\Http\Requests;

use App\Services\Http\ResponseInterface;
use App\Services\Http\Responses\StringResponse;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class TransmissionRequest extends BaseRequest
{
    public function getRoute(): string
    {
        return 'transmission/rpc';
    }

    public function getHost(): string
    {
        return (string) config('apis.transmission.ip');
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

    public function getResponseData(PsrResponseInterface $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}
