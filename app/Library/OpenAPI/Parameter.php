<?php

namespace App\Library\OpenAPI;

use App\Exceptions\PropWithoutTypeException;
use App\Models\BaseModel;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use ReflectionNamedType;
use ReflectionParameter;

class Parameter
{
    public string $name;
    public string $in = 'path';
    public bool $required;
    public string $description;
    public array $schema;

    private string $type;
    private ?FormRequest $request = null;
    private bool $add = false;

    public function __construct(ReflectionParameter $parameter)
    {
        if (! $parameter->hasType()) {
            throw new PropWithoutTypeException();
        }

        /** @var ReflectionNamedType $type */
        $type = $parameter->getType();
        $this->type = $type->getName();

        if (class_exists($type)) {
            /** @var BaseModel $model */
            $instance = new $this->type();

            if ($instance instanceof FormRequest) {
                $this->fromRequest($instance);
            } else if ($instance instanceof BaseModel) {
                $this->fromModel($instance);
            }
        }
    }
    
    public function shouldAdd(): bool
    {
        return $this->add;
    }

    public function isValidation(): bool
    {
        return $this->request instanceof FormRequest;
    }

    public function getRequest(): FormRequest
    {
        if ($this->request === null) {
            throw new Exception('Only call getRequest when request is not null');
        }

        return $this->request;
    }

    private function fromModel(BaseModel $model): void
    {
        $name = last(explode('\\', $this->type));

        $this->description = "Primary key of {$name}";
        $this->schema = [
            'type' => $model->getKeyType(),
        ];
        $this->add = true;
    }

    private function fromRequest(FormRequest $request): void
    {
        $this->request = $request;
        $this->add = true;
    }
}
