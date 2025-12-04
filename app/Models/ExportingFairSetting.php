<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportingFairSetting extends Model
{
    use HasFactory;

    protected $table = 'exporting_fair_setting';

    protected $guarded = [];

    public function exportingFairSettingDetail()
    {
        return $this->hasMany(ExportingFairSettingDetail::class, "exporting_fair_setting_id", "id");
    }
}
