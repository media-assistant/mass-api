<?php

namespace App\Http\Controllers\Media;

use App\Enums\AppName;
use App\Http\Controllers\Controller;
use App\Services\Http\Client;
use App\Services\Http\Requests\ProxyRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProxyController extends Controller
{
    public function radarr(Request $request): Response
    {
        return $this->doRequest(
            new ProxyRequest($request, AppName::RADARR, 'api/v3')
        );
    }

    public function sonarr(Request $request): Response
    {
        return $this->doRequest(
            new ProxyRequest($request, AppName::SONARR, 'api')
        );
    }

    public function transmission(Request $request): Response
    {
        return $this->doRequest(
            new ProxyRequest($request, AppName::TRANSMISSION, 'transmission/rpc')
        );
    }

    public function doRequest(ProxyRequest $request): Response
    {
        $reponse = (new Client())->doRequest($request);

        return response($reponse->getBody()->getContents(), $reponse->getStatusCode(), $reponse->getHeaders());
    }
}
