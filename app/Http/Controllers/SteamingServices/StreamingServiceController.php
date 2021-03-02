<?php

namespace App\Http\Controllers\StreamingServices;

use App\Http\Controllers\Controller;
use App\Http\Resources\StearmingServiceResource;
use App\Services\Http\Client;
use App\Services\JustWatch\SearchRequest;

class StreamingServiceController extends Controller
{
    public function searchMovie(string $query, Client $client)
    {
        $response = $client->doRequest(new SearchRequest($query, 'movie'));

        StearmingServiceResource::make(json_decode($response->getBody()));
    }

    public function searchSeries(string $query, Client $client)
    {
        $response = $client->doRequest(new SearchRequest($query, 'show'));

        StearmingServiceResource::make(json_decode($response->getBody()));
    }
}