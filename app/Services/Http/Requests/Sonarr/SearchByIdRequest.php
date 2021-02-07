<?php

namespace App\Services\Http\Requests\Sonarr;

use App\Services\Http\Requests\SonarrRequest;

class SearchByIdRequest extends SonarrRequest
{
    private int $tvdb_id;

    public function __construct(int $tvdb_id)
    {
        $this->tvdb_id = $tvdb_id;
    }

    public function getRoute(): string
    {
        return 'api/series/lookup';
    }

    public function getParameters(): string
    {
        return "&term=tvdb:{$this->tvdb_id}";
    }
}
