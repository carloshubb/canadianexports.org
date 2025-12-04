<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneMoreThingSetting extends Model
{
    use HasFactory;

    protected $table = 'one_more_thing_setting';

    protected $guarded = [];

    public function oneMoreThingSettingDetail()
    {
        return $this->hasMany(OneMoreThingSettingDetail::class, "one_more_thing_setting_id", "id");
    }
}
