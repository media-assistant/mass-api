<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

/**
 * @internal
 * @coversNothing
 */
abstract class ExternalTestCase extends TestCase
{
    use RefreshDatabase;

    protected function assertRouteOk(string $route, string $method = Request::METHOD_GET, int $response_code = Response::HTTP_OK): void
    {
        $this->skipIfEnv();

        Sanctum::actingAs(User::factory()->create(), ['*']);

        $response = $this->json($method, $route);

        $response->assertStatus($response_code);
    }

    private function skipIfEnv(): void
    {
        if (env('SKIP_EXTERNAL_TESTS', false)) {
            $this->markTestSkipped('Skipped according to .env');
        }
    }
}
