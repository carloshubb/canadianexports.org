<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatesSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'rates_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function ratesSetting()
    {
        return $this->belongsTo(RatesSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
