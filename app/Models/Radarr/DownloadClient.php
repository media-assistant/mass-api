<?php

namespace App\Models\Radarr;

use App\Models\Shared\DownloadClient as SharedDownloadClient;

/**
 * App\Models\Radarr\DownloadClient.
 *
 * @property int    $Id
 * @property int    $Enable
 * @property string $Name
 * @property string $Implementation
 * @property string $Settings
 * @property string $ConfigContract
 * @property int    $Priority
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient whereConfigContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient whereImplementation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadClient whereSettings($value)
 * @mixin \Eloquent
 */
class DownloadClient extends SharedDownloadClient
{
    protected $connection = 'radarr_sqlite';

    public static function getDefaults(): array
    {
        $url = config('docker.transmission.url');

        [$protocol, $url] = explode('://', $url);
        [$host, $port]    = explode(':', $url);

        return [
            'Id'             => '1',
            'Enable'         => '1',
            'Name'           => 'Transmission',
            'Implementation' => 'Transmission',
            'Settings'       => '{
                "host": "' . $host . '",
                "port": ' . $port . ',
                "urlBase": "/transmission/",
                "recentMoviePriority": 0,
                "olderMoviePriority": 0,
                "addPaused": false,
                "useSsl": false
            }',
            'ConfigContract' => 'TransmissionSettings',
            'Priority'       => '1',
        ];
    }
}
