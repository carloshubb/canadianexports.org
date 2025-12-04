<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediaResource extends JsonResource
{

    public function toArray($request)
    {
        $base64 = null;

        if (Storage::disk('public')->exists($this->thumbnail_image)) {
            $fileContent = Storage::disk('public')->get($this->thumbnail_image);
            $base64 = "data:image/{$this->extension};base64," . base64_encode($fileContent);
        } elseif (file_exists(public_path($this->thumbnail_image))) {
            $fileContent = file_get_contents(public_path($this->thumbnail_image));
            $base64 = "data:image/{$this->extension};base64," . base64_encode($fileContent);
        }

        return [
            'id' => $this->id,
            'path' => $this->path,
            'thumbnail_image' => $this->thumbnail_image,
            'medium_image' => $this->medium_image,
            'large_image' => $this->large_image,
            'full_path' => asset($this->thumbnail_image),
            'base64' => $base64,
            'type' => $this->type,
            'extension' => $this->extension,
        ];
    }

}
