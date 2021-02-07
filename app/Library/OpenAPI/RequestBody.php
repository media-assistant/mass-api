<?php

namespace App\Library\OpenAPI;

use Illuminate\Foundation\Http\FormRequest;

class RequestBody
{
    public bool $required = true;
    public array $content = [
        'application/json' => [
            'schema' => [
                'type'=> 'object',
                'properties'=> [],
            ]
        ]
    ];

    public function __construct(FormRequest $request)
    {
        foreach ($request->rules() as $key => $rule) {
            $this->addProperty($key, $rule);
        }
    }

    private function addProperty(string $key, string $rule)
    {
        $this->addToContent($key, $this->ruleToType($rule));
    }

    private function addToContent(string $key, string $type)
    {
        array_push(
            $this->content['application/json']['schema']['properties'],
            [
                $key => [
                    'type' => $type,
                ]
            ]
        );
    }

    private function ruleToType(string $rule): string
    {
        if (str_contains($rule, 'integer')) {
            return 'integer';
        }

        if (str_contains($rule, 'array')) {
            return 'array';
        }

        return 'string';
    }
}
