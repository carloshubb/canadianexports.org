<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingProgramSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'financing_program_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function financingProgramSetting()
    {
        return $this->belongsTo(FinancingProgramSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
