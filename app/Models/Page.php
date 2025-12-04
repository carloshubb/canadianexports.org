<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function pageDetail()
    {
        return $this->hasMany(PageDetail::class, "page_id", "id");
    }


    public function homePageFeaturedExporter()
    {
        return $this->hasMany(HomePageFeaturedExporter::class, "page_id", "id");
    }

    public function facebook()
    {
        return $this->belongsTo(Media::class, 'facebook_media_id', 'id');
    }
}
