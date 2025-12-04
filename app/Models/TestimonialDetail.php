<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialDetail extends Model
{
    use HasFactory;

    protected $table = 'testimonial_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
