<?php

namespace App\Models\Shared;

use App\Models\BaseModel;

abstract class RootFolder extends BaseModel
{
    protected $table = 'RootFolders';

    protected static function getPath(): string
    {
        return '';
    }

    public static function getDescription(): string
    {
        return 'Root folder';
    }

    public static function getDefaults(): array
    {
        return [
            'Id'   => '1',
            'path' => self::getPath(),
        ];
    }
}
