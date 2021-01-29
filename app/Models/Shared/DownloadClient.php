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

    public static function getDefaults(): array
    {
        $ip   = config('docker.transmission.ip');
        $port = config('docker.transmission.port');

        return [
            'Id'             => '1',
            'Enable'         => '1',
            'Name'           => 'Transmission',
            'Implementation' => 'Transmission',
            'Settings'       => "{
                'host': '{$ip}',
                'port': {$port},
                'urlBase': '/transmission/',
                'username': '',
                'password': '',
                'recentTvPriority': 0,
                'olderTvPriority': 0,
                'addPaused': false,
                'useSsl': false
            }",
            'ConfigContract' => 'TransmissionSettings',
        ];
    }
}
