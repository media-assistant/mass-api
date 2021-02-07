<?php

namespace App\Services\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class Client extends GuzzleClient
{
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->request(
                $request->getMethod(),
                $request->getUrl(),
                [
                    'json'    => $request->getJson(),
                    'headers' => $request->getHeaders(),
                ]
            );
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        }

        return $response;
    }
}
