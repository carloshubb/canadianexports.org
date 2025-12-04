<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingProgram extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function financingProgramDetail()
    {
        return $this->hasMany(FinancingProgramDetail::class, "financing_program_id", "id");
    }

    public function businessCategories()
    {
        return $this->belongsToMany(BusinessCategory::class, 'financing_program_business_category');
    }
}
