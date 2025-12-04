<?php

namespace App\Http\Resources\Admin;

use App\Models\Media;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralSettingResource extends JsonResource
{
    public function toArray($request)
    {
        $facebook = null;
        if($this->key == 'facebook_meta_image' && $this->value != null){
            $media = Media::whereId($this->value)->first();
            $facebook = $media ? new MediaResource($media) : null;
        }
        return [
            'id' => $this->id,
            'display_text' => $this->display_text,
            'key' => $this->key,
            'type' => $this->type,
            'value' => $this->value,
            'facebook' => $facebook,
        ];
    }
}
