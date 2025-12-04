<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqImporterSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'faq_importer_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function faqImporterSetting()
    {
        return $this->belongsTo(FaqImporterSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
