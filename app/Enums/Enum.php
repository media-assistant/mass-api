<?php

namespace App\Enums;

use ReflectionClass;

abstract class Enum
{
    private function __construct()
    {
    }

    public static function getAll() {
        $class = new ReflectionClass(static::class);

        return $class->getConstants();
    }

    public static function getKeys() {
        return array_keys(self::getAll());
    }
    
    public static function getValues() {
        return array_values(self::getAll());
    }
}
