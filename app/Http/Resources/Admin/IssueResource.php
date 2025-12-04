<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'media_id' => $this->media_id,
            'pdf' => $this->pdf,
            'pdf_path' => asset($this->pdf),
            'is_current_issue' => $this->is_current_issue,
            'issue_detail' => IssueDetailResource::collection($this->whenLoaded('issueDetail')),
            'media' => new MediaResource($this->whenLoaded('media')),
        ];
    }
}
