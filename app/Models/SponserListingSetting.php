<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponserListingSetting extends Model
{
    use HasFactory;
    protected $table = 'sponser_listing_setting';

    protected $guarded = [];

    public function sponserListingSettingDetail()
    {
        return $this->hasMany(SponserListingSettingDetail::class, "sponser_list_setting_id", "id");
    }
}
