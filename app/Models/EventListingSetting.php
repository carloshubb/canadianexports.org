<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventListingSetting extends Model
{
    use HasFactory;

    protected $table = 'event_listing_setting';

    protected $guarded = [];

    public function eventListingSettingDetail()
    {
        return $this->hasMany(EventListingSettingDetail::class, "event_listing_setting_id", "id");
    }
}
