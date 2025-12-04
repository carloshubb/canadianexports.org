<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventListingSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'event_listing_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function eventListingSetting()
    {
        return $this->belongsTo(EventListingSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
