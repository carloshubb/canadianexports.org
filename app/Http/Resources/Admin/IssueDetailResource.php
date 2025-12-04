<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class IssueDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'issue_id' => $this->issue_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'issue' => new IssueResource($this->whenLoaded('issue')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
