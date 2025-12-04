<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloseAccountSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'close_account_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function closeAccountSetting()
    {
        return $this->belongsTo(CloseAccountSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
