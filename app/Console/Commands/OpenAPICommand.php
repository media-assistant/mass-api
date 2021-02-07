<?php

namespace App\Console\Commands;

use App\Library\OpenAPI\OpenAPI;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class OpenAPICommand extends Command
{
    protected $signature   = 'openapi:generate';
    protected $description = 'Generates OpenAPI JSON file.';

    public function handle(): int
    {
        $openapi = new OpenAPI();


        return 0;
    }
}
