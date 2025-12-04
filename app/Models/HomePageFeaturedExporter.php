<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageFeaturedExporter extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'business_category_id',
    ];
    public $timestamps = false;

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
