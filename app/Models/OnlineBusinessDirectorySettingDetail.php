<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineBusinessDirectorySettingDetail extends Model
{
    use HasFactory;

    protected $table = 'online_business_directory_setting_detail';

    public $timestamps = false;

    protected $guarded = [];

    public function onlineBusinessDirectorySetting()
    {
        return $this->belongsTo(OnlineBusinessDirectorySetting::class, "online_business_directory_setting_id", "id");
    }
}
