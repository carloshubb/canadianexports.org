<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsPageSetting extends Model
{
    use HasFactory;

    protected $table = 'about_us_page_setting';

    protected $guarded = [];

    public function aboutUsPageSettingDetail()
    {
        return $this->hasMany(AboutUsPageSettingDetail::class, "about_us_page_setting_id", "id");
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
