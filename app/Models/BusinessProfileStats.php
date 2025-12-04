<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProfileStats extends Model
{
    use HasFactory;

    protected $table = 'business_profile_stats';

    protected $guarded = [];


    public function visitor()
    {
        return $this->belongsTo(VisitorInfo::class, 'visitor_info_id');
    }

    public function customerProfile()
    {
        return $this->belongsTo(CustomerProfile::class);
    }
}
