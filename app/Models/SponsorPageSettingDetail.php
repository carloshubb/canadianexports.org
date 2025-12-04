<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorPageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'sponsor_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function sponsorPageSetting()
    {
        return $this->belongsTo(SponsorPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
