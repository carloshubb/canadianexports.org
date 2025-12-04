<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessStoriesDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'success_stories_id' => $this->success_stories_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'primary_industry' => $this->primary_industry,
            'message' => $this->message,
            'successStories' => new SuccessStoriesResource($this->whenLoaded('successStories')),
        ];
    }
}
