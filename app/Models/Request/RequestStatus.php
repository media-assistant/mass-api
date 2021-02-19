<?php

namespace App\Models\Request;

use App\Models\BaseModel;

/**
 * App\Models\Request\RequestStatus.
 *
 * @property int    $id
 * @property string $name
 * @property string $color
 * @property string $icon
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RequestStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestStatus whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestStatus whereName($value)
 * @mixin \Eloquent
 */
class RequestStatus extends BaseModel
{
    public const REQUEST     = 1;
    public const APPROVED    = 2;
    public const DOWNLOADING = 3;
    public const DONE        = 4;
    public const DENIED      = 5;
    public const ERROR       = 6;
}
