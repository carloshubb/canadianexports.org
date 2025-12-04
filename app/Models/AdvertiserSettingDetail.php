<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'advertiser_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function advertiserSetting()
    {
        return $this->belongsTo(AdvertiserSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
