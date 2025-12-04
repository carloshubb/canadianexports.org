<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqImporterSetting extends Model
{
    use HasFactory;

    protected $table = 'faq_importer_setting';

    protected $guarded = [];

    public function faqImporterSettingDetail()
    {
        return $this->hasMany(FaqImporterSettingDetail::class, "faq_importer_setting_id", "id");
    }
}
