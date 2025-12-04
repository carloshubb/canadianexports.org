<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatesSetting extends Model
{
    use HasFactory;

    protected $table = 'rates_setting';

    protected $guarded = [];

    public function ratesSettingDetail()
    {
        return $this->hasMany(RatesSettingDetail::class, "rates_setting_id", "id");
    }
}
