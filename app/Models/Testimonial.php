<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function testimonialDetail()
    {
        return $this->hasMany(TestimonialDetail::class, "testimonial_id", "id");
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class);
    }
}
