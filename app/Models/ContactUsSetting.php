<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsSetting extends Model
{
    use HasFactory;

    protected $table = 'contact_us_setting';

    protected $guarded = [];

    public function contactUsSettingDetail()
    {
        return $this->hasMany(ContactUsSettingDetail::class, "contact_us_setting_id", "id");
    }
}
