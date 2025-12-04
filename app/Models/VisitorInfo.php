<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorInfo extends Model
{
    use HasFactory;

    protected $table = 'visitor_info';

    protected $guarded = [];


    public function businessProfileStats()
    {
        return $this->hasMany(BusinessProfileStats::class, 'visitor_info_id', 'id');
    }
}
