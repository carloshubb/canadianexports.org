<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;

    protected $fillable = ["event_id", "language_id", "title", "country", "city", "street_name", "venue", "product_search", "short_description", "description"];

    protected $table = 'event_detail';

    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
