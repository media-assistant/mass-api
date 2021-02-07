<?php

namespace Tests\Feature;

use App\Models\Request\Request;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\ExternalTestCase;

/**
 * @internal
 * @coversNothing
 */
class RequestTest extends ExternalTestCase
{
    public function testPermissions(): void
    {
        $response = $this->get('/api/requests');
        $response->assertUnauthorized();

        $response = $this->put('/api/requests');
        $response->assertUnauthorized();

        $response = $this->delete('/api/requests/1');
        $response->assertUnauthorized();
    }

    public function testCrud(): void
    {
        $this->setUser();

        $response = $this->putJson('/api/requests', [
            'item' => [
                'tmdb_id' => 732450,
                'text'    => 'Batman :D',
                'images'  => [],
            ],
        ]);
        $response->assertCreated();

        $response = $this->putJson('/api/requests', [
            'item' => [
                'tvdb_id' => 361753,
                'text'    => 'Mando :D',
                'images'  => [],
            ],
        ]);
        $response->assertCreated();

        $requests = Request::all();
        $this->assertCount(2, $requests);

        $response = $this->get('/api/requests');
        $response->assertOk();
        $response->assertJsonCount(2);

        foreach ($requests as $request) {
            $response = $this->delete("/api/requests/{$request->id}");
            $response->assertOk();
        }

        $this->assertEquals(0, Request::count());
    }

    private function setUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole('admin');

        Sanctum::actingAs($user, ['*']);
    }
}
