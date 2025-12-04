<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsPageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'about_us_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function aboutUsPageSetting()
    {
        return $this->belongsTo(AboutUsPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
