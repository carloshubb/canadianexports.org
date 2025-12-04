<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'testimonial_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function testimonialSetting()
    {
        return $this->belongsTo(TestimonialSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
