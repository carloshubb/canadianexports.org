<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingProgramSetting extends Model
{
    use HasFactory;

    protected $table = 'financing_program_setting';

    protected $guarded = [];

    public function financingProgramSettingDetail()
    {
        return $this->hasMany(FinancingProgramSettingDetail::class, "financing_program_id", "id");
    }
}
