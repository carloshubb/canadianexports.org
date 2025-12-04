<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialSetting extends Model
{
    use HasFactory;

    protected $table = 'testimonial_setting';

    protected $guarded = [];

    public function testimonialSettingDetail()
    {
        return $this->hasMany(TestimonialSettingDetail::class, "testimonial_setting_id", "id");
    }
}
