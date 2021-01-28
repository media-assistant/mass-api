<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class DockerTest extends TestCase
{
    public function testGetMovies(): void
    {
        $response = $this->json(Request::METHOD_GET, '/api/radarr/movie');

        $response->assertStatus(Response::HTTP_OK);
    }
}
