<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class I2BSetting extends Model
{
    use HasFactory;

    protected $table = 'i2b_setting';

    protected $guarded = [];

    public function i2BSettingDetail()
    {
        return $this->hasMany(I2BSettingDetail::class, "i2b_setting_id", "id");
    }
}
