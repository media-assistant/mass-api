<?php

namespace App\Models\Shared;

use App\Models\BaseModel;

abstract class DownloadClient extends BaseModel
{
    protected $table = 'DownloadClients';

    public static function getDescription(): string
    {
        return 'Transmission client';
    }
}
