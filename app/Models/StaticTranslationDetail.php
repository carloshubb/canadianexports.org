<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticTranslationDetail extends Model
{
    use HasFactory;

    protected $table = 'static_translation_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function staticTranslation()
    {
        return $this->belongsTo(StaticTranslation::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
