<?php

namespace App\Services\Http\Requests\Sonarr;

use App\Services\Http\Data\AddItemData;
use App\Services\Http\Requests\SonarrRequest;
use Illuminate\Http\Request;

class AddSeriesRequest extends SonarrRequest
{
    private AddItemData $data;

    public function __construct(AddItemData $data)
    {
        $this->data = $data;
    }

    public function getRoute(): string
    {
        return 'api/series';
    }

    public function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getJson(): array
    {
        return (array) $this->data;
    }
}
