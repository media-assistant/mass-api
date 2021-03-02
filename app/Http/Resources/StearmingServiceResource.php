<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StearmingServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'provider' => $this->provider_id,
            'quality' => $this->presentation_type,
            'url' => ((array) $this->urls)[0] ?? null,
        ];
    }
}
