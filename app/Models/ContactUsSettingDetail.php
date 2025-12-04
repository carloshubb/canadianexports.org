<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'contact_us_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function contactUsSetting()
    {
        return $this->belongsTo(ContactUsSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
