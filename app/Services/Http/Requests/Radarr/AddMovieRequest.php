<?php

namespace App\Services\Http\Requests\Radarr;

use App\Services\Http\Data\AddItemData;
use App\Services\Http\Requests\RadarrRequest;
use Illuminate\Http\Request;

class AddMovieRequest extends RadarrRequest
{
    private AddItemData $data;

    public function __construct(AddItemData $data)
    {
        $this->data = $data;
    }

    public function getRoute(): string
    {
        return 'api/v3/movie';
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
