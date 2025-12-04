<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloseAccountSetting extends Model
{
    use HasFactory;

    protected $table = 'close_account_setting';

    protected $guarded = [];

    public function closeAccountSettingDetail()
    {
        return $this->hasMany(CloseAccountSettingDetail::class, "close_account_setting_id", "id");
    }
}
