<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecomeSponsorSetting extends Model
{
    use HasFactory;

    protected $table = 'become_sponsor_setting';

    protected $guarded = [];

    public function becomeSponsorSettingDetail()
    {
        return $this->hasMany(BecomeSponsorSettingDetail::class, "become_sponsor_setting_id", "id");
    }
}
