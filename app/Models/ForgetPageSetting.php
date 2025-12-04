<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForgetPageSetting extends Model
{
    use HasFactory;

    protected $table = 'forget_page_setting';

    protected $guarded = [];

    public function forgetPageSettingDetail()
    {
        return $this->hasMany(ForgetPageSettingDetail::class, "forget_page_setting_id", "id");
    }
}
