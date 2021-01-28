<?php

namespace App\Http\Controllers\Media;

use App\Enums\AppName;
use App\Http\Controllers\Controller;
use App\Services\Http\Client;
use App\Services\Http\Requests\ProxyRequest;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function radarr(Request $request, Client $client): string
    {
        return $client->doRequest(
            new ProxyRequest($request, AppName::RADARR, 'api/v3')
        )->getBody()->getContents();
    }

    public function sonarr(Request $request, Client $client): string
    {
        return $client->doRequest(
            new ProxyRequest($request, AppName::SONARR, 'api')
        )->getBody()->getContents();
    }

    public function transmission(Request $request, Client $client): string
    {
        return $client->doRequest(
            new ProxyRequest($request, AppName::TRANSMISSION, 'transmission/rpc')
        )->getBody()->getContents();
    }
}
