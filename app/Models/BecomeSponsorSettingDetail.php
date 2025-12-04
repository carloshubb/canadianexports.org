<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecomeSponsorSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'become_sponsor_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function becomeSponsorSetting()
    {
        return $this->belongsTo(BecomeSponsorSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
