<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScamAlertSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'scam_alert_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function scamAlertSetting()
    {
        return $this->belongsTo(ScamAlertSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
