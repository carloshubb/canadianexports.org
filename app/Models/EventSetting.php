<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSetting extends Model
{
    use HasFactory;

    protected $table = 'event_setting';

    protected $guarded = [];

    public function eventSettingDetail()
    {
        return $this->hasMany(EventSettingDetail::class, "event_setting_id", "id");
    }
}
