<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends TestCase
{
    public function testBasicTest(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
