<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticTranslation extends Model
{
    use HasFactory;

    protected $table = 'static_translation';

    protected $guarded = [];

    public function staticTranslationDetail()
    {
        return $this->hasMany(StaticTranslationDetail::class, "static_translation_id", "id");
    }
}
