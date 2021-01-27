<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AuthTest extends TestCase
{
    public function testIncorrectData(): void
    {
        $response = $this->json(Request::METHOD_POST, '/api/token', [
            'email'       => 'test@test.nl',
            'password'    => 'test',
            'device_name' => 'test',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
