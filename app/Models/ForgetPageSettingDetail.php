<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForgetPageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'forget_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function forgetPageSetting()
    {
        return $this->belongsTo(ForgetPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
