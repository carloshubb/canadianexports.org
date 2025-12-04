<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneMoreThing extends Model
{
    use HasFactory;

    protected $table = 'one_more_thing';

    protected $guarded = [];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function oneMoreThingDetail()
    {
        return $this->hasMany(OneMoreThingDetail::class, "one_more_thing_id", "id");
    }
}
