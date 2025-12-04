<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMedia extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'event_media';

    public $timestamps = false;

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
