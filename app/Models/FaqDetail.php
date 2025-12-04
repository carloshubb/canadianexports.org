<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqDetail extends Model
{
    use HasFactory;

    protected $table = 'faq_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function Faq()
    {
        return $this->belongsTo(Faq::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
