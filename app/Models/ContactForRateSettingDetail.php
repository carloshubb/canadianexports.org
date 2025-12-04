<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForRateSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'contact_for_rate_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function contactForRateSetting()
    {
        return $this->belongsTo(ContactForRateSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
