<?php

namespace App\Services\Http\Data;

use App\Traits\ConvertFromObject;
use stdClass;

class AddItemData
{
    use ConvertFromObject;

    public int $qualityProfileId;
    public int $tmdbId;
    public int $tvdbId;
    public string $path;
    public bool $monitored;
    public array $addOptions = [
        'searchForMovie' => true,
    ];

    private string $title;
    private int $year;

    public function __construct(stdClass $data)
    {
        $this->fromObject($data);

        // TODO
        $this->qualityProfileId = 1;
        $this->path             = config('docker.radarr.folder') . $this->title . ' (' . $this->year . ')';
        $this->monitored        = true;
    }
}
