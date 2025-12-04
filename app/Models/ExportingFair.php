<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportingFair extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }


    public function exportingFairDetail()
    {
        return $this->hasMany(ExportingFairDetail::class, 'exporting_fair_id', 'id');
    }
}
