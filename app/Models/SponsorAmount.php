<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorAmount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
        'amount' => 'decimal:2',
    ];

    // Frequency options: one_time, monthly, quarterly, annually
    public static $frequencies = [
        'one_time' => 'One Time',
        'monthly' => 'Monthly',
        'quarterly' => 'Quarterly',
        'annually' => 'Annually'
    ];
}
