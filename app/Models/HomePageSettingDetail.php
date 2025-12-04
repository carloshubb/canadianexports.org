<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'home_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function homePageSetting()
    {
        return $this->belongsTo(HomePageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
