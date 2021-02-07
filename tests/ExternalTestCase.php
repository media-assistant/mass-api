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

    protected function skipIfEnv(): void
    {
        if (env('SKIP_EXTERNAL_TESTS', false)) {
            $this->markTestSkipped('Skipped according to .env');
        }
    }
}
