<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class OpenAPICommand extends Command
{
    protected $signature = 'openapi:generate';
    protected $description = 'Generates OpenAPI JSON file.';

    public function handle(): int
    {
        foreach (Route::getRoutes()->getRoutes() as $route) {
            if (! str_contains($route->getPrefix() ?? '', 'api')){
                continue;
            }

            // TODO
            dump($route->getAction());
        }

        return 0;
    }
}
