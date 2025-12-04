<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginPageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'login_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function loginPageSetting()
    {
        return $this->belongsTo(LoginPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
