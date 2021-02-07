<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

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
