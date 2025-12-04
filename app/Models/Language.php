<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
        'native_name',
        'is_default',
        'flag_icon',
        'direction',
    ];

    public function flagIcon()
    {
        return $this->hasOne(Media::class, 'id', 'flag_icon');
    }
}
