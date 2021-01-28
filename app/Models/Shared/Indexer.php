<?php

namespace App\Models\Shared;

use App\Models\BaseModel;

/**
 * App\Models\Shared\Indexer.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer query()
 * @mixin \Eloquent
 */
class Indexer extends BaseModel
{
    protected $table = 'Indexers';

    public static function getDescription(): string
    {
        return 'Jackett indexer';
    }
}
