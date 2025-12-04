<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneMoreThingDetail extends Model
{
    use HasFactory;

    protected $fillable = ["one_more_thing_id", "language_id", "description"];

    protected $table = 'one_more_thing_detail';

    public $timestamps = false;

    public function oneMoreThing()
    {
        return $this->belongsTo(OneMoreThing::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
