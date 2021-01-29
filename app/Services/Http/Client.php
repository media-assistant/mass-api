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
            $reponse = $this->request(
                $request->getMethod(),
                $request->getUrl(),
                [
                    'json'    => $request->getJson(),
                    'headers' => $request->getHeaders(),
                ]
            );
        } catch (ClientException $exception) {
            $reponse = $exception->getResponse();
        }

        return $reponse;
    }
}
