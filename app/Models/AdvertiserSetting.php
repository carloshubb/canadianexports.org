<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserSetting extends Model
{
    use HasFactory;

    protected $table = 'advertiser_setting';

    protected $guarded = [];

    public function advertiserSettingDetail()
    {
        return $this->hasMany(AdvertiserSettingDetail::class, "advertiser_setting_id", "id");
    }
}
