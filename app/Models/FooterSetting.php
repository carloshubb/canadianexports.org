<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $table = 'footer_setting';

    protected $guarded = [];

    public function footerSettingDetail()
    {
        return $this->hasMany(FooterSettingDetail::class, "footer_setting_id", "id");
    }

    public function widget1Menu()
    {
        return $this->belongsTo(Menu::class, 'widget1_menu_id', 'id');
    }

    public function widget2Menu()
    {
        return $this->belongsTo(Menu::class, 'widget2_menu_id', 'id');
    }

    public function widget3Menu()
    {
        return $this->belongsTo(Menu::class, 'widget3_menu_id', 'id');
    }
}
