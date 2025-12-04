<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OneMoreThingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'one_more_thing_id' => $this->one_more_thing_id,
            'language_id' => $this->language_id,
            'description' => $this->description,
            'one_more_thing' => new OneMoreThingResource($this->whenLoaded('oneMoreThing')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
