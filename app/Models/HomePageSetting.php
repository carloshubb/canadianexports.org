<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    use HasFactory;

    protected $table = 'home_page_setting';

    protected $guarded = [];

    public function homePageSettingDetail()
    {
        return $this->hasMany(HomePageSettingDetail::class, "home_page_setting_id", "id");
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
