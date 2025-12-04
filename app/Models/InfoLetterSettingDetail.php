<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoLetterSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'info_letter_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function infoLetterSetting()
    {
        return $this->belongsTo(InfoLetterSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
