<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorPageSetting extends Model
{
    use HasFactory;

    protected $table = 'sponsor_page_setting';

    protected $guarded = [];

    public function sponsorPageSettingDetail()
    {
        return $this->hasMany(SponsorPageSettingDetail::class, "sponsor_page_setting_id", "id");
    }
}
