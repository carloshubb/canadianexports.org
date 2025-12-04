<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCreateSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'event_create_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function eventCreateSetting()
    {
        return $this->belongsTo(EventCreateSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
