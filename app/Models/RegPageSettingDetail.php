<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegPageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'reg_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function regPageSetting()
    {
        return $this->belongsTo(RegPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
