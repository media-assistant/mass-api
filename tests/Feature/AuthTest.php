<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testAuth(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(0, $user->tokens()->get());

        $response = $this->json(Request::METHOD_POST, '/api/token', [
            'email'       => $user->email,
            'password'    => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'token',
        ]);

        $this->assertCount(1, $user->tokens()->get());

        $token = $response->json('token');

        $response = $this->get('/api/ping', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertOk();
        $response->assertExactJson(['pong']);
    }

    public function testNoAuth(): void
    {
        $response = $this->get('/api/ping');

        $response->assertUnauthorized();
    }
}
