<?php

namespace App\Services\Http\Requests\Radarr;

use App\Services\Http\Requests\RadarrRequest;

class SearchByIdRequest extends RadarrRequest
{
    private int $tmdb_id;

    public function __construct(int $tmdb_id)
    {
        $this->tmdb_id = $tmdb_id;
    }

    public function getRoute(): string
    {
        return 'api/v3/movie/lookup/tmdb';
    }

    public function getParameters(): string
    {
        return "&tmdbId={$this->tmdb_id}";
    }
}
