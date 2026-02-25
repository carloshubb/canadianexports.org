<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'webinar_setting_detail';

    protected $guarded = [];

    public function webinarSetting()
    {
        return $this->belongsTo(WebinarSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
