<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function businessCategoryDetail()
    {
        return $this->hasMany(BusinessCategoryDetail::class, "business_category_id", "id");
    }
}
