<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportingFairDetail extends Model
{
    use HasFactory;

    protected $fillable = ["exporting_fair_id", "language_id", "title", 'address', "country", 'zipcode', "city", "street_name", "venue", "product_search", "short_description", "description"];

    protected $table = 'exporting_fair_detail';

    public $timestamps = false;

    public function exportingFair()
    {
        return $this->belongsTo(ExportingFair::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
