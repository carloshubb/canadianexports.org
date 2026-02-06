<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorDowngradeRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'current_amount' => 'float',
        'requested_amount' => 'float',
        'current_period_end' => 'date',
        'requested_at' => 'datetime',
        'applied_at' => 'datetime',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function scopePending($query)
    {
        return $query->whereNull('applied_at');
    }
}
