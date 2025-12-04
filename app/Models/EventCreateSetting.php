<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCreateSetting extends Model
{
    use HasFactory;

    protected $table = 'event_create_setting';

    protected $guarded = [];

    public function eventCreateSettingDetail()
    {
        return $this->hasMany(EventCreateSettingDetail::class, "event_create_setting_id", "id");
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
