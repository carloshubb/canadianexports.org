<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSignupSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'event_signup_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function eventSignupSetting()
    {
        return $this->belongsTo(EventSignupSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
