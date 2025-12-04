<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponserListingSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'sponser_listing_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function sponserListingSetting()
    {
        return $this->belongsTo(SponserListingSetting::class);
    }
}
