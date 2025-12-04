<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OneMoreThingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'media_id' => $this->media_id,
            'media_id' => $this->media_id,
            'one_more_thing_detail' => OneMoreThingDetailResource::collection($this->whenLoaded('oneMoreThingDetail')),
            'media' => new MediaResource($this->whenLoaded('media')),
        ];
    }
}
