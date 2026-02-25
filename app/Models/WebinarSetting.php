<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarSetting extends Model
{
    use HasFactory;

    protected $table = 'webinar_setting';

    protected $guarded = [];

    public function webinarSettingDetail()
    {
        return $this->hasMany(WebinarSettingDetail::class, 'webinar_setting_id', 'id');
    }
}
