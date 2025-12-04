<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingProgramDetail extends Model
{
    use HasFactory;

    protected $table = 'financing_program_details';

    protected $guarded = [];

    public $timestamps = false;

    public function financingProgram()
    {
        return $this->belongsTo(FinancingProgram::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
