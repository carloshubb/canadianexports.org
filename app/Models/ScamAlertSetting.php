<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScamAlertSetting extends Model
{
    use HasFactory;

    protected $table = 'scam_alert_setting';

    protected $guarded = [];

    public function scamAlertSettingDetail()
    {
        return $this->hasMany(ScamAlertSettingDetail::class, "scam_alert_setting_id", "id");
    }
}
