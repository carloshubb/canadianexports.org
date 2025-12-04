<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqExporterSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'faq_exporter_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function faqExporterSetting()
    {
        return $this->belongsTo(FaqExporterSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
