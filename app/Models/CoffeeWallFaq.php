<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeWallFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'question',
        'answer',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Scope a query to only include active FAQs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include donor FAQs.
     */
    public function scopeDonor($query)
    {
        return $query->where('type', 'donor');
    }

    /**
     * Scope a query to only include beneficiary FAQs.
     */
    public function scopeBeneficiary($query)
    {
        return $query->where('type', 'beneficiary');
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}

