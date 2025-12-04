<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForRateSetting extends Model
{
    use HasFactory;

    protected $table = 'contact_for_rate_setting';

    protected $guarded = [];

    public function contactForRateSettingDetail()
    {
        return $this->hasMany(ContactForRateSettingDetail::class, "contact_for_rate_setting_id", "id");
    }
}
