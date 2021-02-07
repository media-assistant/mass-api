<?php

namespace App\Library\OpenAPI;

use App\Enums\AppName;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use JsonSerializable;

class OpenAPI implements JsonSerializable
{
    public Collection $paths;

    public function __construct()
    {
        $this->paths = collect();

        foreach (Route::getRoutes()->getRoutes() as $route) {
            if (! str_contains($route->getPrefix() ?? '', 'api')) {
                continue;
            }

            $skip = false;
            foreach (AppName::getValues() as $app) {
                if (str_contains($route->uri, "api/{$app}")) {
                    $skip = true;
                    continue;
                }
            }

            if ($skip) {
                continue;
            }

            $path = new Path($route);
            $this->paths->put($path->getUri(), [$path->getMethod() => $path]);
        }
        dd(json_decode(json_encode($this)));
    }

    public function jsonSerialize(): array
    {
        return [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'Mass API',
                'description' => 'Mass API',
                'version' => '1',
            ],
            'servers' => [
                [
                    'url' => 'url',
                    'description' => 'url',
                ]
            ],
            'paths' => $this->paths,
        ];
    }
}
