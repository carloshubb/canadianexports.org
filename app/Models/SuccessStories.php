<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStories extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function successStoriesDetail()
    {
        return $this->hasMany(SuccessStoriesDetail::class, 'success_stories_id');
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class);
    }
}
