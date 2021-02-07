<?php

namespace App\Traits;

trait ConvertFromObject
{
    protected array $skip = [];

    protected function fromObject(object $object): void
    {
        foreach ($object as $key => $value) {
            $skip = in_array($key, $this->skip);

            if (! $skip && self::propertyExists($key)) {
                $this->{$key} = $value;
            }
        }
    }

    protected static function propertyExists(string $key): bool
    {
        return property_exists(self::class, $key);
    }
}
