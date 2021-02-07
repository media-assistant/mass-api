<?php

namespace App\Services\Media\Transmission;

use App\Services\Http\Client;
use App\Services\Http\Requests\TransmissionRequest;
use GuzzleHttp\Exception\ClientException;

class TransmissionSession
{
    public static function getSession(string $transmission_url): string
    {
        $request = new TransmissionRequest();

        $transmission_session_id = '';

        try {
            $client = new Client();
            $client->request('GET', "{$transmission_url}/{$request->getRoute()}");
        } catch (ClientException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();

            $matches = [];
            preg_match('/<code>(.+)<\/code>/', $response, $matches);

            if (count($matches) > 1) {
                $transmission_session_id = trim(explode(':', $matches[1])[1]);
            }
        }

        return $transmission_session_id;
    }
}
