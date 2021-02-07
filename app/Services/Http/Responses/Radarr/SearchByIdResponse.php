<?php

namespace App\Services\Http\Responses\Radarr;

use App\Services\Http\Data\AddItemData;
use Psr\Http\Message\ResponseInterface;

class SearchByIdResponse
{
    public AddItemData $data;

    public function __construct(ResponseInterface $response)
    {
        $this->data = new AddItemData(
            json_decode($response->getBody()->getContents())
        );
    }
}
