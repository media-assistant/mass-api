<?php

namespace App\Models\Sonarr;

use App\Models\Shared\Indexer as SharedIndexer;

/**
 * App\Models\Sonarr\Indexer.
 *
 * @property int         $Id
 * @property string      $Name
 * @property string      $Implementation
 * @property string|null $Settings
 * @property string|null $ConfigContract
 * @property int|null    $EnableRss
 * @property int|null    $EnableSearch
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereConfigContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereEnableRss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereEnableSearch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereImplementation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereSettings($value)
 * @mixin \Eloquent
 */
class Indexer extends SharedIndexer
{
    protected $connection = 'sonarr_sqlite';

    public static function getDefaults(): array
    {
        $host    = config('docker.jackett.host');
        $port    = config('docker.jackett.port');
        $api_key = config('docker.jackett.api_key');

        return [
            'Id'             => '1',
            'Name'           => 'Jackett',
            'Implementation' => 'Torznab',
            'Settings'       => "{
    'minimumSeeders': 1,
    'seedCriteria': {},
    'baseUrl': 'http://{$host}:{$port}/torznab/all',
    'apiPath': '/api',
    'apiKey': '{$api_key}',
    'categories': [
        5030,
        5040
    ],
    'animeCategories': []
}",
            'ConfigContract' => 'TorznabSettings',
            'EnableRss'      => '1',
            'EnableSearch'   => '1',
        ];
    }
}
