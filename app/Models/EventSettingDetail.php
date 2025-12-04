<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'event_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function eventSetting()
    {
        return $this->belongsTo(EventSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
