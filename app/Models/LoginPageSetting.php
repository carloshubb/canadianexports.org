<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginPageSetting extends Model
{
    use HasFactory;

    protected $table = 'login_page_setting';

    protected $guarded = [];

    public function loginPageSettingDetail()
    {
        return $this->hasMany(LoginPageSettingDetail::class, "login_page_setting_id", "id");
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
