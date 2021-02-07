<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin \App\Models\Request\Request
 */
class RequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                      => $this->id,
            'type'                    => $this->type,
            'item_id'                 => $this->item_id,
            'text'                    => $this->text,
            'image_url'               => str_replace('http://', 'https://', $this->image_url),
            'status'                  => new RequestStatusResource($this->whenLoaded('status')),
            'updated_at'              => $this->updated_at,
            'created_at'              => $this->created_at,
            'created_by_current_user' => $this->created_by === Auth::id(),
        ];
    }
}
