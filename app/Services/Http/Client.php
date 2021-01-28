<?php

namespace App\Services\Http;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class Client extends GuzzleClient
{
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        return $this->request(
            $request->getMethod(),
            $request->getUrl(),
            [
                'json'    => $request->getJson(),
                'headers' => $request->getHeaders(),
            ]
        );
    }
}
