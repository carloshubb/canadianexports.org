<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSignupSetting extends Model
{
    use HasFactory;

    protected $table = 'event_signup_setting';

    protected $guarded = [];

    public function eventSignupSettingDetail()
    {
        return $this->hasMany(EventSignupSettingDetail::class, "event_signup_setting_id", "id");
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
