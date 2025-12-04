<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegPageSetting extends Model
{
    use HasFactory;

    protected $table = 'reg_page_setting';

    protected $guarded = [];


    public function regPageSettingDetail()
    {
        return $this->hasMany(RegPageSettingDetail::class, "reg_page_setting_id", "id");
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
