<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class I2BSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'i2b_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function i2BSetting()
    {
        return $this->belongsTo(I2BSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
