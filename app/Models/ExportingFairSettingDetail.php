<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportingFairSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'exporting_fair_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function exportingFairSetting()
    {
        return $this->belongsTo(ExportingFairSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
