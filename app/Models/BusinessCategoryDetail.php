<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCategoryDetail extends Model
{
    use HasFactory;

    protected $fillable = ["business_category_id", "language_id", "name", "slug"];

    protected $table = 'business_category_detail';

    public $timestamps = false;

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
