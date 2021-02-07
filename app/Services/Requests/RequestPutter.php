<?php

namespace App\Services\Requests;

use App\Enums\ItemType;
use App\Models\Request\Request;
use App\Services\Http\Client;
use App\Services\Http\Requests\Radarr\AddMovieRequest;
use App\Services\Http\Requests\Radarr\SearchByIdRequest as MovieSearchByIdRequest;
use App\Services\Http\Requests\Sonarr\AddSeriesRequest;
use App\Services\Http\Requests\Sonarr\SearchByIdRequest as SeriesSearchByIdRequest;
use App\Services\Http\Responses\Radarr\SearchByIdResponse as MovieSearchByIdResponse;
use App\Services\Http\Responses\Sonarr\SearchByIdResponse as SeriesSearchByIdResponse;

class RequestPutter
{
    public static function put(Request $request): void
    {
        if (ItemType::Movie === $request->type) {
            self::putMovie($request);
        } else {
            self::putSerie($request);
        }
    }

    private static function putMovie(Request $request): void
    {
        $client         = new Client();
        $search_request = new MovieSearchByIdRequest($request->item_id);

        $response = new MovieSearchByIdResponse(
            $client->doRequest($search_request)
        );

        $response = $client->doRequest(
            new AddMovieRequest($response->data)
        );
    }

    private static function putSerie(Request $request): void
    {
        $client         = new Client();
        $search_request = new SeriesSearchByIdRequest($request->item_id);

        $response = new SeriesSearchByIdResponse(
            $client->doRequest($search_request)
        );

        $response = $client->doRequest(
            new AddSeriesRequest($response->data)
        );
    }
}
