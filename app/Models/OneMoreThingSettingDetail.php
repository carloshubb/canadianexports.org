<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneMoreThingSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'one_more_thing_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function oneMoreThingSetting()
    {
        return $this->belongsTo(OneMoreThingSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
