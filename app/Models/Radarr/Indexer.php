<?php

namespace App\Models\Radarr;

use App\Models\Shared\Indexer as SharedIndexer;

/**
 * App\Models\Radarr\Indexer.
 *
 * @property int         $Id
 * @property string      $Name
 * @property string      $Implementation
 * @property string|null $Settings
 * @property string|null $ConfigContract
 * @property int|null    $EnableRss
 * @property int|null    $EnableAutomaticSearch
 * @property int         $EnableInteractiveSearch
 * @property int         $Priority
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereConfigContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereEnableAutomaticSearch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereEnableInteractiveSearch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereEnableRss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereImplementation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereSettings($value)
 * @mixin \Eloquent
 */
class Indexer extends SharedIndexer
{
    protected $connection = 'radarr_sqlite';

    public static function getDefaults(): array
    {
        $url     = config('docker.jackett.url');
        $api_key = config('docker.jackett.api_key');

        return [
            'Id'             => '2',
            'Name'           => 'Jackett',
            'Implementation' => 'Torznab',
            'Settings'       => '
{
    "minimumSeeders": 1,
    "seedCriteria": {},
    "requiredFlags": [],
    "baseUrl": "' . $url . '/torznab/all",
    "apiPath": "/api",
    "multiLanguages": [],
    "apiKey": "' . $api_key . '",
    "categories": [
        2000,
        2010,
        2020,
        2030,
        2035,
        2040,
        2045,
        2050,
        2060
    ],
    "removeYear": false
}',
            'ConfigContract'          => 'TorznabSettings',
            'EnableRss'               => '1',
            'EnableAutomaticSearch'   => '1',
            'EnableInteractiveSearch' => '1',
            'Priority'                => '25',
        ];
    }
}
