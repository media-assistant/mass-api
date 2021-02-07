<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'text'  => $this->name,
            'value' => $this->id,
            'color' => $this->color,
            'icon'  => $this->icon,
        ];
    }
}
