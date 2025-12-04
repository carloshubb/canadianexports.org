<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStoriesDetail extends Model
{
    use HasFactory;

    protected $table = 'success_stories_details';

    protected $guarded = [];

    public $timestamps = false;

    public function successStories()
    {
        return $this->belongsTo(SuccessStories::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
