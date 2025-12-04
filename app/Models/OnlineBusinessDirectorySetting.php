<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineBusinessDirectorySetting extends Model
{
    use HasFactory;

    protected $table = 'online_business_directory_setting';

    protected $guarded = [];

    public function onlineBusinessDirectorySettingDetail()
    {
        return $this->hasMany(OnlineBusinessDirectorySettingDetail::class, "online_business_directory_setting_id", "id");
    }
}
