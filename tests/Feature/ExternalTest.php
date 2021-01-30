<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ExternalTest extends TestCase
{
    use RefreshDatabase;

    public function testRadarr(): void
    {
        $this->assertRouteOk('/api/radarr/movie/lookup?term=batman');
    }

    public function testSonarr(): void
    {
        $this->assertRouteOk('/api/sonarr/series/lookup?term=mandolorian');
    }

    private function skipIfEnv(): void
    {
        if (env('SKIP_EXTERNAL_TESTS', false)) {
            $this->markTestSkipped('Skipped according to .env');
        }
    }

    private function assertRouteOk(string $route, string $method = Request::METHOD_GET, int $response_code = Response::HTTP_OK): void
    {
        $this->skipIfEnv();

        Sanctum::actingAs(User::factory()->create(), ['*']);

        $response = $this->json($method, $route);

        $response->assertStatus($response_code);
    }
}
