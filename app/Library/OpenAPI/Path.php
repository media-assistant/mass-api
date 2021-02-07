<?php

namespace App\Library\OpenAPI;

use Illuminate\Routing\Route;

class Path
{
    public string $summary;
    public string $description;
    public array $responses = [];
    public array $parameters = [];
    public RequestBody $request_body;

    private string $uri;
    private string $method;
    private Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;

        $this->method = $route->methods[0];
        $this->uri = $route->uri;

        $this->addParameters();
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return strtolower($this->method);
    }

    private function addParameters(): void
    {
        foreach ($this->route->signatureParameters() as $route_parameter) {
            $parameter = new Parameter($route_parameter);

            if (! $parameter->shouldAdd()) {
                continue;
            }

            if ($parameter->isValidation()) {
                $this->addValidation($parameter);
            } else {
                array_push($this->parameters, $parameter);
            }
        }
    }

    private function addValidation(Parameter $parameter): void
    {
        $request = $parameter->getRequest();

        if (! method_exists($request, 'rules')) {
            return;
        }

        $this->request_body = new RequestBody($request);
    }
}
