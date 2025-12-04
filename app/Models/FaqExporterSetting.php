<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqExporterSetting extends Model
{
    use HasFactory;

    protected $table = 'faq_exporter_setting';

    protected $guarded = [];

    public function faqExporterSettingDetail()
    {
        return $this->hasMany(FaqExporterSettingDetail::class, "faq_exporter_setting_id", "id");
    }
}
