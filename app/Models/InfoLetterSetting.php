<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoLetterSetting extends Model
{
    use HasFactory;

    protected $table = 'info_letter_setting';

    protected $guarded = [];

    public function infoLetterSettingDetail()
    {
        return $this->hasMany(InfoLetterSettingDetail::class, "info_letter_setting_id", "id");
    }
}
